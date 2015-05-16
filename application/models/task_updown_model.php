<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
* jeff 2015/5/12
*/
class Task_updown_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'task_updown';
	}
	
	/*
	* column 为查询的字段,
	* comment_uuid 留言id
	* 取数据
	*/
	public function fetch_id($comment_uuid='',$column='*',$where = '')
	{
		if(!$comment_uuid) return FALSE;
		if($where)
			$this->db->where($where);

		$this->db->where('comment_uuid',$comment_uuid);
		$this->db->select($column);
		return $this->db->get($this->table_name)->row();
		
	}

	/**
	 *	
	 */
	public function create($data)
	{
		return $this->db->insert($this->table_name,$data);
	}


}