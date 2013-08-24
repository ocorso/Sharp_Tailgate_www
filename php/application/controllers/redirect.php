<?php
class Redirect extends CI_Controller {
	public function __construct()
	{
		//call parent's constuctor
		parent::__construct();
	}
	
	public function index($tid = null)
	{		
		//oc: fix for ie8
		//header('p3p: CP="NOI ADM DEV PSAi COM NAV OUR OTR STP IND DEM"');
		
		
		if(isset($_GET['code'])){
			
			$graphPrefix = "https://graph.facebook.com/oauth/access_token?";
			//build the auth url.
			$redirectUri = isset($_SERVER["HTTPS"]) ? ABSOLUTE_URL_SSL."redirect/" : ABSOLUTE_URL."redirect/";
			if ($tid) $redirectUri .= $tid;		
			
			$queryData	= array( 
								'client_id'=>$this->config->item('facebook_app_id'),
								'client_secret'=> $this->config->item('facebook_app_secret'),
								'redirect_uri'=>$redirectUri,
								'code' => $_GET['code'],
			);
			$url = $graphPrefix . http_build_query($queryData);
			
			//get the auth response query string.
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
			$response_str =  curl_exec($curl);
			curl_close ($curl);			
			
			//parse the query response string.
			parse_str($response_str, $response);
			
			//append the access_token and redirect back to the facebook page.
			if (isset($response['access_token'])){
				//if (strpos(INSTALLED_PAGE_URL, "?"))
				$appData = new stdClass();
				$appData->access_token 		= $response['access_token'];
				$appData->bypass_landing 	= "1";
				if($tid) $appData->tid = $tid;
				//	redirect(INSTALLED_PAGE_URL."?app_data={%22access%5Ftoken%22:%22".$response['access_token']."%22}", "location", 301);
					redirect(INSTALLED_PAGE_URL."?app_data=".json_encode($appData), "location", 301);
				//else 
				//	redirect(INSTALLED_PAGE_URL."&app_data={%22access%5Ftoken%22:%22".$response['access_token']."%22}", "location", 301);
			}else {
				echo "houston we have a problem, no access token<br/>";
				print_r("access_token url: ".$url);
				echo "<br />";				
				print_r("response string: ".$response_str);		
				//print_r($response);			
			}//endif
		}//endif
		else if (isset($_GET['error_reason'])){
			redirect(INSTALLED_PAGE_URL);
		}//endifelse
		else echo "no code.";
	}//end function 
	public function tid($tid){
		$this->index($tid);
	}
}//end class