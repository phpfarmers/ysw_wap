<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productupon_model extends  CI_Model {
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'product_upon';
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
	* product_uuid 产品id
	* 取数据
	*/
	public function fetch_count($product_uuid='',$where ='')
	{
		if(!$product_uuid) return FALSE;
		$this->db->where('product_uuid',$product_uuid);
		if($where)
			$this->db->where($where);
		return $this->db->get($this->table_name)->num_rows();		
	}
}