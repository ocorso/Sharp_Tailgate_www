<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends CI_Controller {
	
	protected $_tid = -1;
	
	public function index()
	{
		$this->load->helper('url');
		
		header("Content-Type: text/xml");
		

		$data	= array(
			'cdn'		=> base_url(),
	    	'appId'  	=> $this->config->item('facebook_app_id'),
   			'secret' 	=> $this->config->item('facebook_app_secret'),
			'shortUrl'	=> $this->config->item('app_short_url'),
			'tid'		=> $this->session->userdata('tid'), 
			'defaultVid'=> $this->config->item('default_video')
		);
		//oc: gallery stuff
		//get model
		$this->load->model('photo_model');
		//sort
		$arrWhere = array('flag'=>0,'sortBy'=>'created_at','sortDirection'=>'DESC');
		
		$data['total_images'] 	= $this->photo_model->Get( array_merge($arrWhere, array('count' => true) ) );
		$data['total_pages'] 	= ceil($data['total_images']/GALLERY_PANELS_PER_PAGE);

		$this->load->view('config/config_view', $data );
	
	}//end function
	

}//end class

?>