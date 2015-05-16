<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taskcollect extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('taskcollect_model');
		$this->lang->load('taskcollect');
	}	
	
	/**
	 * 取用收藏
	 **/
	public function ajaxtaskcollect()
	{
		//验证传值
		$task_uuid = $this->uri->segment(3);
		if(!$task_uuid || strlen(trim($task_uuid)) !== 36)
		{
			echo lang('Error');RETURN;
		}
		//
		$data = $datas = array();
		if(!$this->is_login())
		{
			$this->load->view('ajax/login',$data);
			return;
		}

		$collected = $this->taskcollect_model->fetch_id($task_uuid,'id','uuid = "'.$this->session->userdata('uuid').'"');
		$data['collected'] = TRUE;
		if(!$collected)
		{
			$datas["task_uuid"] = $task_uuid;
			$datas["task_collection_uuid"] = uniqid();
			$datas["create_time"] = time();
			$datas["uuid"] = $this->session->userdata('uuid');
			$this->taskcollect_model->create($datas);
			$data['collected'] = FALSE;
		}
		$this->load->view('ajax/task_collect',$data);
	}
}
