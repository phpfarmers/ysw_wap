<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*jeff 2014/11/20
*/
class Producer_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'producer';
	}

	/*
	* name
	* 验证数据
	*/
	public function check_name($name='',$producer_uuid='')
	{
		if(!$name) return FALSE;

		$this->db->where('producer_name',$name);
		if($producer_uuid)
			$this->db->where('producer_uuid !=',$producer_uuid);
		$this->db->from($this->table_name);
		return $this->db->count_all_results();		
	}

	/**
	*
	*/
	public function lists($pagesize=0,$count=20,$where='',$order_by='order desc')
	{
		$data = array();
		$total_rows = $this->db->count_all($this->table_name);
		$data['total_rows'] = $total_rows;
		
		$pagesize = intval($pagesize);
		$count = intval($count);
		if($where)
			$this->db->like($where);
		if($order_by)
			$this->db->order_by($order_by);
		$this->db->limit($count,$pagesize);
		$this->db->from($this->table_name);
		$query = $this->db->get();
		foreach($query->result() as $row)
		{
			$data['data'][] = $row;
			if(!isset($data['uuids']) || !in_array($row->uuid,$data['uuids']))
				$data['uuids'][] = $row->uuid;
			if(!isset($data['product_uuids']) || !in_array($row->product_uuid,$data['product_uuids']))
				$data['product_uuids'][] = $row->product_uuid;
		}
		
		return $data;
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

		$producer_uuid = isset($data['producer_uuid'])&&$data['producer_uuid']?$data['producer_uuid']:'';
		if(!$producer_uuid) return FALSE;
		unset($data['producer_uuid']);
		
		$this->db->where('producer_uuid',$producer_uuid);
		if($this->db->update($this->table_name,$data)) return TRUE;

		return FALSE;		
	}

	/**
	*delete
	*/
	public function delete($producer_uuid='')
	{
		if(!$producer_uuid) return FALSE;
		$this->db->where('producer_uuid',$producer_uuid);
		if($this->db->delete($this->table_name)) return TRUE;

		return FALSE;		
	}

	/**
	*
	*/
	public function get_name($where='')
	{
		$data = array();
		$this->db->order_by('order','desc');
		if($where)
			$this->db->where($where);
		$query = $this->db->get($this->table_name);
		if(! $query) return FALSE;

		foreach($query->result() as $row)
		{
			$data[$row->producer_uuid]=$row->producer_name;
		}
		return $data;
	}

	/*
	* column 为查询的字段,
	* producer_uuid 
	* 取数据
	*/
	public function fetch_id($producer_uuid='',$column='*')
	{
		if(!$producer_uuid) return FALSE;
		$this->db->where('producer_uuid',$producer_uuid);
		$this->db->select($column);
		return $this->db->get($this->table_name)->row();
		
	}

	/**
	* check
	*
	*/
	public function check($producer_uuid='')
	{
		if(!$producer_uuid)
			return FALSE;

		$sql = "update ".$this->table_name." set `status`=(case when `status`='0' then '1' else '0' end) where `producer_uuid`='".$producer_uuid."'";
		return $this->db->query($sql);
	}

}