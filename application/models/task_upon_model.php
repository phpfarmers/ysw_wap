<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
* jeff 2015/5/12
*/
class Task_upon_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'task_upon';
	}

	
	/**
	*
	*/
	public function lists($pagesize=0,$count=20,$where='',$order_by='',$groupby=array())
	{
		$data = $task_target_ids = $product_steps = $product_uuids = $result = $total_product_uuid = $total_step = $total_target = array();
		//取task总数
		if($where)
			$this->db->where($where);
		$total_rows = $this->db->count_all_results($this->table_name);
		$result['total_rows'] = $total_rows;

		if($groupby)
		{
			//取合并后的task总数，用于分页
			if($where)
				$this->db->where($where);
			$this->db->from($this->table_name);
			$this->db->group_by($groupby);
			$results = $this->db->get();
			$result['page_rows'] = $results->num_rows;
		}
		$result['page_rows'] = $result['page_rows']?$result['page_rows']:$result['total_rows'];
		//取task  limit20列表
		$pagesize = intval($pagesize);
		$count = intval($count);
		if($where)
			$this->db->where($where);
		$this->db->select($this->table_name.'.*');			
		$this->db->limit($count,$pagesize);
		$this->db->from($this->table_name);
		if($order_by)
		{
			$this->db->order_by($order_by);
		}
		else
		{//默认以会员级别排序
			$this->db->order_by($this->db->dbprefix.'user'.'.user_grade desc');
			$this->db->join($this->db->dbprefix.'user',$this->db->dbprefix.'user'.'.uuid'.'='.$this->table_name.'.uuid','left');
		}
		if($groupby)
			$this->db->group_by($groupby);
		$query = $this->db->get();
		foreach($query->result() as $row)
		{
			$data[] = $row;
			if(!in_array($row->product_uuid,$product_uuids))
				$product_uuids[] = $row->product_uuid;
			if(!in_array($row->product_step,$product_steps))
				$product_steps[] = $row->product_step;
			if(!in_array($row->task_target_id,$task_target_ids))
				$task_target_ids[] = $row->task_target_id;
		}
		$result['data'] = $data;
		$result['product_uuids'] = $product_uuids;
		$result['product_steps'] = $product_steps;
		$result['task_target_ids'] = $task_target_ids;
		
		return $result;
	}	

	/**
	*
	*/
	public function get_name($column='task_uuid',$where_in = array())
	{
		$data = array();
		if($where_in && is_array($where_in) && !empty($where_in))
			$this->db->where_in($column,$where_in);
		$query = $this->db->get($this->table_name);
		if(! $query) return FALSE;

		foreach($query->result() as $row)
		{
			$data[$row->$column]=$row->task_name;
		}
		return $data;
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

	/*
	* 
	* 验证数据
	*/
	public function check_name($name='',$task_uuid='')
	{
		if(!$name) return FALSE;

		$this->db->where('username',$name);
		if($task_uuid)
			$this->db->where('task_uuid !=',$task_uuid);

		$this->db->from($this->table_name);
		return $this->db->count_all_results();		
	}

	//合作点赞
	public function create($data)
	{
		return $this->db->insert($this->table_name,$data);
	}


}