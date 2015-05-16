<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*jeff 2014/11/25
*/
class Artcategory_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'article_category';
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
	
	
	/*
	* insert_id 取插入id
	* 插入数据
	*/
	public function create($data=array(),$insert_id='')
	{
		if(empty($data)) return FALSE;
		if($this->db->insert($this->table_name,$data))
		{
			if('insert_id' === $insert_id)
				return $this->db->insert_id();

			return TRUE;
		}
		return FALSE;
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
	public function get_name($column='id',$ids_in=array(),$exclude_id='',$order_by='order asc',$where='')
	{
		if($order_by)
			$this->db->order_by($order_by);
		if(isset($ids_in) && $ids_in)
			$this->db->where_in($column,$ids_in);
		if($exclude_id)
			$this->db->where_not_in($column,$exclude_id);
		if($where)
			$this->db->where($where);
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