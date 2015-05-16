<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$keywords = $this->input->post("keywords",TRUE);
		$modul = $this->input->post("modul",TRUE);
		redirect($modul."/index/keywords/".$keywords, 'location', 301);
	}
}
