<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Region_model extends CI_Model {
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->table_name = $this->db->dbprefix.'region';
	}

	/**
	*
	*/
	public function get_name($column='id',$where_in = array())
	{
		$data = array();
		if($where_in && is_array($where_in) && !empty($where_in))
			$this->db->where_in($column,$where_in);
		$query = $this->db->get($this->table_name);
		if(! $query) return FALSE;
		
		foreach($query->result() as $row)
		{
			$data[$row->$column]=$row->name;
		}
		return $data;
	}

    function children_of($parent, $select="*")
    {
        $parent = (int)$parent;
        $regions = array();
        $this->db->select($select);
        $this->db->where('parent', $parent);
        $query = $this->db->get('ysw_region');  
        return $query->result_array(); 
    }

    function provinces()
    {
        return $this->children_of(1);
    }

	public function fetch_name($id='',$in_id=array())
	{
		$data = array();
		if($id)
			$this->db->where('id',$id);
		if($in_id && is_array($in_id))
			$this->db->where_in('id',$in_id);
        $query = $this->db->get('ysw_region');
		foreach($query->result() as $row)
		{
			$data[$row->id] = $row->name;
		}

		return $data;
	}

	//区域
	public function region()
	{
		$this->db->select('id,name');
		$query = $this->db->get_where('ysw_region',array('parent'=>'1'));
		foreach($query->result() as $row)
		{
			$region[$row->id] = $row->name;
		}
		return $region;
	}

	public function region_hot($arr)
	{
		$this->db->select('id,name');
		if($arr)
		{
			$this->db->where_in('name',$arr);
		}
		$query = $this->db->get_where('ysw_region');
		foreach($query->result() as $row)
		{
			$region[$row->id] = $row->name;
		}
		return $region;
	}

}