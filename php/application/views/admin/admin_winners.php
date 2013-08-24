<a href="<?=base_url()?><?=$this->uri->segment(1)."/winners/1"?>" class="button" style="float:left; clear:right;">Get Winners</a>

<style type="text/css" >
 	td{
		text-align: center;
	}
	table{
		margin-top:100px;
	}		
</style>
<table id="photos_table" class="display" width="100%" >

<thead>
	<tr>
		<th>Place</th>
		<th>RSVP's</th>
		<th>Profile Pic</th>
		<th>Full Name</th>
		<th>Email</th>
		<th>User Id</th>
		<th>Created At</th>
	</tr>
</thead>
<tbody>
<?php if( isset($winners) ): ?>
		<?php $i = 1;?>
		<?foreach($winners as $record): 
		
		$createdAt	= date("F j, Y", strtotime($record->created_at)); 
		$rsvps		= count(explode(",", $record->non_friend_likes)) +  count(explode(",", $record->friend_likes)); ?>
		
		<tr>
			<td><?= $i++; ?></td>
			<td id="rsvp_<?= $record->tid; ?>" class="rsvp-value"><?= $record->rsvps; ?></td>
			<td><a href="http://facebook.com/<?= $record->user_id; ?>"><img src="<?=$record->profile_pic?>"/></a></td>
			<td><?=$record->full_name?></td>
			<td><?=$record->user_email?></td>
			<td><?=$record->user_id?></td>
			<td><?= $createdAt; ?></td>
		</tr>
		
		<? endforeach?>
	<?else:?>
		<tr>
			<td colspan="3">There are currently no records.</td>
		</tr>
<?php endif ?>
</table>