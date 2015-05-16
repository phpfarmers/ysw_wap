<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Favorites_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//我收藏的资料
	public function favorites_data($uuid,$num,$page)
	{
		$this->db->select('ysw_data.data_uuid,ysw_data.title,ysw_data.author,ysw_data.status,ysw_data_collection.data_collection_uuid,ysw_data_collection.create_time,ysw_data_category.name');
		$this->db->from('ysw_data_collection');
		$this->db->join('ysw_data', 'ysw_data_collection.data_uuid = ysw_data.data_uuid','left');
		$this->db->join('ysw_data_category', 'ysw_data.category = ysw_data_category.id','left');
		$this->db->where('ysw_data_collection.uuid',$uuid);
		$this->db->order_by('ysw_data_collection.create_time','desc');
		$this->db->limit($num,$num*($page-1));
		$query = $this->db->get();
		return $query->result();	
	}

	//我收藏的资料总数
	public function total_rows($uuid) {
		$query = $this->db->get_where('ysw_data_collection',array('uuid'=>$uuid));
		return $query->num_rows();
	}

	//删除的资料
	public function del_favorites($data_uuid)
	{
		$this->db->delete('ysw_data_collection',array('data_collection_uuid'=>$data_uuid));
	}

	//读取收藏资料的uuid和数量
	public function collect($collection_uuid)
	{
		$this->db->select('ysw_data.data_uuid,ysw_data.collect');
		$this->db->from('ysw_data_collection');
		$this->db->join('ysw_data', 'ysw_data_collection.data_uuid = ysw_data.data_uuid','left');
		$query = $this->db->get();
		return $query->row();
	}

	//更新资料收藏的数量
	public function update_num($collect,$data_uuid)
	{
		$data = array(
			'collect'=>$collect-1
		);
		$this->db->update('ysw_data',$data,array('data_uuid'=>$data_uuid));
	}

}