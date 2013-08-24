<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/admin
	 *	- or -  
	 * 		http://example.com/index.php/admin/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/admin/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function Main()
	{
		parent::Controller();
		$this->load->model('user_model');
	}
	
	function login()
	{
		$this->load->model('user_model');
		$this->form_validation->set_rules('userEmail', 'email', 'trim|required|valid_email|callback__check_login');
		$this->form_validation->set_rules('userPassword', 'password', 'trim|required');
		
		//if($this->form_validation->run())
		//{
			// the form has successfully validated
			if($this->user_model->Login(array('userEmail' => $this->input->post('userEmail'), 'userPassword' => $this->input->post('userPassword'))))
			{
				redirect('users/index');
			} //redirect('admin/login');
		//}
		
		$this->load->view('template/template_head');
		$this->load->view('admin/admin_login_form');
		$this->load->view('template/template_foot');
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('admin/index');
	}
	
	function index()
	{
		if( $this->session->userdata('userEmail') ){
			redirect('users/index');
		} else {
			$this->load->view('template/template_head');
			$this->load->view('admin/admin_index');
			$this->load->view('template/template_foot');
		}
	}
	
	function winners( $update = false ){
		if($this->session->userdata('userEmail')){
			if($update == 1){
				$this->getWinners();
			} else {
				$this->load->model('winners_model');
				$this->load->model('photo_model');
				
				$result = $this->winners_model->Get();
				$winners = array();
				$where = array();
				
				foreach($result as $winner)
					array_push( $winners, $this->photo_model->Get( array("img_id"=>$winner->img_id) ) );
				
				$data = array("winners"=>$winners);
				
				$this->load->view('template/template_head');
				$this->load->view('admin/admin_winners', $data);
				$this->load->view('template/template_foot');
			}
		}else{
			redirect('admin/login');
		}
	}
	
	function getWinners(){
		$this->load->model('photo_model');
		$this->load->model('winners_model');
			
		$vote_pool = array();
		$result = $this->photo_model->GetValidEntries();
		
		foreach( $result as $entry ){
			for($i = 1; $i <= $entry->rsvps; $i++)
				array_push($vote_pool, $entry->img_id);
		}
		
		shuffle($vote_pool);
		
		$totalVotes = count($vote_pool);
		$places = $totalVotes > 10 ? 10 : $totalVotes;
		
		$winnerKeys = array_rand( $vote_pool, $places );
		shuffle($winnerKeys);
		
		$currentWinners = $this->winners_model->Get(array("count"=>true));
		
		$id = 1;
		foreach($winnerKeys as $key){
			$img_id = $vote_pool[$key];
			
			if($currentWinners > 0)
				$update = $this->winners_model->Update( array("img_id"=>$img_id, "id"=>$id) );
			else
				$this->winners_model->Add( array("img_id"=>$img_id) );
			
			$id++;
		}
		
		redirect("admin/winners");
	}
	
	function _check_login($userEmail, $validateForm=true)
	{
		$this->load->model('user_model');
		if($this->input->post('userPassword'))
		{
			$user = $this->user_model->GetUsers(array('userEmail' => $userEmail, 'userPassword' => md5($this->input->post('userPassword'))));
			if($user) return true;
		}
		
		if( $validateForm )
			$this->form_validation->set_message('_check_login', 'Your username / password combination is invalid.');
		
		return false;
	}
	public function Update(){
		$this->load->model('photo_model');
		$this->photo_model->updateRSVPs();
		
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */