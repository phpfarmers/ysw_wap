<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Card_model extends  CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//判断会员是否关联公司
	public function user_company($uuid)
	{
		$query = $this->db->get_where('ysw_user_company',array('uuid' => $uuid,'status <'=> 2 ));
		return $query->num_rows();
	}

	//读取名片信息
	public function card($uuid,$nums)
	{
		$this->db->select('ysw_user.nickname,ysw_user.mobile,ysw_user.email,ysw_user.user_pic,ysw_user_info.realname,ysw_user_info.qq,ysw_user_info.weixin,ysw_user_info.weibo,ysw_user_company.employee_position,ysw_company.company_name,ysw_company.company_address');
		$this->db->from('ysw_user');
		$this->db->join('ysw_user_info','ysw_user.uuid=ysw_user_info.uuid','left');
		$this->db->join('ysw_user_company','ysw_user.uuid=ysw_user_company.uuid','left');
		$this->db->join('ysw_company','ysw_user_company.company_uuid=ysw_company.company_uuid','left');
		$this->db->where('ysw_user.uuid',$uuid);
		if($nums > '0' )
		{
			$this->db->where('ysw_user_company.status <',2);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->row();
	}

	//判断名片是否存在
	public function my_card($uuid)
	{
		$query = $this->db->get_where('ysw_user_card',array('uuid' => $uuid));
		return $query->num_rows();
	}

	//添加名片
	public function add_card($data)
	{
		$this->db->insert('ysw_user_card', $data);
	}

	//修改名片
	public function edit_card($data,$uuid)
	{
		$this->db->update('ysw_user_card', $data,array('uuid' => $uuid));
	}

	//查找名片显示信息
	public function card_show($uuid)
	{
		$this->db->select('ysw_user_card.card_uuid,ysw_user_card.name,ysw_user_card.first_name,ysw_user_card.job,ysw_user_card.company,ysw_user_card.email,,ysw_user_card.mobile,ysw_user_card.qq,ysw_user_card.weixin,ysw_user_card.border,ysw_user_card.background,ysw_user_card_border.url as border_url,ysw_user_card_bg.url as bg_url');
		$this->db->from('ysw_user_card');
		$this->db->join('ysw_user_card_border','ysw_user_card.border=ysw_user_card_border.id','left');
		$this->db->join('ysw_user_card_bg','ysw_user_card.background=ysw_user_card_bg.id','left');
		$this->db->where('ysw_user_card.uuid',$uuid);
		$query = $this->db->get();
		return $query->row();
	}

	//名片边框
	public function card_border($grade)
	{
		$this->db->select('id,title,url');
		$query = $this->db->get_where('ysw_user_card_border',array('grade'=>$grade,'status'=>1));
		return $query->result();
	}

	//名片底纹
	public function card_bg($grade)
	{
		$this->db->select('id,title,url');
		$query = $this->db->get_where('ysw_user_card_bg',array('grade'=>$grade,'status'=>1));
		return $query->result();
	}



}