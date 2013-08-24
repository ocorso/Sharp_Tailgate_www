<?php

class Photo_Model extends CI_Model
{
	var $table = "gallery_images";
	var $pk = "img_id";
	
	var $fields = array(
		'tid' => 'str'
		,'post_id' => 'str'
		,'title' => 'str'
		,'tv_size' => 'str'
		,'room_type' => 'str'
		,'full_name' => 'str'
		,'profile_pic' => 'str'
		,'user_id' => 'str'
		,'media_id' => 'str'
		,'is_slideshow' => 'str'
		,'flag' => 'str'
		,'created_at' => 'str'
		,'user_email' => 'str'
		,'non_friend_likes' => 'str'
		,'friend_likes' => 'str'
		,'rsvps' => 'str'
	);

	function StoreLocations_Model()
    {
        //parent::Model();
    }
	
	/** Utility Methods **/
	function _required($required, $data)
	{
		foreach($required as $field)
			if(!isset($data[$field])) return false;
			
		return true;
	}
	
	function _default($defaults, $options)
	{
		return array_merge($defaults, $options);
	}
	
	function _fields(){
		return $this->fields;
	}
	
	function _pk(){
		return $this->pk;
	}
	
	function GetValidEntries(){
		$this->db->where("created_at < '2012-10-01' AND rsvps > 0");
		$query = $this->db->get($this->table);
		return $query->result();
	}
	
	/** CRUD Methods **/
	function Get( $options = array(), $inOptions = array() ){
		foreach ($this->fields as $key => $value) {
			if(isset($options[$key]))
				$this->db->where($key, $options[$key]);
			
			if(isset($inOptions[$key]))
				$this->db->where_in($key, $inOptions[$key]);
		}
		
		if(isset($options[$this->pk]))
				$this->db->where($this->pk, $options[$this->pk]);
		
		// limit / offset
		if(isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'], $options['offset']);
		else if(isset($options['limit']))
			$this->db->limit($options['limit']);
		
		// sort
		if(isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'], $options['sortDirection']);
		
		$query = $this->db->get($this->table);
//print_r($this->db->last_query());
		if(isset($options['count'])) return $query->num_rows();
		
		if(isset($options[$this->pk])) return $query->row(0);
			
		return $query->result();
	}
	
	function Add($options = array())
	{
		$this->db->insert($this->table, $options);
		
		return $this->db->insert_id();
	}
	
	function Update($options = array())
	{
		foreach ($this->fields as $key => $value) {
			if(isset($options[$key]))
				$this->db->set($key, $options[$key]);
		}

		$this->db->where($this->pk, $options[$this->pk]);
		
		$this->db->update($this->table);
		
		return $this->db->affected_rows();
	}
	
	function Delete($pId)
	{
		$this->db->delete($this->table, array($this->pk => $pId)); 	
	}
	
	/** Custom Queries **/
	function GetByTagName($options){
		$arrTags = explode(',', $options['tagName']);
		
		$strWhere = "SELECT photoId FROM tblPhotoTag";
		
		if( isset($arrTags[0])  ){
			if($arrTags[0] != ""){
				$strWhere = "SELECT photoId FROM tblPhotoTag JOIN tblTag ON tblPhotoTag.tagId = tblTag.tagId WHERE tagName='".$arrTags[0]."'";
			}
			for($idx="1"; $idx < count($arrTags); $idx++){
				$strWhere = "SELECT photoId FROM tblPhotoTag JOIN tblTag ON tblPhotoTag.tagId = tblTag.tagId WHERE photoId IN (".$strWhere.") AND tagName='".$arrTags[$idx]."'";
			}
		}

		$strWhere = "photoId IN (".$strWhere.") AND photoExpiration >= CURDATE()";
		
		$this->db->from('tblPhoto');
		$this->db->where($strWhere);
		
		// limit / offset
		if(isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'], $options['offset']);
		else if(isset($options['limit']))
			$this->db->limit($options['limit']);
		
		// sort
		if(isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'], $options['sortDirection']);
		
		$query = $this->db->get();
		
		if(isset($options['count'])) return $query->num_rows();
		
		return $query->result();
	}
	
// 	public function updateRSVPs($accessToken, $uid){
// 		$records = $this->Get();
// 		foreach ($records as $r){
// 			$numLikes = $this->fetchLikesByPostId($accessToken, $r->post_id, $r->img_id, $r->user_id);
// 			print_r($numLikes);
// 		}
// 	}
	
	public function GetFriendLikesByPostId($postId, $access_token){
		$wallPostLikes = '';
		
		//oc: prepare facebook library
		$this->_fb_config	= array(
				'appId'  => $this->config->item('facebook_app_id'),
				'secret' => $this->config->item('facebook_app_secret'),
				'cookie' => true,
		);
		
		$this->load->library('facebook', $this->_fb_config);
		
		//get wall likes
		if( !empty($postId) ){
			$url 				= $this->_getLikeUrl($postId)."?access_token=".$access_token."&limit=0";
			$wallPostLikes		= json_decode( file_get_contents($url) )->data;
		}
		
		return $wallPostLikes;
	}
	
	public function fetchLikesByImgId($imageId, $uid){
		$doesUidLike 	= 0;
		
		//jt:get likes from database
		$where 						= array('img_id'=>$imageId);
		$result 					= $this->Get($where);
		$friendLikes 				= $result->friend_likes;
		$nonFriendLikes 			= $result->non_friend_likes;
		$currLikes					= array();
		
		if( !empty($friendLikes) ){
			$currLikes = explode(",", $friendLikes);
		}
		
		if( !empty($nonFriendLikes) ){
			$currLikes = array_merge($currLikes, explode(",", $nonFriendLikes));
		}
		
		$currLikes = array_unique( $currLikes );
		
		$numLikes	= count($currLikes);
	
		foreach($currLikes as $dbLike){
			if ( $dbLike == $uid ){
				$doesUidLike = 1;
			}
		}
	
		return array("numLikes"=>$numLikes, "doesUserLike"=>$doesUidLike, "friendLikes"=>$friendLikes, "nonFriendLikes"=>$nonFriendLikes);
	}
	
	protected function _getLikeUrl($postId){ return 'https://graph.facebook.com/'.$postId."/likes";}
}

?>