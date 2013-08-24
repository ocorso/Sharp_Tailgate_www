<div>
  <img id="sharp_logo" class="left" src="<?= $cdn; ?>images/logos/sharp-logo.jpg" alt="Sharp Logo" />
<?php if($likeStatus): //echo $likeStatus; ?>
  <div id="get_started">
	<a class="disclaimerable" href="<?= $cdn; ?>tailgate/" title="Click to enter"><img src="<?= $cdn; ?>images/ui/get-started-btn.jpg"/></a>
  </div>
<?php else : ?>
  <div id="like_gate" >
	<img class="right" src="<?= $cdn; ?>images/like-gate.jpg" alt="Like This Page" />
	<h1 class="right">Like to enter!</h1>
  </div>
<?php endif;?>
</div>
<img id="aquos_logo" class="left both" src="<?= $cdn; ?>images/logos/aquos-logo.jpg" alt="aquos logo" />
<div class="both">
  <div id="win_your_ultimate">
    <h2>sharp offers tvs so big, you can feel the action.</h2>
    <h3>This football season design your ultimate "at-home" tailgate experience for the chance to be featured on our page!</h3>
  </div>
  <div id="tv">
    <img src="<?= $cdn; ?>images/tv.jpg" alt="sharp tv" />
  </div>
</div>
<div id="how_to_info" class="both">
  <div id="left-col" class="left">
    <h2 class="heading">getting started</h2>
    <ul>
      <li><span class="li-label">Customize:</span>  Choose your tailgate location, entertainment, decorations and more</li>
      <li><span class="li-label">Personalize:</span>  Add your own photos, videos and team colors</li>
      <li><span class="li-label">Bring it to life:</span> Invite your friends</li>
    </ul>
    <p>Make sure to share your creation, every RSVP you earn the more ultimate your tailgate party will be!<br /><br />
  </div>
  <div id="right_col" class="right">
  	<h2 class="heading">Ultimate Tailgate Experience Giveaway Winners</h2>
  	<h2 id="grand_prize">Congrats to our ultimate tailgate winners!</h2>
  	<ul class="winners-list">
  		  	<?php if($likeStatus):  ?>
  	  <li><a href="<?= $cdn; ?>tailgate?tid=1349022936" ><img src="<?= $cdn; ?>images/gallery/winners/1349022936.jpg" />Jeremy Gardner<br/>Greenville, NC</a></li>
  	  <li><a href="<?= $cdn; ?>tailgate?tid=1346635034" ><img src="<?= $cdn; ?>images/gallery/winners/1346635034.jpg" />Paula Skeans<br/>Elizabethton, TN</a></li>
  	  <li><a href="<?= $cdn; ?>tailgate?tid=1348343459" ><img src="<?= $cdn; ?>images/gallery/winners/1348343459.jpg" />Jack Crawford Brown<br />Crossett, AK</a></li>
		<?php else : ?>
  	  <li><img src="<?= $cdn; ?>images/gallery/winners/1349022936.jpg" />Jeremy Gardner<br/>Greenville, NC</li>
  	  <li><img src="<?= $cdn; ?>images/gallery/winners/1346635034.jpg" />Paula Skeans<br/>Elizabethton, TN</li>
  	  <li><img src="<?= $cdn; ?>images/gallery/winners/1348343459.jpg" />Jack Crawford Brown<br />Crossett, AK</li>
		<?php endif;?>
  	</ul>
  </div>
</div>
    <h2 class="li-label" style="text-align: center;">Check back often for more exciting opportunities coming soon!</h2>

<div class="section-content">
	<header class="both">
	  	<h2 class="heading left">Browse Tailgate Gallery</h2>
	  	<?php if($likeStatus):  ?>
  		<a class="right disclaimerable" href="<?= $cdn; ?>tailgate?tid=1" title="View Full Gallery"><img src="<?= $cdn; ?>images/ui/view-gallery-btn.jpg" alt="view full gallery" /></a>
		<?php else : ?>
  		<div id="like_gate" >
			<img class="right" src="<?= $cdn; ?>images/like-gate.jpg" alt="Like This Page" />
		<h1 class="right">Like to enter!</h1>
 		 </div>
		<?php endif;?>
  	</header>
	<div id="gallery_teaser_carousel" class="both">
	<?php foreach($galleryImgs as $i): ?>
	<section class="gallery-item">
		<?php if($likeStatus):  ?>
		<a class="disclaimerable" href="<?= base_url()."tailgate?tid=".$i->tid; ?>" title="View in gallery"><img class="gallery-img" src="<?= $cdn."images/gallery/thumb/".$i->tid.".jpg"; ?>" alt="gallery thumbnail" /></a>
		<?php else : ?>
		<img class="gallery-img" src="<?= $cdn."images/gallery/thumb/".$i->tid.".jpg"; ?>" alt="gallery thumbnail" />
		<?php endif;?>
		<h1><?= ucfirst($i->title); ?></h1>
		<p><?= "by: ".ucfirst($i->full_name); ?></p>
	</section>
	<?php endforeach;?>
	</div>
</div>
<div id="twitter_section" class="section-content">
	<div id="twitter_col_left">
		<img id="twitter_icon" src="<?= $cdn; ?>images/logos/twitter-icon.jpg" alt="Twitter Logo" />
		<div id="twitter_hdr">
			<h3>#ultimatetailgate</h3>
			<p>Join the conversation for tips and challenges!</p>
		</div>
	</div>
	<div id="twitter_col_right">
		<p id="twitter_feed"></p>
	</div>
</div>
<div class="section-content">
<img src="<?= $cdn; ?>images/pinterest-wings.jpg" alt="Chicken Wings Photo" />
	<div id="pinterest_col_right">
			<h3>Throw the perfect at home tailgate</h3>
			<p>Find recipes, decorating and other party tips to make your tailgate a touchdown!</p>
			<a id="pinterest" target="_blank" href="http://pinterest.com/sharpaquos/" title="Visit Sharp AQUOS on Pinterest"><img src="<?= $cdn; ?>images/logos/pinterest-logo.jpg" alt="Pinterest Logo" /></a>
	</div>
	
</div>