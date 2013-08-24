<?php 
//oc: put var config
$badge = $tid > 0 ? $cdn."images/gallery/thumb/$tid.jpg": $cdn."images/logos/badge.jpg";
?>

<root>
	<analytics>
		<!--home !-->	
	</analytics>

<environment>
	<base_url><![CDATA[<?= base_url(); ?>]]></base_url>
	<routes>
		<set_post_id>facebook/set_post_id/</set_post_id>
		<upload><![CDATA[file/upload/]]></upload>
		<drop><![CDATA[file/drop/]]></drop>
		<email><![CDATA[share/email/]]></email>
		<gallery>
			<page><![CDATA[gallery/page/]]></page>
			<filtered><![CDATA[gallery/filter/]]></filtered>
		</gallery>
		</routes>
	<facebook>
		<app_id><?= $appId; ?></app_id>
		<app_secret><?= $secret; ?></app_secret>
		<title>RSVP to my Sharp AQUOS Tailgate Party!</title>
		<link><?= $cdn . "gallery/redirect/"; ?></link>
		<caption>The Ultimate Football Tailgate Experience</caption>
		<description>Sharp is helping fans bring the game home this football season by offering TV's so big you can feel the action. RSVP to my Ultimate "At-Home" Tailgate Party and together lets create the biggest football party of the season.</description>
		<badge><![CDATA[<?= $badge; ?>]]></badge>
	</facebook>
	<twitter>
		<![CDATA[RSVP to my @SharpAQUOS #UltimateTailgate Party ]]>
	</twitter>
		<gallery>
		<total_images><?= $total_images; ?></total_images>
		<total_pages><?= $total_pages; ?></total_pages>
	</gallery>
	<youtube>
		<video><![CDATA[<?= $defaultVid; ?>]]></video>
	</youtube>
</environment>
<config>
	
	<pages>
		<page id="theme" classname="themeModule.ThemePage">
			<colors>
				<navigation type="thumb">
					<button value="0xffffff" id="white"><label><![CDATA[WHITE]]></label></button>
					<button value="0x000000" id="black"><label><![CDATA[BLACK]]></label></button>
					<button value="0xffcc00" id="yellow"><label><![CDATA[YELLOW]]></label></button>
					<button value="0xff9900" id="gold"><label><![CDATA[GOLD]]></label></button>
					<button value="0xcc0000" id="red"><label><![CDATA[RED]]></label></button>
					<button value="0x660000" id="maroon"><label><![CDATA[MAROON]]></label></button>
					<button value="0x0000cc" id="blue"><label><![CDATA[BLUE]]></label></button>
					<button value="0x000066" id="navy_blue"><label><![CDATA[NAVY BLUE]]></label></button>
					<button value="0x0066cc" id="light_blue"><label><![CDATA[LIGHT BLUE]]></label></button>
					<button value="0x663399" id="purple"><label><![CDATA[PURPLE]]></label></button>
					<button value="0xcc3300" id="orange"><label><![CDATA[ORANGE]]></label></button>
					<button value="0x336633" id="green"><label><![CDATA[GREEN]]></label></button>
				</navigation>
			</colors>
			<selection type="carousel" id="rooms">
				<heading><![CDATA[where would you like to host your ‘at-home’ tailgate?]]></heading>
				<navigation id="carousel_photo">
					<button value="room" id="backyard" tvY="290" type="open" item="megazine cover">
						<label><![CDATA[Backyard]]></label>
						<defaultImage>defaultBackyard</defaultImage>
						<banner posX="627" posY="184" difX="0" difY="0" difScale=".2">TeamBannerBackyard</banner>
						<photo posX="378" posY="434" width="97" contentX="-23">PhotoHolderBackyard</photo>
					</button>
					<button value="room" id="roof_top" tvY="290" type="open" item="megazine cover">
						<label><![CDATA[Rooftop]]></label>
						<defaultImage>defaultRooftop</defaultImage>
						<banner posX="53" posY="248" difX="-1" difY="1" difScale=".35">TeamBannerRooftop</banner>
						<photo posX="368" posY="477" width="104" contentX="-20">PhotoHolderRooftop</photo>
					</button>
					<button value="room" id="living_room" tvY="260" type="wall" item="frame">
						<label><![CDATA[Living Room]]></label>
						<defaultImage>defaultLivingRoom</defaultImage>
						<banner posX="88" posY="107" difX="0" difY="3" difScale=".3">TeamBannerLivingRoom</banner>
						<photo posX="632" posY="137" width="95" contentX="-10">PhotoHolderLivingRoom</photo>
					</button>
					<button value="room" id="game_room" tvY="260" type="wall" item="frame">
						<label><![CDATA[Game Room]]></label>
						<defaultImage>defaultGameRoom</defaultImage>
						<banner posX="621" posY="120" difX="-11" difY="7" difScale=".2">TeamBannerGameRoom</banner>
						<photo posX="75.5" posY="115" width="88" contentX="-17">PhotoHolderGameRoom</photo>
					</button>
					<button value="room" id="home_theater" tvY="260" type="wall"  item="poster">
						<label><![CDATA[Home Theater]]></label>
						<defaultImage>defaultHomeTheater</defaultImage>
						<banner posX="42.5" posY="121" difX="7" difY="8" difScale=".2">TeamBannerHomeTheater</banner>
						<photo posX="640.5" posY="103.5" width="77" contentX="-12">PhotoHolderHomeTheater</photo>
					</button>
				</navigation>
				<navigation id="carousel_arrow">
					<button value="room" id="left"><label><![CDATA[left]]></label></button>
					<button value="room" id="right"><label><![CDATA[right]]></label></button>
				</navigation>
			</selection>
			<selection type="dropdown" id="tv_sizes" heading="AQUOS LED TV">
				<heading><![CDATA[PICK YOUR TV SIZES]]></heading>
				<navigation type="list">
					<button value="size" id="60" scale=".7"><label><![CDATA[60" AQUOS LED TV]]></label></button>
					<button value="size" id="70" scale=".8"><label><![CDATA[70" AQUOS LED TV]]></label></button>
					<button value="size" id="80" scale=".9"><label><![CDATA[80" AQUOS LED TV]]></label></button>
					<button value="size" id="90" scale="1"><label><![CDATA[90" AQUOS LED TV]]></label></button>
				</navigation>
			</selection>
			<selection type="dropdown" id="primary_color" heading="PRIMARY COLOR">
				<heading><![CDATA[PICK YOUR TEAM’S COLORS]]></heading>
			</selection>
			<selection type="dropdown" id="secondary_color" heading="SECONDARY COLOR">
			</selection>
			<navigation>
				<button value="back" id="go_home" track="go_home"><label><![CDATA[GO HOME]]></label></button>
				<button value="customize" id="customize" track="go_next_customize"><label><![CDATA[NEXT]]></label></button>
			</navigation>
		</page>
		
		<page id="customize" classname="customizeModule.CustomizePage">
			<heading><![CDATA[CUSTOMIZE]]></heading>
			<subHeading><![CDATA[Add items from the buckets to your tailgate]]></subHeading>
			<selection type="dropdown" id="entertainment" heading="ENTERTAINMENT">
				<navigation type="thumb">
					<button value="thumb" id="3d_glasses" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="laptop" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="steer" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="cd_player" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="sharp_blue_ray" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="sharp_boom_box" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="sharp_player" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="sharp_remote" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="sharp_soundbar" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="sharp_soundbar_b" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="sharp_stick_speakers" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="cd_cases" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="laptop_b" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="remotes" grayScale="false"><label><![CDATA[]]></label></button>
				</navigation>
			</selection>
			<selection type="dropdown" id="decorations" heading="DECORATIONS">
				<navigation type="thumb">
					<button value="thumb" id="trophy" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="table_a" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="Balloon" grayScale="true"><label><![CDATA[]]></label></button>
					<button value="thumb" id="plants" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="Helmet" grayScale="true"><label><![CDATA[]]></label></button>
					<button value="thumb" id="table_b" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="Banner" grayScale="true"><label><![CDATA[]]></label></button>
					<button value="thumb" id="football" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="Finger" grayScale="true"><label><![CDATA[]]></label></button>
					<button value="thumb" id="table_c" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="PomPom" grayScale="true"><label><![CDATA[]]></label></button>
					<button value="thumb" id="table_d" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="table_e" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="table_f" grayScale="false"><label><![CDATA[]]></label></button>
				</navigation>
			</selection>
			<selection type="dropdown" id="extras" heading="EXTRAS">
				<navigation type="thumb">
					<button value="thumb" id="blue_light" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="horn" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="fruits" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="deer_head" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="pinball" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="dart_target" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="red_couch" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="pizza" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="Cups" grayScale="true"><label><![CDATA[]]></label></button>
					<button value="thumb" id="subway" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="radio" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="beers" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="clock" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="Lamp" grayScale="true"><label><![CDATA[]]></label></button>
					<button value="thumb" id="chess" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="chips" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="chicken_wings" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="cards" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="water_gun" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="pinpon" grayScale="false"><label><![CDATA[]]></label></button>
					<button value="thumb" id="Smoker" grayScale="false"><label><![CDATA[]]></label></button>
				</navigation>
			</selection>
			<selection type="input" facebook="true" id="personalization" heading="PERSONALIZATION">
				<item>
					<heading><![CDATA[Support your team!]]></heading>
					<subHeading><![CDATA[Enter team name:]]></subHeading>
					<input><![CDATA[MY TEAM]]></input>
					<facebookHeading><![CDATA[Add one of your photos to the * in your room]]></facebookHeading>
					<navigation>
						<button value="choose_photo" id="choose_photo"><label><![CDATA[CHOOSE PHOTO]]></label></button>
						<button value="clear_photo" id="clear_photo"><label><![CDATA[CLEAR PHOTO]]></label></button>
					</navigation>
				</item>
				<navigation>
					<button value="ok" id="ok_teamName"><label><![CDATA[OK]]></label></button>
				</navigation>
			</selection>
			<navigation>
				<button value="start_over" id="theme" track="go_back_customize"><label><![CDATA[GO BACK]]></label></button>
				<button value="preview" id="preview" track="go_next_name_tailgate"><label><![CDATA[NEXT]]></label></button>
			</navigation>
			<preview id="preview">
				<heading><![CDATA[NAME TAILGATE & ADD CONTENT]]></heading>
				<subHeading><![CDATA[]]></subHeading>
				<selection type="input" facebook="false" id="name_your_tailgate" heading="NAME YOUR TAILGATE">
					<item>
						<heading><![CDATA[Enter Name:]]></heading>
					</item>
					<navigation>
						<button value="ok" id="ok_tailgateName"><label><![CDATA[OK]]></label></button>
					</navigation>
				</selection>
				<selection type="input" facebook="true" id="enter_video" heading="ENTER GAME TIME VIDEO">
					<item>
						<heading><![CDATA[Add a YouTube video to your&#xD;Sharp Aquos LED TV]]></heading>
						<instruction><![CDATA[Instructions]]></instruction>
						<step><![CDATA[Click the browse button.]]></step>
						<step><![CDATA[Find your preferred video.]]></step>
						<step><![CDATA[Copy the URL.]]></step>
						<step><![CDATA[Paste the URL in the above field.]]></step>
						<step><![CDATA[Watch video in your Sharp Aquos LED TV.]]></step>
						<button value="browse" id="youtube_browse" href="http://www.youtube.com/"><label><![CDATA[BROWSE]]></label></button>
						<facebookHeading><![CDATA[Add a photo slideshow to your&#xD;Sharp Aquos LED TV]]></facebookHeading>
						<slideshowStep><![CDATA[Choose up to 5 photos for slideshow]]></slideshowStep>
						<slideshowStep><![CDATA[You can drag a photo to arrage or tap x button to remove a photo from the list]]></slideshowStep>
						<navigation>
							<button value="choose_photo" id="choose_photos"><label><![CDATA[CHOOSE PHOTOS]]></label></button>
							<button value="clear_photo" id="clear_slideshow"><label><![CDATA[CLEAR SLIDESHOW]]></label></button>
						</navigation>
					</item>
					<navigation>
						<button value="ok" id="ok_videoId"><label><![CDATA[OK]]></label></button>
					</navigation>
				</selection>
<!--				<selection type="input" facebook="false" id="enter_email" heading="ENTER EMAIL CONTACT">-->
<!--					<item>-->
<!--						<heading><![CDATA[Enter your email for winning notification!]]></heading>-->
<!--						<subHeading><![CDATA[Email will be used only if you win the contest.]]></subHeading>-->
<!--					</item>-->
<!--					<navigation>-->
<!--						<button value="ok" id="ok_email"><label><![CDATA[OK]]></label></button>-->
<!--					</navigation>-->
<!--				</selection>-->
				<navigation>
					<button value="back" id="customize" track="go_back_customize"><label><![CDATA[GO BACK]]></label></button>
					<button value="submit" id="finish" track="submit_tailgate"><label><![CDATA[SUBMIT YOUR TAILGATE]]></label></button>
				</navigation>
				<tooltip><![CDATA[Please enter your valid email contact so we can send you winning notification!]]></tooltip>
			</preview>
			<finish id="submit">
				<heading><![CDATA[MY TAILGATE]]></heading>
				<subHeading><![CDATA[Thank you for sharing!]]></subHeading>
				<navigation>
					<button value="share" id="share" track="invite_friends_fans"><label><![CDATA[INVITE FRIENDS & FANS!]]></label></button>
					<button value="gallery" id="gallery" track="browse_other_tailgates"><label><![CDATA[BROWSE OTHER TAILGATES]]></label></button>
				</navigation>
			</finish>
			<tooltip><![CDATA[You can drag the photo to adjust position.]]></tooltip>
			
		</page>
		
		<page id="gallery" classname="galleryModule.GalleryPage">
			<heading><![CDATA[GALLERY]]></heading>
			<selection type="dropdown" id="gallery" heading="All">
				<heading><![CDATA[]]></heading>
				<navigation type="list">
					<button value="all" id="all"><label><![CDATA[All]]></label></button>
					<button value="friends" id="friends"><label><![CDATA[Your Friends]]></label></button>
					<button value="mine" id="mine"><label><![CDATA[Yours]]></label></button>
				</navigation>
			</selection>
			<pagination>
				<navigation>
					<button value="prev" id="prev"><label><![CDATA[&#x3c;PREV]]></label></button>
					<button value="next" id="next"><label><![CDATA[NEXT>]]></label></button>
				</navigation>
			</pagination>
			<navigation>
				<button value="make_your_own" id="theme" track="make_your_own"><label><![CDATA[MAKE YOUR OWN]]></label></button>
				<button value="back_home" id="go_back" track="go_home"><label><![CDATA[GO HOME]]></label></button>
			</navigation>
		</page>
	
	</pages>
	
	<windows>
		<window id="facebook" classname="facebookAlbum.FacebookAlbumWindow" close="true">
			<heading><![CDATA[Choose one of your albums]]></heading>
			<navigation>
				<button value="back" id="back"><label><![CDATA[BACK]]></label></button>
			</navigation>
		</window>
		<window id="gallery" classname="gallery.GalleryWindow" close="true">
			<heading><![CDATA[GALLERY WINDOW]]></heading>
			<share_navigation>
				<button value="facebook" id="facebook"><label><![CDATA[]]></label></button>
				<button value="twitter" id="twitter"><label><![CDATA[]]></label></button>
				<button value="email" id="email"><label><![CDATA[]]></label></button>
			</share_navigation>
		</window>
		<window id="share" classname="share.ShareWindow" close="true">
			<heading><![CDATA[INVITE FRIENDS AND FANS!]]></heading>
			<description><![CDATA[Now that you have planned your Ultimate “At-Home” Tailgate Experience it’s time to make it official! Invite your friends, family, and favorite football fans to your tailgate party. The more RSVP’s you receive the more thrilling your tailgate will be. Good luck!]]></description>
			<navigation>
				<button id="facebook"><label><![CDATA[Facebook]]></label></button>
				<button id="twitter"><label><![CDATA[Twitter]]></label></button>
				<button value="window" id="email"><label><![CDATA[Email]]></label></button>
			</navigation>
		</window>
		<window id="email" classname="email.EmailWindow" close="true">
			<heading><![CDATA[EMAIL]]></heading>
			<description><![CDATA[Email your friends and invite them to your Tailgate party!]]></description>
			<email_form>
				<field required="yes" defaultText="Your name" label="" value="from_name" email="no" />
				<field required="yes" defaultText="Your email" label="" value="from_email" email="yes" />
				<field required="yes" defaultText="Friends name" label="" value="to_name" email="no" />
				<field required="yes" defaultText="Friends email" label="" value="to_email" email="yes" />
				<field required="no" defaultText="Check out my tailgate!" label="" value="subject" email="no" />
				<field required="no" defaultText="Sharp is helping fans bring the game home this football season by offering TV’s so big you can feel the action. RSVP to my Ultimate “At-Home” Tailgate Party and together let’s create the biggest football party of the season." label="" value="message" email="no" height="100" />
				<opt value="send_updates" id="opt"><label><![CDATA[Send me email updates]]></label></opt>
			</email_form>
			<navigation>
				<button id="send"><label><![CDATA[SUBMIT]]></label></button>
			</navigation>
		</window>
		<window id="response_email" classname="response.ResponseWindow" close="true">
			<heading><![CDATA[Response Title]]></heading>
			<description><![CDATA[Response body.]]></description>
		</window>
		<window id="response_warning" classname="response.ResponseWindow" close="true">
			<heading><![CDATA[Sorry!]]></heading>
			<description><![CDATA[Your tailgate has not been posted. Please click on "Submit your tailgate" to try again.]]></description>
		</window>
		<window id="response_startover" classname="response.ResponseWindow" close="true">
			<heading><![CDATA[You are about to leave this page.]]></heading>
			<description><![CDATA[You'll lose all your settings. Are you sure?]]></description>
			<navigation>
				<button id="yes"><label><![CDATA[YES]]></label></button>
			</navigation>
		</window>
		<window id="loading" classname="LoadingWindow" close="true">
			<description><![CDATA[Please wait.]]></description>
		</window>
	</windows>
</config>
</root>