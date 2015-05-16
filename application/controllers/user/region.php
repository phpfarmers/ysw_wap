<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Region extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form'));
	}

	//所属城市
	public function index()
	{
        $segments = $this->uri->uri_to_assoc();
		$this->load->model('region_model');
        $data['children']   = $this->region_model->children_of($segments['parent']);
		echo json_encode($data['children']);
		$this->output->enable_profiler(TRUE);
	}


}
