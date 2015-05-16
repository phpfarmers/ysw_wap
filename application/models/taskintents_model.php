<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*jeff 2014/12/24
*/
class Taskintents_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'task_intents';
	}


	/**
	*
	*/
	public function lists($pagesize=0,$count=20,$where='',$order_by='')
	{
		$data = array();
		if($where)
			$this->db->where($where);
		$total_rows = $this->db->get($this->table_name)->num_rows();
		$data['total_rows'] = $total_rows;
		
		$pagesize = intval($pagesize);
		$count = intval($count);
		if($where)
			$this->db->where($where);
		if($order_by)
			$this->db->order_by($order_by);
		$this->db->limit($count,$pagesize);
		$this->db->from($this->table_name);
		$query = $this->db->get();
		$data['data'] = $query->result();
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
	

	/**
	 *
	 */
	public function create($data)
	{
		if(!$data)
			return FALSE;
		return $this->db->insert($this->table_name,$data);
	}
	/*
	* column 为查询的字段,
	* intents_uuid 
	* 取数据
	*/
	public function fetch_intents_uuid($intents_uuid='',$column='*')
	{
		if(!$intents_uuid) return FALSE;
		
		return $this->db->query('select '.$column.' from '.$this->table_name.' where `intents_uuid` = '.trim($intents_uuid))->row();
		
	}

	/**
	* check
	*
	*/
	public function check($intents_uuid=0,$op='')
	{
		if(!$intents_uuid || ('chn' !== $op && 'chp' !== $op && 'td' !== $op))
			return FALSE;
		$intents_uuid = (array)$intents_uuid;
		$ids = '';
		foreach($intents_uuid as $row)
		{
			$ids .= "'".$row."'".',';
		}
		$ids = trim($ids,',');
		if('chp' === $op)
		{
			$sql = "update ".$this->table_name." set `checked`='1' where `intents_uuid` in (".$ids.")";
			return $this->db->query($sql);
		}
		if('chn' === $op)
		{
			$sql = "update ".$this->table_name." set `checked`='2' where `intents_uuid` in (".$ids.")";
			return $this->db->query($sql);
		}
		if('td' === $op)
		{
			$sql = "update ".$this->table_name." set `status`=(case when `status`='0' then '1' else '0' end) where `intents_uuid` in (".$ids.")";
			return $this->db->query($sql);
		}
	}

}