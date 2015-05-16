<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thumb extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->_view();
	}

	protected function _view()
	{
		$this->output->set_header();
	}
}
