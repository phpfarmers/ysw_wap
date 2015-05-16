<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Concern_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//关注合作列表
	public function concern_task($uuid,$num,$page)
	{
		$this->db->select('ysw_task_collection.task_collection_uuid,ysw_task_collection.task_uuid,ysw_task.title,ysw_task.status,ysw_product_step.name as step_name,ysw_task_target.name as target_name,ysw_product.product_icon');
		$this->db->from('ysw_task_collection');
		$this->db->join('ysw_task', 'ysw_task_collection.task_uuid = ysw_task.task_uuid','left');
		$this->db->join('ysw_product', 'ysw_task.product_uuid = ysw_product.product_uuid','left');
		$this->db->join('ysw_product_step', 'ysw_task.product_step = ysw_product_step.id','left');
		$this->db->join('ysw_task_target', 'ysw_task.task_target_id = ysw_task_target.id','left');
		$this->db->where('ysw_task_collection.uuid',$uuid);
		$this->db->order_by('ysw_task_collection.create_time','desc');
		$this->db->limit($num,$num*($page-1));
		$query = $this->db->get();
		return $query->result();	
	}

	//关注合作数量
	public function total_task_rows($uuid) {
		$query = $this->db->get_where('ysw_task_collection',array('uuid'=>$uuid));
		return $query->num_rows();
	}

	//删除关注的合作
	public function del_concern_task($collection_uuid)
	{
		$this->db->delete('ysw_task_collection',array('task_collection_uuid'=>$collection_uuid));
	}

	//关注产品列表
	public function concern_product($uuid,$num,$page)
	{
		$this->db->select('ysw_product_collection.product_collection_uuid,ysw_product.product_uuid,ysw_product.product_name,ysw_product.product_icon,ysw_product.status,ysw_company.company_name');
		$this->db->from('ysw_product_collection');
		$this->db->join('ysw_product', 'ysw_product_collection.product_uuid = ysw_product.product_uuid','left');
		$this->db->join('ysw_company', 'ysw_product.company_uuid = ysw_company.company_uuid','left');
		$this->db->where('ysw_product_collection.uuid',$uuid);
		$this->db->order_by('ysw_product_collection.create_time','desc');
		$this->db->limit($num,$num*($page-1));
		$query = $this->db->get();
		return $query->result();
	}

	//关注产品数量
	public function total_product_rows($uuid) {
		$query = $this->db->get_where('ysw_product_collection',array('uuid'=>$uuid));
		return $query->num_rows();
	}

	//删除关注的合作
	public function del_concern_product($collection_uuid)
	{
		$this->db->delete('ysw_product_collection',array('product_collection_uuid'=>$collection_uuid));
	}


}