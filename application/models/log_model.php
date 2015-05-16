<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends  CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    // 当天会员登录次数
	public function login_num($uuid)
	{
		$time = strtotime(date('Y-m-d'));
		$query = $this->db->get_where('ysw_user_log',array('uuid'=>$uuid,'desc'=>'会员登录','create_time >'=>$time));
		return $query->num_rows();
	}

}