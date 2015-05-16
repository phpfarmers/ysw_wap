<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prestige_model extends  CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    // 增加/扣除声望
	public function prestige($data)
	{
		$this->db->insert('ysw_user_prestige',$data);
	}

	//更新会员总声望
	public function update_total($uuid,$prestige)
	{
		$data = array('prestige'=>$prestige);
		$this->db->update('user',$data,array('uuid'=>$uuid));
	}

}