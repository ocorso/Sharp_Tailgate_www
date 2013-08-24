 <?php // print_r($records);?>
		<style type="text/css" title="currentStyle">
			@import "<?= $cdn; ?>css/ui-darkness/jquery-ui-1.8.23.custom.css";
			@import "<?= $cdn; ?>css/demo_page.css";
			@import "<?= $cdn; ?>css/demo_table.css";
		</style>
  <script>
 	var photoController				= {};
	var environment 				= {}; 

  photoController.ready 			= function(){
  		log("photo ready")
  			
  		environment.domain 			= "<?= $_SERVER["HTTP_HOST"]; ?>";
  		environment.baseUrl			= "<?= $cdn; ?>"
		environment.facebook_app_id = "<?= $appId; ?>";
		environment.facebook_secret = "<?= $secret; ?>";
			log("env fb app id: "+environment.facebook_app_id);
  			
  		    //facebook
  		    var fbOpts 				= {};
  		    fbOpts.appId			= environment.facebook_app_id;
  		    fbOpts.status			= true;
  		    fbOpts.cookie			= true;
  		    fbOpts.xfbml			= true;
  			FB.init(fbOpts);

  			checkForAuthToken();
  			getAppAccessToken();
  			$("#update_likes").click(photoController.updateLikes);

  			$('#photos_table').dataTable({
				"bJQueryUI": true,
				"sPaginationType": "full_numbers"
			});
  		};

	  photoController.updateLikes 		= function ($e){
	  			
	  			log("updateClick: " + sessionData.session.accessToken);
	  			$e.preventDefault();
	  			var url 			= environment.baseUrl + "likes/update";
	  			var data 			= {};
	  			data.accessToken	= sessionData.session.accessToken;
	  			data.userId			= sessionData.session.userID;
	  			//jQuery.post( url [, data] [, success(data, textStatus, jqXHR)] [, dataType] )
	  			$.post(url, data, photoController.updateLikesComplete);
	  			return false;
	  	};
	  	
		photoController.updateLikesComplete	= function($data){
			log("updateLikesComplete");
		};
</script>
<div id="addedit" class="dialog">
</div>

<a href="<?=base_url()?><?=$this->uri->segment(1);?>/csv" class="button" style="float:left; clear:right;">Export CSV</a>
<style type="text/css">
	td{
		text-align: center;
	}
</style>
<table id="photos_table" class="display" width="100%" >
<thead>
	<tr>
		<th>Tailgate Link</th>
		<th>RSVP's</th>
		<th>Profile Pic</th>
		<th>Full Name</th>
		<th>Email</th>
		<th>User Id</th>
		<th>Created At</th>
		<th></th>
		<th></th>
	</tr>
</thead>
<tbody>
	<?if(isset($records) && is_array($records) && count($records)>0):?>
		<?foreach($records as $record): 
		$createdAt	= date("F j, Y", strtotime($record->created_at)); 
		$rsvps		= count(explode(",", $record->non_friend_likes)) +  count(explode(",", $record->friend_likes)); ?>
		
		<tr>
			<td style="text-align: left;"><a target="_blank" href="<?= base_url()."/gallery/redirect/".$record->tid;?>"><img src="<?= base_url()."/images/gallery/thumb/".$record->tid. ".jpg"?>"/></a></td>
			<td id="rsvp_<?= $record->tid; ?>" class="rsvp-value"><?= $record->rsvps; ?></td>
			<td><a href="http://facebook.com/<?= $record->user_id; ?>" target="_blank" ><img src="<?=$record->profile_pic?>"/></a></td>
			<td><?=$record->full_name?></td>
			<td><?=$record->user_email?></td>
			<td><?=$record->user_id?></td>
			<td><?= $createdAt; ?></td>
			<td>
				<?=form_open($this->uri->segment(1).'/flag/'.$record->$pk)?>
				<? if( $record->flag == 0 ): ?>
					<input type="hidden" name="flag" value="1"/>
					<input type="submit" value="Flag" style="padding:4px; margin:4px;"/>
				<? else: ?>
					<input type="hidden" name="flag" value="0"/>
					<input type="submit" value="Un-Flag" style="background-color:#fcc; padding:4px; margin:4px;"/>
				<? endif; ?>
				<?=form_close()?>
			</td>
			<td><a href='<?=base_url()?><?=$this->uri->segment(1);?>/delete/<?=$record->$pk?>'>Delete</a></td>
		</tr>
		<?endforeach?>
	<?else:?>
		<tr>
			<td colspan="3">There are currently no records.</td>
		</tr>
	<?endif?>
</tbody>
</table>
  <script src="<?= $cdn; ?>js/site/facebook.js"></script>
  <script src="<?= $cdn; ?>js/libs/plugins.js"></script>