<?php
class Likes extends CI_Controller {	
	public function Update(){
		$this->load->model('photo_model');
		$result = $this->photo_model->Get();
		
		foreach ($result as $photo)
			$this->updateTotalLikesByImageId( $photo->img_id );
	}
	
	public function Fetch( $imgId, $uid ){
		$this->load->model('photo_model');
		$response = $this->photo_model->fetchLikesByImgId( $imgId, $uid );
		
		echo json_encode( $response );
	}
	
	public function Add($imageId, $uid, $postId, $likeOnWall = true){
		//jt: if it's a friend like the post.
		if( $likeOnWall ){
			$postData 	= 'access_token='.$_REQUEST['access_token'];
			
			$ch 		= curl_init( 'https://graph.facebook.com/'.$postId.'/likes' );
			curl_setopt( $ch, CURLOPT_POST,1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS,$postData );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			
			$postResponse 	= curl_exec( $ch );
		} 
			
		//jt: post the user id to the database.
		$this->load->model('photo_model');
		$where = array('img_id'=>$imageId);
		$result = $this->photo_model->Get($where);	
		$currLikes = array();
		
		if( empty($postId) ){
			$currLikesStr = $result->non_friend_likes ;
		}else{
			$currLikesStr = $result->friend_likes;
		}
		
		if(!empty($currLikesStr)){
			$currLikes = explode(",", $currLikesStr);
		} else {
			$currLikes = array();
		}
		
		//add the new like
		array_push($currLikes, $uid);
		
		$updateWhere = array( "img_id"=>$imageId );
		$updateWhere[ empty( $postId ) ? "non_friend_likes" : "friend_likes" ] = implode( ',', array_unique($currLikes) );
		
		$response = $this->photo_model->Update( $updateWhere );
		$this->updateTotalLikesByImageId( $imageId );
		
		$response ? print_r($response) : print_r( "nope");
	}
	
	//called in the begining of the flash to refresh the wall post likes.
	function addFriendLikesToMyPosts($userId, $access_token){
		$this->load->model( 'photo_model' );
		$arrWhere 	= array('user_id'=>$userId);
		$result = $this->photo_model->Get($arrWhere);
	
		$response = "adding friend likes :: ";
	
		//jt: for each post
		foreach($result as $photo){
			if(!empty($photo->post_id)){
				$this->updateFriendLikesByPhoto($photo, $access_token);
			}
		}
	
		echo $response;
	}
	
	//will update all of the friend likes for every record in the database. this takes a very long time to run.
	public function updateAllFriendLikes($access_token){		
		$limit = 0;
		$where = array();
		
		$offset = $this->input->get("page")*$limit;
		
		if( !empty($offset) ){
			$where = array("limit"=>$limit, "offset"=>$offset);
		}
		
		$this->load->model( 'photo_model' );
		$result = $this->photo_model->Get($where);
		
		$response = "adding friend likes :: ";
		
		//jt: for each post
		foreach($result as $photo){
			if(!empty($photo->post_id)){
				$this->updateFriendLikesByPhoto($photo, $access_token);
			}
		}
	
		echo $response;
	}
	
	public function updateFriendLikesByPhoto($photo, $access_token){
		$response = "POST: ".$photo->post_id. "::::  ";
		
		$likes = array();
		$friendsList = $this->photo_model->GetFriendLikesByPostId( $photo->post_id, $access_token);
		$likeCount = count($friendsList);
		
		//jt: for each like on this post
		if(!empty($friendsList) && $likeCount > 0){
			foreach($friendsList as $wpLike){
				array_push($likes,$wpLike->id);
			}
	
			$likesString = implode( ',', $likes);
			
			$response.= $this->photo_model->Update( array("img_id"=>$photo->img_id, "friend_likes"=>$likesString ) );
			$response.= $this->updateTotalLikesByImageId( $photo->img_id );
		}
		
		echo $response;
	}
	
	public function updateTotalLikesByImageId($imageId){
		$this->load->model('photo_model');
		$where = array('img_id'=>$imageId);
		$result = $this->photo_model->Get($where);
		$currFriendLikes = array();
		$currNonFriendLikes = array();
		
		$currFriendLikesStr 	= $result->friend_likes;
		$currNonFriendLikesStr 	= $result->non_friend_likes;
		
		if(!empty($currFriendLikesStr)){
			$currFriendLikes = explode( ",", $currFriendLikesStr );
		}
		
		if(!empty($currNonFriendLikesStr)){
			$currNonFriendLikes = explode( ",", $currNonFriendLikesStr );
		}
		
		$allLikes = array_unique( array_merge( $currFriendLikes, $currNonFriendLikes ) );
		$totalLikeCount = count( $allLikes );
		
		$response = $this->photo_model->Update( array( "img_id"=>$imageId, "rsvps"=>$totalLikeCount ) );
		
		echo $response;
	}
	
	public function Remove($imageId, $uid, $postId, $unLikeOnWall = true)
	{
		//jt: if there's a post id unlike the post
		if( $unLikeOnWall ){
			$request_body = 'access_token='.$_REQUEST['access_token'];
				
			$ch = curl_init( 'https://graph.facebook.com/'.$postId.'/likes' );
				
			curl_setopt($ch, CURLOPT_POST,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				
			$response = curl_exec( $ch );
		}
	
		//jt: remove the like from the database
		$this->load->model('photo_model');
		$where = array('img_id'=>$imageId);
		$result = $this->photo_model->Get($where);
		$currLikes = array();
		
		if( empty($postId) ){
			$currLikesStr = $result->non_friend_likes;
		}else{
			$currLikesStr = $result->friend_likes;
		}
		
		if(!empty($currLikesStr)){
			$currLikes = explode( ",", $currLikesStr );
		}
			
		foreach( $currLikes as $likeId ){
			if( $uid == $likeId ){
				$index = array_search( $likeId, $currLikes );
				array_splice( $currLikes, $index, 1 );
			}
		}
		
		$updateWhere = array( "img_id"=>$imageId );
		$updateWhere[ empty( $postId ) ? "non_friend_likes" : "friend_likes" ] = implode( ',', $currLikes );
		
		$response = $this->photo_model->Update( $updateWhere );
		$this->updateTotalLikesByImageId( $imageId );
		
		$response ? print_r($response) : print_r( "nope");
	}
}