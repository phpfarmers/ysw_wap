<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Center_model extends  CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//评论数量
	public function comment_num($uuid)
	{
		$query = $this->db->get_where('ysw_article_comment',array('uuid' => $uuid));
		$num_a = $query->num_rows();

		$query = $this->db->get_where('ysw_data_comment',array('uuid' => $uuid));
		$num_d = $query->num_rows();

		$num = $num_a + $num_d;
		return $num;
	}

	//发布合数
	public function task_num($uuid)
	{
		$query = $this->db->get_where('ysw_task',array('uuid' => $uuid));
		return $query->num_rows();
	}

	//提交产品数量
	public function product_num($uuid)
	{
		$query = $this->db->get_where('ysw_product',array('uuid' => $uuid));
		return $query->num_rows();
	}

	//关注合作数
	public function task_collection($uuid)
	{
		$query = $this->db->get_where('ysw_task_collection',array('uuid' => $uuid));
		return $query->num_rows();
	}

	//关注产品数
	public function product_collection($uuid)
	{
		$query = $this->db->get_where('ysw_product_collection',array('uuid' => $uuid));
		return $query->num_rows();
	}

	//判断当前会员是否绑定公司
	public function linked_company($uuid)
	{
		$query = $this->db->get_where('ysw_user_company',array('uuid'=>$uuid,'status <'=>2));
		return $query->num_rows();
	}

	//资料上传数
	public function data_upload($uuid)
	{
		$query = $this->db->get_where('ysw_data',array('creater_uuid'=>$uuid,'creater'=>0,'status <'=>2));
		return $query->num_rows();
	}

	//资料收藏数
	public function data_favorites($uuid)
	{
		$query = $this->db->get_where('ysw_data_collection',array('uuid'=>$uuid));
		return $query->num_rows();
	}

	//个人资料
	public function user_info($uuid,$status)
	{
		$this->db->select('ysw_user.nickname,ysw_user.username,ysw_user.mobile,ysw_user.email,ysw_user.user_grade,ysw_user.intergral,ysw_user.create_time,ysw_user.reg_ip,ysw_user_info.sex,ysw_user_info.age,ysw_user_info.qq,ysw_user_info.realname,ysw_user_info.weixin,ysw_user_info.weibo,ysw_user_company.employee_position,ysw_company.company_name,ysw_company.company_address');
		$this->db->from('ysw_user');
		$this->db->join('ysw_user_info','ysw_user.uuid=ysw_user_info.uuid','left');
		$this->db->join('ysw_user_company','ysw_user.uuid=ysw_user_company.uuid','left');
		$this->db->join('ysw_company','ysw_user_company.company_uuid=ysw_company.company_uuid','left');
		$this->db->where('ysw_user.uuid',$uuid);
		if($status=='true')
		{
			$this->db->where('ysw_user_company.status <',2);
		}
		$query = $this->db->get();
		return $query->row();
	}

	//查询会员登录次数
	public function login_num($uuid)
	{
		$query = $this->db->get_where('ysw_user_log',array('uuid'=>$uuid,'desc'=>'会员登录'));
		return $query->num_rows();
	}

	//上次登录时间和登录IP
	public function last_login($uuid)
	{
		$sql = "SELECT `create_time`,`create_ip` FROM `ysw_user_log` where `log_uuid` != (select `log_uuid` from `ysw_user_log` where `uuid`='$uuid' and `desc`='会员登录' order by `create_time` desc limit 1) and `uuid`='$uuid' and `desc`='会员登录' order by `create_time` desc limit 1 ";
		$query = $this->db->query($sql);
		return $query->row();
	}


}