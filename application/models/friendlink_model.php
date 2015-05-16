<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* jeff 2015/1/8
* 
*/
class Friendlink_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'friendlink';
	}

	
	/**
	* 分页
	*/
	public function lists($pagesize=0,$count=20,$where='',$order_by='')
	{
		$data = array();
		$category = array();
		$tags = array();
		$result = array();
		if($where)
			$this->db->where($where);
		$total_rows = $this->db->get($this->table_name)->num_rows();
		$result['total_rows'] = $total_rows;
		
		$pagesize = intval($pagesize);
		$count = intval($count);
		if($where)
			$this->db->where($where);
		if($order_by)
			$this->db->order_by($order_by);
		$this->db->limit($count,$pagesize);
		$this->db->from($this->table_name);
		$query = $this->db->get();
		$result['data'] = $query->result();
		return $result;
	}
	

	/**
	*
	*/
	public function get_lists($limit=12,$where='',$order_by='')
	{
		$this->db->where(array('status'=>'1'));
		if($where)
			$this->db->where($where);
		if($order_by)
			$this->db->order_by($order_by);
		$this->db->limit($limit);
		$this->db->from($this->table_name);
		return $this->db->get()->result();
	}
	
}