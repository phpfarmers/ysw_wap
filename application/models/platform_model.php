<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*jeff 2015/4/30
*/
class Platform_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'product_platform';
	}

	/**
	*
	*/
	public function lists($where='',$order_by='order desc')
	{
		$data = array();		
		if($where)
			$this->db->where($where);
		if($order_by)
			$this->db->order_by($order_by);
		$data = $this->db->get($this->table_name)->result();
		return $data;
	}
	

	/**
	*
	*/
	public function get_name()
	{
		$data = array();
		$this->db->order_by('order','desc');
		$query = $this->db->get($this->table_name);
		if(! $query) return FALSE;

		foreach($query->result() as $row)
		{
			$data[$row->id]=$row->platform_name;
		}
		return $data;
	}

	/*
	* column 为查询的字段,
	* id 
	* 取数据
	*/
	public function fetch_id($id='',$column='*')
	{
		if(!$id) return FALSE;
		
		return $this->db->query('select '.$column.' from '.$this->table_name.' where `id` = '.$id)->row();
		
	}

}