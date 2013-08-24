	  <script type="text/javascript">

	  	var pageHost = ((document.location.protocol == "https:") ? "https://" :	"http://"); 
		var flashvars					= {};
		flashvars.baseUrl				= "<?= $cdn; ?>";
  		flashvars.tid 					="<?= $tid; ?>";
		flashvars.swfurl				= "swf/SharpTailgate.swf"
	  	var ored						= {};
	
  	ored.flashReady		= function() {

  		log("flash is ready, yo");

  		//flash
  	    var swfVersionStr 		= "10.0.0";
  	    var xiSwfUrlStr 		= "swf/playerProductInstall.swf";
  	    var params 				= {};
  	    params.quality 			= "high";
  	    params.bgcolor 			= "#ffffff";
  	    params.allowscriptaccess = "always";
  	    params.allowfullscreen 	= "true";
  	    params.wmode			= "transparent";
  	    var attributes 			= {};
  	    attributes.id 			= "flash_movie";
  	    attributes.name 		= "flash_movie";
  	    attributes.align 		= "middle";
  	    swfobject.embedSWF(
  	        environment.swf, "flash_movie", 
  	        environment.width, environment.height, 
  	        swfVersionStr, xiSwfUrlStr, 
  	        flashvars, params, attributes
  	     );
  	    
  		//reset height now that flash is in.
  		//SetFrame();
  	};//end function

  	ored.unlike		= function ($postId){
		log("unlike: "+$postId);
		var data 	= {};
		if( sessionData.session.accessToken == undefined ){
			data.access_token = sessionData.session.access_token;
		}else{
			data.access_token = sessionData.session.accessToken;
		}
		var route	= "<?= $cdn; ?>facebook/unlike/"+$postId;
		var unlikeUrl		= "https://graph.facebook.com/"+$postId+"/likes";
		var ajax	= {};
		ajax.type	= "POST";
		//ajax.url	= unlikeUrl;
		ajax.url	= route;
		ajax.data	= data;
		ajax.success= function($msg){ thisMovie("flash_movie").onRemoveLikeSuccess($msg); };
		$.ajax(ajax);
  	};
	ored.openPopup	= function ($url) {
		log("openPopup: "+$url);
		var opts 		= {};
		opts.href		= $url;
		opts.autoSize	= false;
		opts.height		= 580;
		opts.width		= 690;		
		$.fancybox(opts,{type: 'iframe'});
		
	};
	
</script>
    <div id="flash_movie" role="main">
		<p>
	        To view this page ensure that Adobe Flash Player version 
			10.0.0 or greater is installed. 
		</p>
		<script type="text/javascript"> 
			document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='" 
							+ pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" ); 
		</script>
    </div>

	 	<noscript>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="810" height="environment.height" id="SamsungCamera">
                <param name="movie" value="swf/<?= $swf; ?>" />
                <param name="quality" value="high" />
                <param name="bgcolor" value="#FFFFFF" />
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="allowFullScreen" value="true" />
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="swf/<?= $swf; ?>" width="environment.height" height="800">
                    <param name="quality" value="high" />
                    <param name="bgcolor" value="#FFFFFF" />
                    <param name="allowScriptAccess" value="sameDomain" />
                    <param name="allowFullScreen" value="true" />
                <!--<![endif]-->
                <!--[if gte IE 6]>-->
                	<p> 
                		Either scripts and active content are not permitted to run or Adobe Flash Player version
                		10.0.0 or greater is not installed.
                	</p>
                <!--<![endif]-->
                    <a href="http://www.adobe.com/go/getflashplayer">
                        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash Player" />
                    </a>
                <!--[if !IE]>-->
                </object>
                <!--<![endif]-->
            </object>
	    </noscript>		
