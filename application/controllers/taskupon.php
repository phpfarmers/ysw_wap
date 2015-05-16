<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taskupon extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('task_upon_model');
		$this->lang->load('task_upon');
	}	
	
	/**
	 * 取用户意向留言
	 **/
	public function ajaxtaskupon(){
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

		$uponed = $this->task_upon_model->fetch_id($task_uuid,'id','uuid = "'.$this->session->userdata('uuid').'"');
		$data['uponed'] = TRUE;
		if(!$uponed)
		{
			$datas["task_uuid"] = $task_uuid;
			$datas["task_upon_uuid"] = uniqid();
			$datas["create_ip"] = $this->input->ip_address();
			$datas["create_time"] = time();
			$datas["uuid"] = $this->session->userdata('uuid');
			$this->task_upon_model->create($datas);
			$data['uponed'] = FALSE;
		}
		$this->load->view('ajax/task_upon',$data);
	}
}
