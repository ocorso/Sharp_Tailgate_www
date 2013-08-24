<?php
class Gallery extends CI_Controller {	
	
	public function index($pPage = 0)
	{		
		//get model
		$this->load->model('photo_model');
		
		//sort
		$arrWhere	= array('flag'=>0,'sortBy'=>'created_at','sortDirection'=>'DESC');
		$arrWhereIn	= array();
		
		//filter by filter
		$currTag 	= $this->session->userdata('tagName');
		

		switch ($currTag){

			case "friends":
				$savedFriends = $this->session->userdata('friends');
				if( empty($savedFriends) ){
					
					$friendsData 	= json_decode($this->_file_get_contents('https://graph.facebook.com/'.$this->session->userdata('user_id').'/friends?access_token='.$this->session->userdata('access_token')));
					$friendsObjects = $friendsData->data;
					$friendIds = array();
					foreach($friendsObjects as $friendObject)
						array_push($friendIds, $friendObject->id);
					
					$this->session->set_userdata('friends', serialize($friendIds) );
				}
				
				$arrWhereIn['user_id'] = unserialize($this->session->userdata('friends'));				
				break;
			case "mine":
				$arrWhere['user_id'] = $this->session->userdata('user_id');
				break;
		}
		
		$data['total_rows'] 	= $this->photo_model->Get( array_merge($arrWhere, array('count' => true) ) );
		
		//Now Filter by current page
		$arrWhere['offset'] 	= $pPage*GALLERY_PANELS_PER_PAGE;
		$arrWhere['limit'] 		= GALLERY_PANELS_PER_PAGE;
		
		$data['records'] 		= $this->photo_model->Get( $arrWhere, $arrWhereIn );
		
		$data['current_page'] 	= $pPage;
		$data['total_pages'] 	= ceil($data['total_rows']/GALLERY_PANELS_PER_PAGE);
		$featuredWhere 			= array('featured'=>1, 'sortBy'=>'created_at', 'sortDirection'=>'DESC');
		$data['featured'] 		= $this->photo_model->Get( $featuredWhere );
		$this->load->view('gallery/gallery_view', $data);
		
		return;
	}
	
	public function Filter($pTag ="", $userId = "", $access_token = ""){
		
		$this->session->set_userdata('tagName', $pTag);

		if(!empty($userId))
			$this->session->set_userdata('user_id', $userId);
		if(!empty($access_token))
			$this->session->set_userdata('access_token', $access_token);
		$this->Page(0);
	}
	
	public function detail($tid){
		$this->load->helper('url');
		$query 			= $this->db->get_where('gallery_images', array('tid' => $tid));
		$galleryItem	= $query->result();
		$image			= $galleryItem[0];
		$data 		= array('cdn'=> base_url(),
							'image'=>$image,
							'appId'=> $this->config->item('facebook_app_id'),
		);
		if($image->is_slideshow == 1){
			$q 				= $this->db->order_by("order", "asc")->get_where('slides', array('ref_tid' => $tid));
			$slides			= $q->result();
			$data['slides'] = $slides;
		}
		$this->load->view('gallery/detail_view', $data);
	}
	public function redirect($tid){
		$this->load->helper('url');
		$query 	= $this->db->get_where('gallery_images', array('tid' => $tid));
		$result	= $query->result();
		$data 	= array(	'isRedirect'=>true,
							'cdn'=> base_url(),
							'image'=>$result[0],
							'appId'=> $this->config->item('facebook_app_id')
		);
		$this->load->view('gallery/detail_view', $data);
	}
	
	public function Page($pPage = 0){
		header("Content-Type: text/xml");
		
		//get model
		$this->load->model('photo_model');
		
		//sort
		$arrWhere = array('flag'=>0,'sortBy'=>'created_at', 'sortDirection'=>'DESC');
		$arrWhereIn = array();
		
		//filter by filter
		$currTag = $this->session->userdata('tagName');
		
		switch ($currTag){
			case "friends":
			//	$savedFriends = $this->session->userdata('friends');
				
				//if( empty($savedFriends) ){
				//	$url				= "http://staging.sharpultimatefootball.com/json/friends.json";
					$url				= 'https://graph.facebook.com/'.$this->session->userdata('user_id').'/friends?access_token='.$this->session->userdata('access_token');
//echo $url;
					$json				= file_get_contents($url);
			//		$json				= $this->_file_get_contents($url);
					$friendsData 		= json_decode($json);
					$friendsObjects 	= $friendsData->data;
					$friendIds 			= array();
					foreach($friendsObjects as $friendObject)
						array_push($friendIds, $friendObject->id);
					
			//		$this->session->set_userdata('friends', serialize($friendIds) );
			//	}
			//	unserialize($this->session->userdata('friends'));				
				$arrWhereIn['user_id'] = $friendIds;
				break;
			case "mine":
				$arrWhere['user_id'] = $this->session->userdata('user_id');
				break;
			default: $data['error']		=	"unknown filter";
		}
		
		$data['total_rows'] 	= $this->photo_model->Get( array_merge($arrWhere, array('count' => true) ), $arrWhereIn);
//print_r($data['total_rows']);
		//Now Filter by current page
		$arrWhere['offset'] 	= $pPage*GALLERY_PANELS_PER_PAGE;
		$arrWhere['limit'] 		= GALLERY_PANELS_PER_PAGE;
		
		$data['records'] 		= $this->photo_model->Get( $arrWhere, $arrWhereIn );
		$data['current_page'] 	= $pPage;
		$data['total_pages'] 	= ceil($data['total_rows']/GALLERY_PANELS_PER_PAGE);
		
		$this->load->view('gallery/config_view', $data);
		
	}//end function Page
	
	protected function _file_get_contents($url){
		$ch 		= curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	//	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//		$response 	= curl_exec($ch);
//print_r($response);
//$response = 
		return $response;
	}
	protected function _getLikeUrl($postId){
		return 'https://graph.facebook.com/'.$postId."/likes";
	}
	
}