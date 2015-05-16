<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sn_model extends  CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//查询指定数据库中编号最大值
	public function sn($db)
	{
		$this->db->select('max(sn) as sn');
		$query = $this->db->get_where($db);
		$sn = $query->row()->sn;
		if($sn == 0)
		{
			$sn = 10000+1;
		}
		else
		{
			$sn++;
		}
		return $sn;
	}

}