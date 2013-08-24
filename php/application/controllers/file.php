<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends CI_Controller {
	public function drop($tid){	
		$result['gallery_result'] = $this->db->delete('gallery_images', array('tid' => $tid));
		$result['slides_result'] = $this->db->delete('slides', array('ref_tid' => $tid));
		
		echo json_encode($result);
	}
	
	public function upload(){
		//oc: resources
		$this->load->library('FileUploader');
		$imgTools			= new FileUploader();

		//oc: file info
		$isPost				= $this->input->server('REQUEST_METHOD') == 'POST';
		
		$tid 				= strtotime(date('Y-m-d H:i:s'));
		$baseUrl			= base_url();
		$upload_dir 		= "images/gallery";	 								// The directory for the images to be saved in
		$upload_path 		= $upload_dir."/";									// The path to where the image will be saved
		$large_image_prefix = "large/"; 										// The prefix name to large image
		$thumb_image_prefix = "thumb/";											// The prefix name to the thumb image
		$max_file 			= "1"; 												// Maximum file size in MB
		$max_width 			= "720";											// Max width allowed for the large image
		$thumb_width 		= "226";											// Width of thumbnail image
		$thumb_height 		= "201";											// Height of thumbnail image
		
		$response			= new stdClass();
		$response->error 	= new stdClass();
		$response->error->code 	= -1;

		$allowed_image_types = array(	'image/pjpeg',
										'image/jpeg',
										'image/jpg',
										'image/png',
										'image/x-png',
										'image/gif',
										'application/octet-stream'
		);
			
		$allowed_image_ext = array(		'jpg',
										'jpeg',
										'png',
										'gif',
										'giff',
		);
		
		#########################################################################################################
		# INIT																									#
		#########################################################################################################
		
		//set new image locations and filnames
		$large_file_ext 		= ".png";
		$file_ext 				= ".jpg";
		$large_image_name 		= $large_image_prefix.$tid;
		$thumb_image_name 		= $thumb_image_prefix.$tid;
		$large_image_location 	= $upload_path.$large_image_name.$large_file_ext;
		$thumb_image_location 	= $upload_path.$thumb_image_name.$file_ext;
		
		//Create the upload directory with the right permissions if it doesn't exist
		if(!is_dir($upload_dir)){
			mkdir($upload_dir, 0777);
			chmod($upload_dir, 0777);
		}
		
		#########################################################################################################
		# UPLOAD																								#
		#########################################################################################################
		
		//check to see if there's an image to upload
		if ( isset( $_POST['largeImage']) && isset($_POST['thumbImage']) ){

			//move thumb image onto filesystem
			$file = base64_decode($_POST['thumbImage']);  //base64_decode
  			$thumbFileResult = file_put_contents($thumb_image_location, $file); //'images/

			//move large image onto filesystem
			$file = base64_decode($_POST['largeImage']);  //base64_decode
  			$largeFileResult = file_put_contents($large_image_location, $file); //'images/
		}else {
			$response->error->code 				= 0;
			$response->error->text 				= "UPLOAD FAILED";
			$response->error->description 		= "Image not found";
		}
		
		if($isPost){
 			$imgOpts= array(
 				'tid'			=> $tid,
 				'user_email'	=> $this->input->post('user_email'),
 				'user_id'		=> $this->input->post('user_id'),
	 			'full_name'		=> $this->input->post('full_name'),
	 			'profile_pic'	=> $this->input->post('profile_pic'),
 				'media_id'		=> $this->input->post('media_id'),
 				'is_slideshow'	=> $this->input->post('is_slideshow') == "true" ? 1:0,
 				'title'			=> $this->input->post('title'),
 				'room_type'		=> $this->input->post('room_type'),
 				'tv_size'		=> $this->input->post('tv_size')
 			);

 			//oc: do slideshow specific stuff
			if ($this->input->post('is_slideshow') == "true")
				$slidesResponse	= $this->_insertSlides($this->input->post('user_id'), $this->input->post('media_id'), $tid);
				
			//oc: save gallery item in DB
			$success = $this->db->insert('gallery_images', $imgOpts); 
			$this->session->set_userdata('tid', $tid);
		}//endif
		
		if($response->error->code == -1 && $isPost){
			$response->result 				= "success";
			$response->image				= new stdClass();
			$response->image->tid			= $tid;
			$response->gallery_result		= $success;
			
			if( isset($slidesResponse) ){
				$response->slides_result		= $slidesResponse;
			}
		}else{
			$response->result 			= "failed";
		}
						
		$data['response']	= $response;
		$this->load->view('file/upload', $data);
		
	}//end function 
	
	public function setFacebookPostId($postId){
		$tid	= $this->input->get_post('tid');
		$this->db->where('tid',$tid)->update('gallery_images', array('post_id'=>$postId));
		
		echo "{'result':'success'}";
	}

	protected function _insertSlides($uid, $media_id, $tid){
		$slides = json_decode($media_id);
		$data 	= array();
		
		for($i = 0; $i < count($slides); $i++){
			$this->_saveFBImageToLocalServer($uid, $slides[$i]->photo_id);
			
			$data[] = array(
		      'ref_tid' => $tid,
		      'order'	=> $i,
		      'photo_id'=> $slides[$i]->photo_id,
			  'photo_url'=>$slides[$i]->photo_url
			);
		}
		
		$result = $this->db->insert_batch('slides', $data); 
		
		return $result;
	}
	
	protected function _saveFBImageToLocalServer($uid, $photoId){
		$imgInfoUrl 		= 'https://graph.facebook.com/'.$photoId.'?access_token='.$this->session->userdata('oauth_token');
		$imgInfo			= json_decode(file_get_contents($imgInfoUrl));
		$imgObj				= $imgInfo->images[5];
		$file				= file_get_contents($imgObj->source); 
		$baseUrl			= base_url();
		$upload_dir 		= "images/facebook/".$uid;	 		// The directory for the images to be saved in
		$upload_path 		= $upload_dir."/";					// The path to where the image will be saved
		$file_ext 			= ".jpg";
		$image_location 	= $upload_path.$photoId.$file_ext;
		
		//Create the upload directory with the right permissions if it doesn't exist
		if(!is_dir($upload_dir)){
			mkdir($upload_dir, 0777);
			chmod($upload_dir, 0777);
		}
		
		file_put_contents($image_location, $file); //'images/
	}
	public function Photo(){
		$photoId = "491634914183411";
		$imgInfo = 'https://graph.facebook.com/'.$photoId.'?access_token='.$this->session->userdata('oauth_token');
		
		echo $imgInfo;
	}
}//end class

?>