<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		@ob_clean();
		@session_start();
		//$this->output->enable_profiler(TRUE);
	}

	public function is_login()
	{
		if($this->session->userdata('uuid'))
		{
			return TRUE;
		}
		return FALSE;
	}
}
