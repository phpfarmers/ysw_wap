<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*jeff 2014/11/13
*/
class Companytype_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'company_type';
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
	public function lists($where='',$order_by='grade asc')
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
	public function get_name($column='id',$ids_in=array(),$exclude_id='',$order_by='order asc')
	{
		if($order_by)
			$this->db->order_by($order_by);
		if(isset($ids_in) && $ids_in)
			$this->db->where_in($column,$ids_in);
		if($exclude_id)
			$this->db->where_not_in($column,$exclude_id);
		$query = $this->db->get($this->table_name);
		if(! $query) return FALSE;
		return $query->result();		
	}


	/**
	*
	*/
	public function get_names($column='id',$ids_in=array(),$exclude_id='',$order_by='order asc')
	{
		$data = '';
		if($order_by)
			$this->db->order_by($order_by);
		if(isset($ids_in) && $ids_in)
			$this->db->where_in($column,$ids_in);
		if($exclude_id)
			$this->db->where_not_in($column,$exclude_id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows>0)
		{
			foreach($query->result() as $row)
			{
				$data[$row->id] = $row->name;
			}
		}
		return $data;		
	}
	/*
	* column 为查询的字段,
	* id 权限组id
	* 取数据
	*/
	public function fetch_id($id='',$column='*')
	{
		if(!$id) return FALSE;
		
		return $this->db->query('select '.$column.' from '.$this->table_name.' where `id` = '.$id)->row();
		
	}	
}