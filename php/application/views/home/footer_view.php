    <footer>
    		<ul>
    			<li class="first" ><a href="http://www.sharpusa.com/TermsAndConditions.aspx" title="Terms and Conditions" target="_blank">Terms and Conditions</a></li>
    			<li><a href="http://www.sharpusa.com/PrivacyPolicy.aspx" title="Privacy Policy" target="_blank">Privacy Policy</a></li>
    		</ul>	
    </footer>
  </div> <!--! end of #container -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?= $cdn; ?>js/libs/jquery.min.js"><\/script>')</script>
  <script src="//connect.facebook.net/en_US/all.js"></script>
  <script src="<?= $cdn; ?>js/libs/jquery.fancybox.pack.js"></script>
  <script src="<?= $cdn; ?>js/site/facebook.js"></script>
  <script src="<?= $cdn; ?>js/libs/swfobject.js"></script>
  <script src="<?= $cdn; ?>js/libs/plugins.js"></script>
  <script src="<?= $cdn; ?>js/site/docReady.js"></script>
  <!-- end scripts-->

  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <div id="fb-root"></div>
  <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?= $gaId; ?>']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</body>
</html>