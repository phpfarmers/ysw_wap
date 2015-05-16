<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taskcomment extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('taskcomment_model');
		$this->lang->load('taskcomment');
	}		
	
	/**
	 *
	 */
	public function ajaxtaskcomment()
	{		
		//验证传值
		$task_uuid = $this->uri->segment(3);
		$parent = $this->uri->segment(4)?$this->uri->segment(4):0;
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

		$data['created'] = '0';
		$data['task_uuid'] = $task_uuid;
		$data['parent'] = $parent;
		
		$data['created'] = $this->_create($task_uuid);
		$this->load->view('ajax/task_comment',$data);
	}

	/**
	 *
	 **/
	protected function _create($task_uuid)
	{		
		$this->load->library('form_validation');
		$this->load->helper('security');
		if($this->input->post())
		{
			$this->form_validation->set_rules('content', 'lang:Content', 'trim|required|xss_clean|max_length[250]|min_length[5]');
			$datas = array();
			$datas["task_uuid"] = $task_uuid;
			$datas["comment_uuid"] = uniqid();
			$datas["content"] = $this->input->post('content',TRUE);
			$datas["create_time"] = time();
			$datas["uuid"] = $this->session->userdata('uuid');
			$datas["create_ip"] = $this->input->ip_address();
			$datas["parent"] = $this->input->post('parent',TRUE);
			if(FALSE != $this->form_validation->run())
			{				
				if($this->taskcomment_model->create($datas))
					return '2';
			}
			return '1';
		}
		return '0';
	}
}
