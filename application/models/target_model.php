<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*jeff 2014/11/17
*/
class Target_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'task_target';
	}

	/**
	*
	*/
	public function lists($where='',$order_by='grade asc')
	{	
		if($where)
			$this->db->where($where);
		if($order_by)
			$this->db->order_by($order_by);
		$this->db->from($this->table_name);
		return $this->db->get()->result();
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


	/**
	 *
	 */
	public function get_names($where='')
	{
		$data = array();
		$this->db->order_by('order','desc');
		if($where)
			$this->db->where($where);
		$query = $this->db->get($this->table_name);
		if(! $query) return FALSE;

		foreach($query->result() as $row)
		{
			$data[$row->id]=$row->name;
		}
		
		return $data;
	}

	/**
	 *
	 *
	 */
	public function get_id_array($where='')
	{
		$data = array();
		if($where)
			$this->db->where($where);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $k=>$v)
			{
				$data[] = $v->id;
			}
		}
		return $data;
	}
}