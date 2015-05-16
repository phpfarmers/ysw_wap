<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Views_model extends  CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//判断当前IP是否存在
	public function ip_num($task_uuid,$ip)
	{
		$time = strtotime(date('Y-m-d'));
		$query = $this->db->get_where('ysw_task_views',array('task_uuid'=>$task_uuid,'create_ip'=>$ip,'create_time >'=>$time));
		return $query->num_rows();
	}

	//添加合作浏览IP
	public function add_views($task_uuid)
	{
		$data = array(
			'task_uuid' => $task_uuid,
			'create_time' => strtotime(date('Y-m-d H:i:s')),
			'create_ip' => $this->input->ip_address()
		);
		$this->db->insert('ysw_task_views',$data);
	}

}