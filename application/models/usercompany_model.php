<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*jeff 2014/11/13
*/
class Usercompany_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'user_company';
	}

	
	/**
	* company_uuid
	* uuid
	* 
	*/
	public function get_user_company($company_uuid='',$uuid='',$where='')
	{
		$data = array();
		if(!$company_uuid && !$uuid) return FALSE;
		
		if($uuid)
			$this->db->where('uuid',$uuid);
		if($company_uuid)
			$this->db->where('company_uuid',$company_uuid);
		if($where)
			$this->db->where($where);
		$query = $this->db->get($this->table_name);
		if(! $query) return FALSE;

		foreach($query->result() as $row)
		{
			$data[]=$row;
		}
		return $data;
	}
	/**
	* company_uuid
	* uuid
	* 
	*/
	public function get_company_user($company_uuid='',$where='')
	{
		$data = array();
		if( ! $company_uuid) return FALSE;
		if($company_uuid)
			$this->db->where('company_uuid',$company_uuid);
		if($where)
			$this->db->where($where);
		$this->db->select($this->table_name.'.*,'.$this->db->dbprefix.'user'.'.nickname,'.$this->db->dbprefix.'user'.'.user_pic');
		$this->db->from($this->table_name);
		$this->db->join($this->db->dbprefix.'user',$this->table_name.'.uuid'.' = '.$this->db->dbprefix.'user'.'.uuid','left');
		
		$query = $this->db->get();
		if($query->num_rows>0)
		{		
			foreach($query->result() as $row)
			{
				$data[]=$row;
			}
		}
		return $data;
	}	
}