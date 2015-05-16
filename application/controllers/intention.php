<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Intention extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('taskintents_model');
		$this->lang->load('intention');
	}	
	
	/**
	 * 取用户意向留言
	 **/
	public function ajaxintention()
	{
		$this->load->model('task_model');
		$this->load->model('taskcomment_model');
		$this->load->model('user_model');
		$this->load->model('region_model');
		$uuids = $areaids = array();
		//验证传值
		$task_uuid = $this->uri->segment(3);
		if(!$task_uuid || strlen(trim($task_uuid)) !== 36)
		{
			echo lang('None').lang('Intention');RETURN;
		}
		//查询条件
		$where = "task_uuid = '".$task_uuid."'";

		//取合作信息
		$data['task'] = $this->task_model->fetch_id($task_uuid);
		if(!$data['task'])
		{
			echo lang('None').lang('Cooperation');RETURN;
		}
		if('0' === $data['task']->creater && !in_array($data['task']->uuid,$uuids)) $uuids[] = $data['task']->uuid;
		if($this->session->userdata('uuid') && !in_array($this->session->userdata('uuid'),$uuids)) $uuids[] = $this->session->userdata('uuid');

		//取意向信息
		$data['intents'] = $this->taskintents_model->lists(0,20,$where);
		if($intents_data = $data['intents']['data'])
		{
			foreach($intents_data as $k=>$v)
			{
				if('0' === $v->creater && !in_array($v->create_uuid,$uuids)) $uuids[] = $v->create_uuid;
			}
		}
		//取留言信息
		$data['comments'] = $this->taskcomment_model->lists(0,20,$where);
		if($comments_data = $data['comments']['data'])
		{
			foreach($comments_data as $k=>$v)
			{
				if(!in_array($v->uuid,$uuids)) $uuids[] = $v->uuid;
			}
		}

		//取用户信息
		if($uuids)
			$data['users'] = $this->user_model->users_info($uuids,$this->db->dbprefix.'user.*'.','.$this->db->dbprefix.'user_info.province'.','.$this->db->dbprefix.'user_info.city');
		
		//取地区
		if(isset($data['users']) && $data['users'])
		{
			foreach($data['users'] as $k=>$v)
			{
				if($v->province && !in_array($v->province,$areaids))
					$areaids[] = $v->province;
				if($v->city && !in_array($v->city,$areaids))
					$areaids[] = $v->city;
			}
		}
		if($areaids)
			$data['areas'] = $this->region_model->get_name('id',$areaids);

		$this->load->view('ajax/task_intention',$data);
	}
	
	/**
	 *
	 */
	public function ajaxtaskintention()
	{		
		$this->load->model('task_model');
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

		$intented = $this->taskintents_model->fetch_id($task_uuid,'id','create_uuid = "'.$this->session->userdata('uuid').'"');
		$data['intented'] = '1';
		$data['error'] = '';
		$data['task_uuid'] = $task_uuid;
		if(!$intented)
		{
			$data['intented'] = '0';
			$task = $this->task_model->fetch_id($task_uuid);
			if(!$task)
			{
				$data['intented'] = '3';
				$data['error'] = '此合作不存在';
			}
			else
			{
				$time = time();
				$end_time = $task->end_time;
				$cycle = $task->cycle;
				if(!$end_time && $cycle)
				{
					$end_time = $task->create_time + $cycle*86400;
				}
				$now = $end_time - $time;
				if($task->success || $time > $end_time)
				{
					$data['intented'] = '3';
					$data['error'] = '此合作已结束';
				}
				else
				{
					if($this->_create($task_uuid)) $data['intented'] = '2';				
				}
			}
		}
		$this->load->view('ajax/task_intention_show',$data);
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
			$datas["intents_uuid"] = uniqid();
			$datas["content"] = $this->input->post('content',TRUE);
			$datas["create_time"] = time();
			$datas["create_uuid"] = $this->session->userdata('uuid');
			if(FALSE != $this->form_validation->run())
			{				
				if($this->taskintents_model->create($datas))
					return TRUE;
			}
		}
		return FALSE;
	}
}
