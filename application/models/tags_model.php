<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*jeff 2014/11/25
*/
class Tags_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'tags';
	}

	/*
	* name
	* 验证数据
	*/
	public function check_name($name='',$id='')
	{
		if(!$name) return FALSE;
		$id = intval($id);

		$this->db->where('name',$name);
		if($id)
			$this->db->where('id !=',$id);
		$this->db->from($this->table_name);
		return $this->db->count_all_results();		
	}

	/**
	*
	*/
	public function lists($where='',$order_by='')
	{
		if($where)
			$this->db->where($where);
		if($order_by)
			$this->db->order_by($order_by);
		$this->db->from($this->table_name);
		$query = $this->db->get();
		return $query->result();		
	}
	

	/**
	*
	*/
	public function get_name($column='id',$ids_in=array(),$exclude_id='',$order_by='order asc')
	{
		if($order_by)
			$this->db->order_by($order_by);
		if(isset($ids_in) && $ids_in)
			$this->db->where_in($column,$ids_in);
		if($exclude_id)
			$this->db->where_not_in($column,$exclude_id);
		$query = $this->db->get($this->table_name);
		return $query->result();
	}

	/*
	* column 为查询的字段,
	* id 
	* 取数据
	*/
	public function fetch_id($id='',$column='*')
	{
		if(!$id) return FALSE;
		
		return $this->db->query('select '.$column.' from '.$this->table_name.' where `id` = '.intval($id))->row();
		
	}


}