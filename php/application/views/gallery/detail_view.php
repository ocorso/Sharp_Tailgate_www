<?php
	$large		= base_url()."images/gallery/large/$image->tid.png";
	$thumb		= base_url()."images/gallery/thumb/$image->tid.jpg";
	
	//facebook likes
	$fetchLikes	= base_url()."likes/fetch/".$image->img_id;
	
	$add		= base_url()."likes/add/".$image->img_id;
	$remove		= base_url()."likes/remove/".$image->img_id;
	
	$createdAt	= date("F j, Y", strtotime($image->created_at));
	$url		= $cdn."gallery/redirect/".$image->tid;
	$detail		= base_url()."gallery/$image->tid";
?>
<?php if(isset($isRedirect)): ?>
<html>
    <title>The Sharp Aquos Ultimate Football Tailgate</title>
    <meta property="og:title" content="The Sharp Aquos Ultimate Football Tailgate"/>
    <meta property="og:type" content="product"/>
    <meta property="og:url" content="<?= $url; ?>"/>
    <meta property="og:image" content="<?= str_replace("https", "http", $thumb); ?>"/>
    <meta property="og:site_name" content="The Sharp AQUOS Ultimate Football Tailgate"/>
    <meta property="fb:admins" content="1110939581"/>
    <meta property="og:description" content="Sharp is helping fans bring the game home this football season by offering TV’s so big you can feel the action. RSVP to my Ultimate “At-Home” Tailgate Party and together lets create the biggest football party of the season."/>
	<script src="<?= $cdn; ?>js/libs/plugins.js"></script>
	<?php 
		$appData	= urlencode (json_encode(array('tid'=>$image->tid)));
		$redirect	= INSTALLED_PAGE_URL."?app_data=$appData";
		
	?>
	<script type="text/javascript">
	log("redirect: <?= $redirect; ?>");
	document.location = "<?= $redirect; ?>";
	</script>
</html>
<?php else: 		header("Content-Type: text/xml");?>
	<item id="<?= $image->tid; ?>" value="gallery_button" >
		<label><![CDATA[<?= $image->tid; ?>]]></label>
		<post_id><![CDATA[<?= $image->post_id; ?>]]></post_id>
		<user_id><![CDATA[<?= $image->user_id; ?>]]></user_id>
		<likes>
			<fetch><![CDATA[<?= $fetchLikes; ?>]]></fetch>
			<add><![CDATA[<?= $add; ?>]]></add>
			<remove><![CDATA[<?= $remove; ?>]]></remove>
		</likes>
		<?php if($image->is_slideshow == 1): ?>
		<slideshow>
			<?php foreach($slides as $s): ?>
			<slide tid="<?= $s->ref_tid; ?>" id="<?= $s->id; ?>" order="<?= $s->order ?>" photo_id="<?= $s->photo_id; ?>">
				<facebook><![CDATA[<?= $s->photo_url; ?>]]></facebook>
				<local><![CDATA[<?= base_url()."images/facebook/".$image->user_id . "/".$s->photo_id; ?>.jpg]]></local>
			</slide>
			<?php endforeach;?>
		</slideshow>
		<?php endif; ?>
		<title><![CDATA[<?= $image->title; ?>]]></title>
		<room_type><![CDATA[<?= $image->room_type; ?>]]></room_type>
		<tv_size><![CDATA[<?= $image->tv_size; ?>]]></tv_size>
		<media_id is_slideshow="<?= $image->is_slideshow; ?>"><![CDATA[<?= $image->media_id; ?>]]></media_id>
		<detail><![CDATA[<?= $detail; ?>]]></detail>
		<large><![CDATA[<?= $large; ?>]]></large>
		<thumb><![CDATA[<?= $thumb; ?>]]></thumb>
		<full_name><![CDATA[<?= $image->full_name; ?>]]></full_name>
		<profile_pic><![CDATA[<?= $image->profile_pic; ?>]]></profile_pic>
		<created_at><![CDATA[<?= $createdAt; ?>]]></created_at>
	</item>
	<?php endif; ?>