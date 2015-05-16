<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* jeff 2015/1/8
* 
*/
class Single_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'single_page';
	}

	
	
	/**
	*
	*/
	public function get_lists($limit=6,$where='',$order_by='')
	{
		$this->db->where(array('status'=>'1'));
		if($where)
			$this->db->where($where);
		if($order_by)
			$this->db->order_by($order_by);
		$this->db->limit($limit);
		$this->db->from($this->table_name);
		return $this->db->get()->result();
	}
	/**
	*
	*/
	public function fetch_id($id)
	{
		if(!$id) return FALSE;

		$this->db->where('id',$id);
		$this->db->where('status','1');
		$this->db->select("*");
		return $this->db->get($this->table_name)->row();
		
	}

	//单页左侧栏目
	public function menu()
	{
		$this->db->select('id,title,parent,content');
		$this->db->order_by('order asc');
		$query = $this->db->get_where('ysw_single_page',array('ysw_single_page.status'=>1));
		return $query->result_array();
	}
}