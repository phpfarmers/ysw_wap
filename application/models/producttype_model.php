<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*jeff 2014/11/14
*/
class Producttype_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'product_type';
	}
	/**
	*update
	*/
	public function update($data=array())
	{
		if(empty($data)) return FALSE;

		$id = isset($data['id'])&&$data['id']?intval($data['id']):0;
		if(0===$id) return FALSE;
		unset($data['id']);
		
		$this->db->where('id',$id);
		if($this->db->update($this->table_name,$data)) return TRUE;

		return FALSE;		
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
			$data[$row->id]=$row->type_name;
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

	/**
	*
	*/
	public function lists($column='*',$where='',$orderby='')
	{
		$data = array();
		if($orderby)
			$this->db->order_by($orderby);
		if($where)
			$this->db->where($where);
		return $this->db->get($this->table_name)->result();
	}

}