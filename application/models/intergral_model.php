<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Intergral_model extends  CI_Model {
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'user_intergral';
	}

    // 增加/扣除积分
	public function integral($data)
	{
		$this->db->insert($this->table_name,$data);
	}

	//更新会员总积分
	public function update_total($uuid,$intergral)
	{
		$data = array('intergral'=>$intergral);
		$this->db->update('user',$data,array('uuid'=>$uuid));
	}

	//判断会员当前操作是否满足赠送积分条件
	public function integral_num($uuid,$type,$time='')
	{
		if($time !='')
		{
			$this->db->where(array('create_time >='=>$time));
		}
		$query = $this->db->get_where($this->table_name,array('uuid'=>$uuid,'type'=>$type));
		return $query->num_rows();
	}

	/**
	*取mysql 生成的 uuid
	*/
	public function uuid()
	{
		return $this->db->query("select uuid() uuid")->row()->uuid;
	}
}