<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contribute_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//我上传的资料
	public function contribute_data($uuid,$num,$page)
	{
		$this->db->select('ysw_data.data_uuid,ysw_data.title,ysw_data.create_time,ysw_data_category.name');
		$this->db->from('ysw_data');
		$this->db->join('ysw_data_category', 'ysw_data.category = ysw_data_category.id','left');
		$this->db->where(array('ysw_data.creater_uuid'=>$uuid,'ysw_data.status <'=>3,'ysw_data.creater'=>0));
		$this->db->order_by('ysw_data.create_time','desc');
		$this->db->limit($num,$num*($page-1));
		$query = $this->db->get();
		return $query->result();	
	}

	//我上传的资料总数
	public function total_rows($uuid) {
		$query = $this->db->get_where('ysw_data',array('creater_uuid'=>$uuid,'status <'=>3,'creater'=>0));
		return $query->num_rows();
	}

	//删除的资料
	public function del_data($data_uuid)
	{
		$data = array(
			'status'=> 2
		);
		$this->db->update('ysw_data',$data,array('data_uuid'=>$data_uuid));
	}

	


}