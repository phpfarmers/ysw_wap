<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*jeff 2014/12/24
*/
class Taskcomment_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'task_comment';
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
	* update
	*/
	public function update($data=array())
	{
		if(empty($data)) return FALSE;

		$comment_uuid = isset($data['comment_uuid'])&&$data['comment_uuid']?$data['comment_uuid']:'';
		if(!$comment_uuid) return FALSE;
		unset($data['comment_uuid']);
		
		$this->db->where('comment_uuid',$comment_uuid);
		if($this->db->update($this->table_name,$data)) return TRUE;

		return FALSE;		
	}

	/**
	* updown
	*/
	public function updown($data=array())
	{
		if(empty($data)) return FALSE;

		$comment_uuid = isset($data['comment_uuid'])&&$data['comment_uuid']?$data['comment_uuid']:'';
		if(!$comment_uuid) return FALSE;
		unset($data['comment_uuid']);
		
		if('up' === $data['updown'])
		{
			$sql = "up = `up` + 1";
		}
		else
		{
			$sql = "down = `down` + 1";		
		}
		if($this->db->query('update '.$this->table_name.' set '.$sql.' where comment_uuid = "'.$comment_uuid.'"')) return TRUE;

		return FALSE;		
	}
	/*
	* column 为查询的字段,
	* comment_uuid 
	* 取数据
	*/
	public function fetch_comment_uuid($comment_uuid='',$column='*')
	{
		if(!$comment_uuid) return FALSE;
		
		return $this->db->query('select '.$column.' from '.$this->table_name.' where `comment_uuid` = '.trim($comment_uuid))->row();
		
	}

	/**
	* check
	*
	*/
	public function check($comment_uuid=0)
	{
		if(!$comment_uuid)
			return FALSE;
		$comment_uuid = (array)$comment_uuid;
		$ids = '';
		foreach($comment_uuid as $row)
		{
			$ids .= "'".$row."'".',';
		}
		$ids = trim($ids,',');
		$sql = "update ".$this->table_name." set `status`=(case when `status`='0' then '1' else '0' end) where `comment_uuid` in (".$ids.")";
		return $this->db->query($sql);
	}

}