<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*jeff 2014/12/6
*/
class P2type_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'product_2_type';
	}

	
	/**
	 * update
	 * 
	 */
	public function update($product_uuid='',$id=array())
	{
		if($product_uuid)
		{
			$this->db->where('product_uuid',$product_uuid);		
			$this->db->delete($this->table_name);
		}
		
		if($id AND $product_uuid)
		{
			$data = array();
			$id = (array)$id;
			foreach($id as $k=>$v)
			{
				$data[] = array('product_uuid'=>$product_uuid,'id'=>$v);
			}
			$this->db->insert_batch($this->table_name,$data);
		}
		
	}

	/**
	 *
	 *
	 */
	public function get_id($product_uuid='',$id='')
	{
		
		if($product_uuid)
			$this->db->where_in('product_uuid',$product_uuid);
		if($id)
			$this->db->where_in('id',$id);
		return $this->db->get($this->table_name)->result();
	}

	/**
	 *
	 *
	 */
	public function get_id_array($id='')
	{
		$data = array();
		if($id)
			$this->db->where_in('id',$id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $k=>$v)
			{
				$data[] = $v->product_uuid;
			}
		}
		return $data;
	}
	/**
	 *
	 */
	public function get_array_column($column='id',$where='')
	{
		$this->db->select($column);
		if($where)
			$this->db->where($where);
		return $this->db->get($this->table_name)->result_array();
	}
}
