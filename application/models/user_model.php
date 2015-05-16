<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends  CI_Model {
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'user';
	}

	/**
	 * 注册
	 **/
	public function create($data=array(),$insert_id='')
	{
		if(empty($data)) return FALSE;
		if($this->db->insert($this->table_name,$data))
		{
			if('insert_id' === $insert_id)
				return $this->db->insert_id();

			return TRUE;
		}
		return FALSE;
	}

	/**
	 *
	 */
	function fetch_row($where = "")
	{
		if(!$where) return FALSE;

		$this->db->where($where);
		return $this->db->get($this->table_name)->row();
	}
	//./jeff

	// 验证账号是否已注册
	function check_mail($mail)
	{
		$query = $this->db->get_where('ysw_user',array('username' => $mail));
		return $query->num_rows();
	}

	// 会员注册
	function user_reg($sn,$mail,$nickname,$password)
	{
		$salt = mt_rand(1000,9999);
		$sql = "select uuid() uuid";
		$q = $this->db->query($sql)->row();
		$uuid = $q->uuid;

		$data = array(
		'uuid' => $uuid,
		'username' => $mail,
		'email' => $mail,
		'nickname' => $nickname,
		'salt' => $salt,
		'password' => md5(md5($password).$salt),	
		'reg_ip' => $this->input->ip_address(),
		'create_time' => strtotime(date("Y-m-d H:i:s")),
		'sn' => $sn
		);
		$this->db->insert('ysw_user', $data);
	}

	//读取会员邮箱
	public function email($username)
	{
		$query = $this->db->get_where('ysw_user',array('username'=>$username));
		foreach($query->result() as $row)
		{
			$email = $row->email;
		}
		return $email;
	}

	// 判断会员登录密码是否正确,是否被禁用
	function user_login($mail,$password)
	{
		$this->db->select('uuid,salt,password,islock,nickname,user_pic,user_grade,intergral,prestige');
		$query = $this->db->get_where('ysw_user',array('username' => $mail));
		return $query->row_array();
	}

	// 更新会员最后一次登录ip和时间
	function update_user_last($mail)
	{
		$data = array(
		'last_ip' => $this->input->ip_address(),
		'last_time' => strtotime(date("Y-m-d H:i:s"))
		);
		$this->db->update('ysw_user',$data,array('username' => $mail));
	}

	// 插入会员操作日志
	function insert_user_log($uuid,$type,$desc,$table,$log_sql,$json,$create_time,$ctr,$create_ip)
	{
		$sql = "select uuid() uuid";
		$q = $this->db->query($sql)->row();
		$log_uuid = $q->uuid;

		$data = array(
		'log_uuid' => $log_uuid,
		'log_type' => $type,
		'desc' => $desc,
		'table' => $table,
		'sql' => $log_sql,
		'json' => $json,
		'create_time' => $create_time,
		'uuid' => $uuid,
		'ctr' => $ctr,
		'create_ip' => $create_ip
		);
		$this->db->insert('ysw_user_log', $data);
	}

	/**
	* jeff
	*/
	public function users_info($uuids = array(),$select = '*',$where='')
	{
		$data = array();

		$this->db->select($select);
		if($uuids)
			$this->db->where_in($this->table_name.'.uuid',$uuids);
		if($where)
			$this->db->where($where);
		//$this->db->order_by($order_by);
		$this->db->from($this->table_name);
		$this->db->join($this->db->dbprefix.'user_info',$this->table_name.'.uuid = '.$this->db->dbprefix.'user_info.uuid','left');
		$query = $this->db->get();
		if($query->num_rows>0)
		{
			foreach($query->result() as $row)
			{
				$data[$row->uuid] = $row;
			}
		}
		
		return $data;
	}

	/**
	* jeff
	*/
	public function user_lists($uuids = array(),$where='')
	{
		$data = array();

		$this->db->select($this->table_name.'.*'.','.$this->db->dbprefix.'user_info.job'.','.$this->db->dbprefix.'user_info.qq'.','.$this->db->dbprefix.'user_info.company');
		if($uuids)
			$this->db->where_in($this->table_name.'.uuid',$uuids);
		if($where)
			$this->db->where($where);
		//$this->db->order_by($order_by);
		$this->db->from($this->table_name);
		$this->db->join($this->db->dbprefix.'user_info',$this->table_name.'.uuid = '.$this->db->dbprefix.'user_info.uuid','left');
		$query = $this->db->get();
		if($query->num_rows>0)
		{
			foreach($query->result() as $row)
			{
				$data[$row->uuid] = $row;
			}
		}
		
		return $data;
	}
	/**
	 * jeff 2015/1/7
	 * update avatar
	 **/
	public function update_avatar($user_pic)
	{
		if( ! $user_pic ) return FALSE;
		$data = array('user_pic' => $user_pic);
		$this->db->where('uuid', UUID);
		return $this->db->update($this->table_name,$data); 
	}

	/**
	 * jeff 2015/1/7
	 * fetch user
	 **/
	public function fetch_id($uuid = '',$column = '*')
	{
		$uuid = $uuid?$uuid:UUID;
		$this->db->select($column);
		$this->db->where('uuid', $uuid);
		return $this->db->get($this->table_name)->row(); 
	}

	//获取重置密码会员昵称
	function check_nickname($mail)
	{
		$this->db->select('nickname');
		$query = $this->db->get_where('ysw_user',array('username' => $mail));
		$nickname = $query->row()->nickname;
		return $nickname;
	}

	//获取会员信息
	public function user_info($where)
	{
		$this->db->select('uuid,intergral');
		$this->db->from('user');
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row();
	}

	//会员联系方式
	public function contact($uuid)
	{
		$this->db->select('ysw_user.mobile,ysw_user.email,ysw_user_info.qq');
		$this->db->from('user');
		$this->db->join('user_info','ysw_user.uuid = ysw_user_info.uuid','left');
		$this->db->where('ysw_user.uuid',$uuid);
		$query = $this->db->get();
		return $query->row_array();
	}

	//获取会员总积分
	public function total_intergral($uuid)
	{
		$this->db->select('intergral');
		$query = $this->db->get_where('ysw_user',array('uuid'=>$uuid));
		$intergral = $query->row()->intergral;
		return $intergral;
	}
	/**
	*取mysql 生成的 uuid
	*/
	public function uuid()
	{
		return $this->db->query("select uuid() uuid")->row()->uuid;
	}
}