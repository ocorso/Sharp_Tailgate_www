<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
  <head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	  <title>Sharp Aquos Tailgate :: <?= ENVIRONMENT; ?></title>
	  <meta name="description" content="We make sick apps.">
	  <meta name="author" content="Click3x.com">
	  <meta name="viewport" content="width=device-width,initial-scale=1">
	  <link rel="stylesheet" href="<?= $cdn; ?>css/style.css">
	  <link rel="stylesheet" href="<?= $cdn; ?>css/jquery.fancybox.css">
		
	  <script src="<?= $cdn; ?>js/libs/modernizr-2.0.6.min.js"></script>
	  <script>
	  	var environment = {}; 
	  	function configApp(){
	  		environment.domain 			= "<?= $_SERVER["HTTP_HOST"]; ?>";
	  		environment.baseUrl			= "<?= $cdn; ?>"
			environment.facebook_app_id = "<?= $appId; ?>";
			environment.swf 			= "<?= $cdn."swf/$swf"; ?>";
			environment.width			= 810;
			environment.hashtag			= "<?= $hashtag; ?>";
			environment.height			= 1020;//master app height
			log("env fb app id: "+environment.facebook_app_id);
		}


	  </script>
</head>

<body >
  <div id="container">

