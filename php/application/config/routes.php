<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$route['default_controller'] 	= "home";
$route['404_override'] 			= '';

//tailgate
$route['tailgate']		 		= "home/tailgate";


//config for flash
$route['xml/config.xml'] 		= "config";
$route['xml/config'] 			= "config";
$route['facebook/set_post_id/(:any)']	= "file/setFacebookPostId/$1/$2";

//gallery
$route['gallery'] 								= "gallery";
$route['gallery/(:num)'] 						= "gallery/detail/$1";
$route['gallery/redirect/(:num)']				= "gallery/redirect/$1";
$route['gallery/config']						= "gallery/config";
$route['gallery/filter/(:num)/(:any)/(:any)']	= "gallery/filter/$1/$2/$3";

//share
$route['share']					= "share";
$route['share/email']			= "email";
$route['share/reset']		 	= "share/reset";

//facebook
$route['share/facebook']		= "share/facebook";
$route['share/facebook/post']	= "share/postToFacebookAlbum";
$route['redirect']				= "redirect";
$route['redirect/(:any)']		= "redirect/tid/$1";

//upload
$route['file/upload']			= "file/upload";
$route['file/drop/(:num)']		= "file/drop/$1";

//admin cms
$route['share/email/list']		= "email/entries";
$route['admin']					= "admin";
$route['admin/flag']			= "admin/flag";

/* End of file routes.php */
/* Location: ./application/config/routes.php */