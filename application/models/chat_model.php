<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_model extends  CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//插入站内信信息
	public function add_chat($data)
	{
		$this->db->insert('ysw_user_chat',$data);
	}

	//站内信
	public function letter($uuid,$type)
	{
		$this->db->select('chat_uuid,parent,title,send_content,readed,send_time,url');
		$this->db->from('ysw_user_chat');
		$this->db->where(array('send_delete'=>'0','accept_delete'=>'0'));
		if($type == 'system')
		{
			$this->db->where(array('accept_uuid'=>$uuid,'send_uuid'=>'','sender'=>'1','accepter'=>'0'));
		}
		else if($type == 'admin')
		{
			$this->db->where(array('accept_uuid'=>$uuid,'send_uuid !='=>'','sender'=>'1','accepter'=>'0'));
		}
		else if($type == 'user')
		{
			$this->db->where(array('accept_uuid'=>$uuid,'send_uuid !='=>'','sender'=>'0','accepter'=>'0'));
		}
		$this->db->order_by('readed asc , send_time desc');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}

	//未读站内信
	public function unread_letter($uuid,$type)
	{
		if($type == 'system')
		{
			$this->db->where(array('accept_uuid'=>$uuid,'send_uuid'=>'','sender'=>'1','accepter'=>'0'));
		}
		else if($type == 'admin')
		{
			$this->db->where(array('accept_uuid'=>$uuid,'send_uuid !='=>'','sender'=>'1','accepter'=>'0'));
		}
		else if($type == 'user')
		{
			$this->db->where(array('accept_uuid'=>$uuid,'send_uuid !='=>'','sender'=>'0','accepter'=>'0'));
		}
		$query = $this->db->get_where('ysw_user_chat',array('send_delete'=>'0','accept_delete'=>'0','readed'=>'0'));
		return $query->num_rows();
	}

	//站内信详细信息
	public function letter_info($chat_uuid)
	{
		$query = $this->db->get_where('ysw_user_chat',array('status'=>'0','send_delete'=>'0','accept_delete'=>'0','chat_uuid'=>$chat_uuid));
		return $query->row();
	}

	


}