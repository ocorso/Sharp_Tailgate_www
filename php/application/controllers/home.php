<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	protected $_isLocal 	= false;
	protected $_likeStatus	= false;
	protected $_appData 	= array("something"=>"overwrite this");
	protected $_fb_config;
	protected $_signedRequest;
	protected $_loginUrl;
	protected $_access_token;
	protected $_viewData	= array();
	protected $_tid			= 0;
	
	/**
	 * Constructor for this controller.
	 * ensures that every view is behind the like-gate
	 * 
	 */
	public function __construct()
	{
		//call parent's constuctor
		parent::__construct();
		
		//oc: fix for ie8
		header('p3p: CP="NOI ADM DEV PSAi COM NAV OUR OTR STP IND DEM"');

		//oc: prepare facebook library
		$this->_fb_config	= array(
	    	'appId'  => $this->config->item('facebook_app_id'),
   			'secret' => $this->config->item('facebook_app_secret'),
			'cookie' => true,
		);
		
		$this->load->library('facebook', $this->_fb_config);
		$this->_signedRequest 	= $this->facebook->getSignedRequest();
		
		
		//oc: appData
		if( !empty($this->_signedRequest) && !empty($this->_signedRequest['app_data']) ){
			$this->_appData = json_decode(urldecode($this->_signedRequest['app_data']));			
						
		}
		//oc: access token
		if(isset($this->_appData->access_token)){
			$this->_access_token = $this->_appData->access_token;
			$this->session->set_userdata('oauth_token', $this->_appData->access_token );
		}
		//+++++++++++++++++++++++++++++++++++++++++
		//oc: oAuth at front of app
		//+++++++++++++++++++++++++++++++++++++++++

		//get the login url in case we don't have auth yet.
		$url = base_url()."redirect/";
		if($this->input->get_post('tid')) $url.= $this->input->get_post('tid');
		
		$authParams = array(	'redirect_uri' => $url,
								'scope'=>'publish_stream,user_photos,user_likes,user_photo_video_tags'
		);
		$this->_loginUrl = $this->facebook->getLoginUrl($authParams);
		
		$this->_fb_config['login_url'] = $this->_loginUrl;
		
		//try and get the auth token from facebook first.
		$this->_access_token = $this->facebook->getAccessToken();
		
		//if the facebook didn't give the token check for it in the signed request. 
		//else if the signed request didn't have it try and get it from the cookie.
		if( !isset($this->_access_token) && isset($this->_signedRequest['oauth_token']) )
			$this->_access_token 	= $this->_signedRequest['oauth_token'];
		else
			$this->_access_token	= $this->session->userdata('oauth_token');
		
		//if we have an auth token save it to the cookie.
		if( !empty($this->_access_token) )
			$this->session->set_userdata('oauth_token', $this->_access_token);
		
		//+++++++++++++++++++++++++++++++++++++++++
		//oc: oAuth END
		//+++++++++++++++++++++++++++++++++++++++++

		
		
		//oc: like status
		if( isset($this->_signedRequest['page']["liked"]) ){
			$this->_likeStatus = $this->_signedRequest["page"]["liked"];
			$this->session->set_userdata('like_status', $this->_likeStatus);
		} else {
			$this->_likeStatus = $this->session->userdata('like_status');
		}

		//oc: tid
		$this->_tid	= $this->input->get("tid");
		if (!$this->_tid) $this->_tid = 0;
		if(count($this->_appData) > 0 &&  isset($this->_appData->tid))	$this->_tid	= $this->_appData->tid;
		
 		//oc: determine if we need to worry about this nonsense (like gate).
 		$this->_isLocal = (ENVIRONMENT != "production" && ENVIRONMENT != "cfm_staging");
		
 		$this->_fb_config['like_status']	= $this->_likeStatus;
 		$this->_fb_config['like_url'] 		= $this->config->item('facebook_like_url'); 
 		
 		
		//oc: data for the view
		$this->_viewData	= array(
			'cdn'		=> base_url(),
//oc: this loads preloader
			//'swf'		=> "Sharp.swf",
			'swf'		=> "SharpPreloader.swf",
			'gaId'		=> $this->config->item('GOOGLE_ANALYTICS_ID'),
	    	'appId'  	=> $this->config->item('facebook_app_id'),
   			'secret' 	=> $this->config->item('facebook_app_secret'),
			'appData'	=> $this->_appData,
			'login_url'	=> $this->_loginUrl,		
			'likeStatus'=> $this->_likeStatus,
			'tid'		=> $this->_tid,
			'hashtag'	=> $this->config->item('twitter_hashtag'),
			'defaultVid'=> $this->config->item('default_video')
		);
	}//end constructor
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function Photo(){
		$photoId = "491634914183411";
		$imgInfo 			= 'https://graph.facebook.com/'.$photoId.'?access_token='.$this->session->userdata('oauth_token');
		echo $imgInfo;
	}
	public function index()
	{
//$this->Photo();	
		//oc: Redirect from app page.
		if(isset($_SERVER['HTTP_REFERER'])){
			
			if(strpos($_SERVER['HTTP_REFERER'], "apps.facebook.com")){
				$this->_viewData['appRedirect'] = INSTALLED_PAGE_URL;
				$this->load->view('home/app_redirect_view', $this->_viewData);
				return;
			}
		}
		
			//oc: gallery section
			$this->load->model('photo_model');
			$arrWhere 	= array('limit'=>3, 'flag'=>0,'sortBy'=>'created_at','sortDirection'=>'DESC');
			$arrWhereIn = array();
			$this->_viewData['galleryImgs'] = $this->photo_model->Get($arrWhere, $arrWhereIn  );
			
			//oc: TODO Twitter
			
			//oc: TODO Pinterest
			
			//oc: load up view
			$this->load->view('home/header_view', $this->_viewData);
			if (isset($this->_appData->tid) || isset($this->_appData->bypass_landing))
				$this->load->view('home/flash_view');
			else 
				$this->load->view('home/landing_view');
			$this->load->view('home/footer_view');

	}//end function
	
	public function tailgate(){
		
			if( !empty($this->_access_token ) || $this->input->get("localok")){
				
				$this->load->view('home/header_view', $this->_viewData);
				$this->load->view('home/flash_view');
				$this->load->view('home/footer_view');
			}else
				$this->load->view('home/redirect_view', $this->_viewData);

	}
	
}//end class

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */