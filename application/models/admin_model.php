<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//读取管理员信息
	public function admin_info($admin_uuid)
	{
		$this->db->select('admin_uuid,nickname,email,qq,pic,ysw_admingroup.name');
		$this->db->from('ysw_admin');
		$this->db->join('ysw_admingroup','ysw_admin.role = ysw_admingroup.role','left');
		$this->db->where(array('admin_uuid' => $admin_uuid));
		$query = $this->db->get();
		return $query->row();
	}

}