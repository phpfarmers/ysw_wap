<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taskupdown extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('task_updown_model');
		$this->load->model('taskcomment_model');
		$this->lang->load('task');
	}	
	
	/**
	 * 顶踩
	 **/
	public function ajaxtaskupdown()
	{
		//验证传值
		$comment_uuid = $this->uri->segment(3);
		$task_uuid = $this->uri->segment(4);
		$updown = $this->uri->segment(5)?intval($this->uri->segment(5)):0;
		if(!$comment_uuid || (strlen(trim($comment_uuid)) !== 36 && strlen(trim($comment_uuid)) !== 13) || !$task_uuid || strlen(trim($task_uuid)) !== 36)
		{
			echo lang('Error');RETURN;
		}
		//
		$data = $datas = $datat = array();
		$ip = $this->input->ip_address();
		$created = $this->task_updown_model->fetch_id($comment_uuid,'id','create_ip = "'.$ip.'" and updown ="'.$updown.'"');
		$data['created'] = TRUE;
		$data['updown'] = $updown;
		$data['task_uuid'] = $task_uuid;
		if(!$created)
		{
			$datas["comment_uuid"] = $comment_uuid;
			$datas["comment_updown_uuid"] = uniqid();
			$datas["create_time"] = time();
			$datas["create_ip"] = $ip;
			$datas["updown"] = $updown;
			$this->task_updown_model->create($datas);
			$datat["comment_uuid"] = $comment_uuid;

			if($updown)
			{
				$datat["updown"] = "up";	
			}
			else
			{
				$datat["updown"] = "down";			
			}
			$this->taskcomment_model->updown($datat);
			$data['created'] = FALSE;
		}
		$this->load->view('ajax/task_updown',$data);
	}
}
