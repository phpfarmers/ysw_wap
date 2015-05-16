<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends  CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	// 更新会员信息（ysw_user）
	function update_user($uuid,$nickname,$mobile)
	{
		$data = array(
		'nickname' => $nickname,
		'mobile' => $mobile
		);
		$this->db->update('ysw_user',$data,array('uuid' => $uuid));
	}

	// 修改密码时更新会员信息（ysw_user）
	function update_user_account($uuid,$nickname,$mobile,$password)
	{
		$salt = mt_rand(1000,9999);
		$data = array(
		'nickname' => $nickname,
		'mobile' => $mobile,
		'salt' => $salt,
		'password' => md5(md5($password).$salt)
		);
		$this->db->update('ysw_user',$data,array('uuid' => $uuid));
	}

	// 读取账户资料
	/*function user_info($uuid)
	{
		$data = array(
		'realname' => $realname,
		'sex' => $sex,
		'identity' => $identity,
		'province' => $province,
		'city' => $city,
		'qq' => $qq,
		'weixin' => $weixin,
		'weibo' => $weibo,
		'edit_time' => strtotime(date("Y-m-d H:i:s"))
		);
		$this->db->select('ysw_user_info',$data,array('uuid' => $uuid));
	}*/

	/*function user_info($uuid)
	{
		$this->db->select('realname,sex,identity,province,city,qq,weixin,weibo');
		$query = $this->db->get_where('ysw_user_info',array('uuid' => $uuid));
		return $query->row_array();
	}*/

	// 查询会员信息表（ysw_user_info）中是否存在会员附加信息
	function check_user_info($uuid)
	{
		$query = $this->db->get_where('ysw_user_info',array('uuid' => $uuid));
		return $query->num_rows();
	}

	// 读取账户资料
	function user_info($uuid)
	{
		$this->db->select('ysw_user.uuid,ysw_user.username,ysw_user.nickname,ysw_user.mobile,ysw_user.mobile_checked,ysw_user.email_checked,ysw_user.user_pic,ysw_user_info.realname,ysw_user_info.sex,ysw_user_info.identity,ysw_user_info.province,ysw_user_info.city,ysw_user_info.qq,ysw_user_info.weixin,ysw_user_info.weibo');
		$this->db->from('ysw_user');
		$this->db->join('ysw_user_info', 'ysw_user.uuid = ysw_user_info.uuid','left');
		$this->db->where('ysw_user.uuid',$uuid);
		$query = $this->db->get();
		return $query->row_array();
	}

	// 更新会员信息（ysw_user_info）
	function update_user_info($uuid,$realname,$sex,$identity,$province,$city,$qq,$weixin,$weibo)
	{
		$data = array(
		'realname' => $realname,
		'sex' => $sex,
		'identity' => $identity,
		'province' => $province,
		'city' => $city,
		'qq' => $qq,
		'weixin' => $weixin,
		'weibo' => $weibo,
		'edit_time' => strtotime(date("Y-m-d H:i:s"))
		);
		$this->db->update('ysw_user_info',$data,array('uuid' => $uuid));
	}

	// 插入会员信息（ysw_user_info）
	function insert_user_info($uuid,$realname,$sex,$identity,$province,$city,$qq,$weixin,$weibo)
	{
		$data = array(
		'uuid' => $uuid,
		'realname' => $realname,
		'sex' => $sex,
		'identity' => $identity,
		'province' => $province,
		'city' => $city,
		'qq' => $qq,
		'weixin' => $weixin,
		'weibo' => $weibo,
		'create_time' => strtotime(date("Y-m-d H:i:s"))
		);
		$this->db->insert('ysw_user_info',$data);
	}

}