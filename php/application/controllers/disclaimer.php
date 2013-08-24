<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disclaimer extends CI_Controller {
	
	public function index()
	{
		$data	= array(
			'cdn'		=> base_url()

		);

		$this->load->view('home/disclaimer_view', $data );
	
	}//end function
	
}//end class

?>