<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taskcollect_model extends  CI_Model {
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'task_collection';
	}

	/**
	 *
	 */
	public function create($data)
	{
		if(!$data)
			return FALSE;
		return $this->db->insert($this->table_name,$data);
	}
	/*
	* column 为查询的字段,
	* task_uuid 会员id
	* 取数据
	*/
	public function fetch_id($task_uuid='',$column='*',$where = '')
	{
		if(!$task_uuid) return FALSE;
		if($where)
			$this->db->where($where);

		$this->db->where('task_uuid',$task_uuid);
		$this->db->select($column);
		return $this->db->get($this->table_name)->row();
		
	}

	//添加收藏
	function insert($data)
	{
		if(!$data)
			return FALSE;
		return $this->db->insert($this->table_name,$data);
	}

	/*
	* where 为查询的条件,
	* task_uuid 合作id
	* 取数据
	*/
	public function fetch_count($task_uuid='',$where ='')
	{
		if(!$task_uuid) return FALSE;
		$this->db->where('task_uuid',$task_uuid);
		if($where)
			$this->db->where($where);
		return $this->db->get($this->table_name)->num_rows();		
	}
}