<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*jeff 2014/11/22
*/
class Productalbum_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'product_album';
	}

	/**
	*update
	*/
	
	public function update($data=array(),$where='')
	{
		if(empty($data)) return FALSE;

		if($where)
			$this->db->where($where);
		return $this->db->update($this->table_name,$data);		
	}
	
	/**
	* insert
	*/
	public function insert($data='',$where='')
	{
		if(!$data OR !is_array($data)) return FALSE;
		if($where)
			$this->db->where($where);
		return $this->db->insert($this->table_name, $data);
	}
	/**
	*delete
	*/
	public function delete($album_uuid='',$product_uuid='',$uuid='')
	{
		if((!$product_uuid && !$album_uuid) || !$uuid) return FALSE;
		if($product_uuid)
			$this->db->where('product_uuid',$product_uuid);
		if($album_uuid)
			$this->db->where('album_uuid',$album_uuid);
		if($uuid)
			$this->db->where('uuid',$uuid);
		$data = array('status'=>'2');
		if($this->db->update($this->table_name,$data)) return TRUE;

		return FALSE;		
	}
	/**
	* product_uuid
	* 
	* 
	*/
	public function get_product_album($product_uuid='',$where = '')
	{
		if(!$product_uuid) return FALSE;
		if($where)
			$this->db->where($where);
		if($product_uuid)
			$this->db->where('product_uuid',$product_uuid);
		return $query = $this->db->get($this->table_name)->result_array();
	}

	/**
	*
	*
	*/
	public function checkalbum($product_uuid='',$album_uuid='',$option='')
	{
		if(!$album_uuid || !$product_uuid || !$option)
			return FALSE;

		if('vc' === $option)
		{
			$sql = "update ".$this->table_name." set `status`=(case when `status`='0' then '1' else '0' end) where `album_uuid`='".$album_uuid."'";
			return $this->db->query($sql);
		}
		return FALSE;
	}
}