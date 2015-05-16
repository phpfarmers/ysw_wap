<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_model extends  CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//资料分类
	public function plat($parent)
	{
		$this->db->select('id,platform_name as name');
		$this->db->order_by('order asc');
		$query = $this->db->get_where('ysw_product_platform',array('status'=>'0','parent'=>$parent));
		foreach($query->result() as $row)
		{
			$types[$row->id] = $row->name;
		}
		return $types;
	}

	//二级分类(资料/合作)
	public function assort($database)
	{
		$this->db->select('parent');
		$this->db->group_by('parent');
		$this->db->order_by('order asc');
		$query = $this->db->get_where($database,array('status'=>'0','parent !='=>'0'));
		foreach($query->result() as $row)
		{
			$assort[] = $row->parent;
		}
		return $assort;
	}

	//合作类型
	public function target($parent)
	{
		$this->db->select('id,name');
		$this->db->order_by('order asc');
		$query = $this->db->get_where('ysw_task_target',array('status'=>'0','parent'=>$parent)); 
		foreach($query->result() as $row)
		{
			$types[$row->id] = $row->name;
		}
		return $types;
	}

	//项目类型
	public function types()
	{
		$this->db->select('id,type_name,input_name');
		$this->db->order_by('order asc');
		$query = $this->db->get_where('ysw_product_type',array('status'=>'0')); 
		return $query->result();
	}

	//项目阶段
	public function product_step()
	{
		$this->db->select('id,name');
		$this->db->order_by('order asc');
		$query = $this->db->get_where('ysw_product_step',array('status'=>'0'));
		foreach($query->result() as $row)
		{
			$types[$row->id] = $row->name;
		}
		return $types;
	}

}