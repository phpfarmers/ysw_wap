<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends  CI_Model {
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'company';
	}

  	//判断我当前是否绑定过公司（未过期）
    public function check_company($uuid) {
		$query = $this->db->get_where('ysw_user_company',array('uuid' => $uuid,'status <' => 2));
		return $query->num_rows();
    }

  	//读取我当前是否绑定过公司（未过期）的uuid
    public function company_uuid($uuid) {
		$this->db->select('company_uuid');
		$query = $this->db->get_where('ysw_user_company',array('uuid' => $uuid,'status <' => 2));
		foreach ($query->result_array() as $value) {
			$company_uuid = $value['company_uuid'];
		}
		return $company_uuid;
    }

  	//判断输入的公司名称是否已存在
    public function company_name($company_name) {
		$query = $this->db->get_where('ysw_company',array('company_name' => $company_name,'status'=>'1','checked <'=>'2'));
		return $query->num_rows();
    }


  	//根据输入的公司名称查询公司uuid
    public function select_company_uuid($company_name) {
		$this->db->select('company_uuid');
		$query = $this->db->get_where('ysw_company',array('company_name' => $company_name));
		foreach ($query->result_array() as $value) {
			$company_uuid = $value['company_uuid'];
		}
		return $company_uuid;
    }


	// 验证当前绑定的公司职位信息是否填写
	/*public function check_post($uuid)
	{
		$query = $this->db->get_where('ysw_user_company',array('uuid' => $uuid,'employee_position !=' => '','status <' => 2));
		return $query->num_rows();
	}*/


  	//读取公司名称列表
    public function company_name_list($str) {
		$this->db->select('company_uuid,company_name');
		$this->db->like('company_name', $str);
		$this->db->limit('10');
		$query = $this->db->get_where('ysw_company');
		return $query->result_array();
    }

	//读取当前绑定公司uuid和公司状态
	public function user_company($uuid)
	{
		$this->db->select('company_uuid,status');
		$query = $this->db->get_where('ysw_user_company',array('uuid' => $uuid,'status <' => 2));
		return $query->row_array();
	}

  	//判断需要绑定的公司是否已绑定过
    public function linked_company($uuid,$company_uuid) {
		$query = $this->db->get_where('ysw_user_company',array('uuid' => $uuid,'company_uuid' => $company_uuid));
		return $query->num_rows();
    }

	//修改会员现绑定公司状态
	public function update_user_company_status($uuid,$company_uuid,$status)
	{
		if($status == 1)
		{
			$status = 3 ;
		}
		else
		{
			$status = 2 ;
		}
		$data = array(
		'status' => $status
		);
		$this->db->update('ysw_user_company',$data,array('uuid' => $uuid,'company_uuid' => $company_uuid));
	}

	//绑定新公司信息（新增公司绑定）
	public function insert_user_company($uuid,$company_uuid)
	{
		$data = array(
		'uuid' => $uuid,
		'company_uuid' => $company_uuid,
		'status' => '0'
		);
		$this->db->insert('ysw_user_company', $data);
	}

	//添加公司默认添加用户公司表关联，状态为（2未验证、已过期）
	public function add_user_company($uuid,$company_uuid)
	{
		$data = array(
		'uuid' => $uuid,
		'company_uuid' => $company_uuid,
		'create_time' => strtotime(date("Y-m-d H:i:s")),
		'status' => '2'
		);
		$this->db->insert('ysw_user_company', $data);
	}

	//删除我以前的公司
	public function del_user_company($uuid,$company_uuid)
	{
		$data = array(
		'status' => '4'
		);
		$this->db->update('ysw_user_company', $data,array('uuid' => $uuid,'company_uuid' => $company_uuid));
	}

	//绑定新公司信息（修改公司绑定状态）
	public function update_user_company($uuid,$company_uuid)
	{
		$data = array(
		'status' => '0'
		);
		$this->db->update('ysw_user_company', $data,array('uuid' => $uuid,'company_uuid' => $company_uuid));
	}

	//读取当前绑定公司信息及职位信息
	public function company_post($uuid,$company_uuid)
	{
		/*$this->db->select('ysw_user_company.company_uuid,ysw_user_company.status,ysw_user_company.employee_position,ysw_user_company.employee_dept,ysw_user_company.join_time,ysw_user_company.verification_info,ysw_company.company_name,ysw_company.company_pic,ysw_company.company_address,ysw_company.company_desc');
		$this->db->from('ysw_company');
		$this->db->join('ysw_user_company', 'ysw_company.company_uuid = ysw_user_company.company_uuid','left');
		$this->db->where('ysw_company.company_uuid',$company_uuid);
		$this->db->where('ysw_user_company.uuid',$uuid);
		//$this->db->where('ysw_user_company.status <',2);
		$query = $this->db->get();*/
		//echo $this->db->last_query();exit;

		$sql = "SELECT a.company_uuid,a.company_name,a.company_address,a.company_desc,a.company_pic,b.employee_position,b.employee_dept,b.join_time,b.status,b.verification_info FROM `ysw_company` a LEFT JOIN (select * from `ysw_user_company` c where c.`uuid` = '$uuid') b ON a.`company_uuid` = b.`company_uuid` WHERE a.`company_uuid` = '$company_uuid'";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();exit;
		return $query->row_array();
	}

	// 更新已绑定公司的职位信息
	public function update_user_post($uuid,$company_uuid,$employee_position,$employee_dept,$join_time,$verification_info)
	{
		if(!empty($verification_info))
		{
			$data = array(
			'employee_position' => $employee_position,
			'employee_dept' => $employee_dept,
			'join_time' => strtotime($join_time),
			'verification_info' => $verification_info,
			'status' => '0'
			);
		}
		else
		{
			$data = array(
			'employee_position' => $employee_position,
			'employee_dept' => $employee_dept,
			'join_time' => strtotime($join_time),
			'status' => '0'
			);
		}
		$this->db->update('ysw_user_company', $data,array('uuid' => $uuid,'company_uuid' => $company_uuid));
	}

	// 插入新绑定公司的职位信息
	public function insert_user_post($uuid,$company_uuid,$employee_position,$employee_dept,$join_time,$verification_info)
	{
		$data = array(
		'uuid' => $uuid,
		'company_uuid' => $company_uuid,
		'employee_position' => $employee_position,
		'employee_dept' => $employee_dept,
		'join_time' => strtotime($join_time),
		'create_time' => strtotime(date("Y-m-d H:i:s")),
		'verification_info' => $verification_info,
		'status' => '0'
		);
		$this->db->insert('ysw_user_company', $data);
	}

	/*public function insert_company($uuid,$company_uuid,$company_name,$company_pic,$company_type,$company_size,$province,$city,$company_address,$company_phone,$company_email,$company_web,$company_desc,$create_time,$create_ip)
	{
		$data = array(
		'company_uuid' => $company_uuid,
		'create_uuid' => $uuid,
		'company_name' => $company_name,
		'company_pic' => $company_pic,
		'company_type' => $company_type,
		'company_size' => $company_size,
		'province' => $province,
		'city' => $city,
		'company_address' => $company_address,
		'company_phone' => $company_phone,
		'company_email' => $company_email,
		'company_web' => $company_web,
		'company_desc' => $company_desc,
		'create_time' => $create_time,
		'create_ip' => $create_ip,
		'status' => '0'	
		);
		$this->db->insert('ysw_company', $data);
	}*/

  	//读取我以前公司列表信息
    public function old_company_list($uuid) {
		$data = $region = array();
		$this->db->select('ysw_company.company_uuid,ysw_company.company_name,ysw_company.province,ysw_company.city,ysw_company.company_pic,ysw_user_company.uuid,ysw_user_company.employee_position,ysw_user_company.join_time');
		$this->db->from('ysw_user_company');
		$this->db->join('ysw_company', 'ysw_user_company.company_uuid = ysw_company.company_uuid','left');
		$this->db->where(array('ysw_user_company.uuid'=>$uuid,'ysw_company.status'=>'1'));
		$this->db->where('ysw_user_company.status in (2,3)');
		$query = $this->db->get();
		foreach($query->result_array() as $row)
		{
			$data['old_company'][] = $row;
			if(!in_array($row['province'],$region))
				$region[] = $row['province'];
			if(!in_array($row['city'],$region))
				$region[] = $row['city'];
		}
		$data['region'] = $region;
		//echo $this->db->last_query();exit;
		return $data;
    }

	public function employee_list($uuid,$company_uuid)
	{
		$this->db->select('ysw_user.user_pic,ysw_user_info.realname,ysw_user_company.employee_dept,ysw_user_company.employee_position');
		$this->db->from('ysw_user_company');
		$this->db->join('ysw_user', 'ysw_user_company.uuid = ysw_user.uuid','left');
		$this->db->join('ysw_user_info', 'ysw_user_company.uuid = ysw_user_info.uuid','left');
		$this->db->where('ysw_user_company.company_uuid',$company_uuid);
		$this->db->where('ysw_user_company.uuid !=',$uuid);
		$query = $this->db->get();
		return $query->result_array();
	}

	//2014-12-02

	//添加公司
	function insert_company($data)
	{
		$this->db->insert('ysw_company',$data);
	}

	/**
	 * jeff 2014/12/4
	 * 查询公司
	 */
	 public function company_list($column = ' * ',$where='',$limit='',$order_by='')
	 {
		$this->db->select($column);
		if($where)
			$this->db->where($where);
		$limit = intval($limit);
		if($limit)
			$this->db->limit($limit);
		if($order_by)			
			$this->db->order_by($order_by);
		return $this->db->get($this->table_name)->result();
	 }

	
	/**
	 *
	 */
	public function get_names($ids=array(),$column='company_uuid',$order_by='')
	{
		$data = array();
		if($order_by)
			$this->db->order_by($order_by);
		if($ids)
			$this->db->where_in($column,$ids);
		$query = $this->db->get($this->table_name);
		if(! $query) return FALSE;

		foreach($query->result() as $row)
		{
			$data[$row->$column]=$row->company_name;
		}
		return $data;
	}

	/*
	* column 为查询的字段,
	* company_uuid 公司id
	* 取数据
	*/
	public function fetch_id($company_uuid='',$column='*' , $where='')
	{
		if(!$company_uuid) return FALSE;
		$this->db->where('company_uuid',$company_uuid);
		if($where)
			$this->db->where($where);
		$this->db->select($column);
		return $this->db->get($this->table_name)->row();
		
	}
	/**
	*
	*/
	public function lists($pagesize=0,$count=20,$where='',$order_by='')
	{
		$data = $result = array();
		//取task总数
		if($where)
			$this->db->where($where);
		$total_rows = $this->db->count_all_results($this->table_name);
		$result['total_rows'] = $total_rows;

		
		//取task  limit20列表
		$pagesize = intval($pagesize);
		$count = intval($count);
		if($where)
			$this->db->where($where);
		$this->db->select('*');			
		$this->db->limit($count,$pagesize);
		$this->db->from($this->table_name);
		if($order_by)
			$this->db->order_by($order_by);
		$result['data'] = $this->db->get()->result();
		return $result;
	}

	//读取公司状态
	public function company_status($uuid,$company_uuid)
	{
		$this->db->select('status');
		$query = $this->db->get_where('ysw_company',array('create_uuid' => $uuid,'company_uuid ' => $company_uuid));
		return $query->row_array();
	}

	//删除公司（修改公司状态）
	public function del_company($uuid,$company_uuid,$status)
	{
		if($status == 1)
		{
			$status = 3 ;
		}
		else
		{
			$status = 2 ;
		}
		$data = array(
		'status' => $status
		);
		$this->db->update('ysw_company',$data,array('create_uuid' => $uuid,'company_uuid' => $company_uuid));
	}

	//公司相关产品
	public function links_product($company_uuid)
	{
		$this->db->select('product_uuid,product_icon,product_name,radio1,radio2,product_type');
		$query = $this->db->get_where('ysw_product',array('status'=>'1','company_uuid'=>$company_uuid));
		return $query->result();
	}

	//公司类型
	public function company_type()
	{
		$this->db->select('id,name,parent');
		$this->db->order_by('order asc');
		$query = $this->db->get_where('ysw_company_type');
		/*foreach($query->result() as $row)
		{
			$company_type[$row->id] = $row->name;
		}*/
		return $query->result_array();
	}

	//公司成员
	public function member($company_uuid)
	{
		$this->db->select('uuid');
		$query = $this->db->get_where('ysw_user_company',array('company_uuid'=>$company_uuid,'status'=>'1'));
		$member = '';
		foreach($query->result() as $row)
		{
			$member = $member.','.$row->uuid;
		}
		return $member;
	}

	//读取成员是否纠错和纠错的处理状态
	public function correction($uuid,$company_uuid)
	{
		$this->db->select('status');
		$query = $this->db->get_where('ysw_company_update',array('create_uuid'=>$uuid,'company_uuid'=>$company_uuid,'status <'=>'2'));
		return $query->row();
	}

	//更新纠错信息
	public function update_correction($data,$company_uuid,$uuid)
	{
		$this->db->update('ysw_company_update',$data,array('company_uuid'=>$company_uuid,'create_uuid'=>$uuid,'status'=>'0'));
	}

	//新增纠错信息
	public function insert_correction($data)
	{
		$this->db->insert('ysw_company_update',$data);$this->db->last_query();
	}

	//公司类型
	public function company_types($parent)
	{
		$this->db->select('id,name');
		$this->db->order_by('order asc');
		$query = $this->db->get_where('ysw_company_type',array('parent'=>$parent,'status'=>'0'));
		foreach($query->result() as $row)
		{
			$company_type[$row->id] = $row->name;
		}
		return $company_type;
	}

	//公司列表信息
	public function company_lists($where,$order,$keywords,$num,$page)
	{
		$this->db->from('ysw_company');
		if(is_array($where))
		{
			foreach($where as $key=>$value)
			{
				if($key == 'company_type' || $key == 'region')
				{
					if($key == 'company_type')
					{
						$str = '';
						foreach(explode(',',$value) as $v)
						{
							if($str !='')
							{
								$str = $str.' or concat(\',\','.$key.',\',\') like \'%,'.$v.',%\'';
							}
							else
							{
								$str = 'concat(\',\','.$key.',\',\') like \'%,'.$v.',%\'';
							}
						}
						$this->db->where('('.$str.')');
					}
					if($key == 'region')
					{
						$str2 = '';
						foreach(explode(',',$value) as $v)
						{
							if($str2 !='')
							{
								$str2 = $str2.' or province = '.$v.' or city = '.$v ;
							}
							else
							{
								$str2 = 'province = '.$v.' or city = '.$v;
							}
						}
						$this->db->where('('.$str2.')');
					}
				}
				else
				{
					$this->db->where($key,$value);
				}
			}	
		}
		if(!empty($keywords))
		{
			$this->db->like('company_name',$keywords);
		}
		if($order != '')
		{
			$this->db->order_by($order);
		}
		else
		{
			$this->db->order_by('create_time desc');
		}
		$this->db->where(array('status'=>'1','checked <'=>'2'));
		$this->db->limit($num,$num*($page-1));
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result();
	}

	//公司总数
	public function total_company($where,$order,$keywords)
	{
		$this->db->from('ysw_company');
		if(is_array($where))
		{
			foreach($where as $key=>$value)
			{
				if($key == 'company_type' || $key == 'region')
				{
					if($key == 'company_type')
					{
						$str = '';
						foreach(explode(',',$value) as $v)
						{
							if($str !='')
							{
								$str = $str.' or concat(\',\','.$key.',\',\') like \'%,'.$v.',%\'';
							}
							else
							{
								$str = 'concat(\',\','.$key.',\',\') like \'%,'.$v.',%\'';
							}
						}
						$this->db->where('('.$str.')');
					}
					if($key == 'region')
					{
						$str2 = '';
						foreach(explode(',',$value) as $v)
						{
							if($str2 !='')
							{
								$str2 = $str2.' or province = '.$v.' or city = '.$v ;
							}
							else
							{
								$str2 = 'province = '.$v.' or city = '.$v;
							}
						}
						$this->db->where('('.$str2.')');
					}
				}
				else
				{
					$this->db->where($key,$value);
				}
			}	
		}
		if(!empty($keywords))
		{
			$this->db->like('company_name',$keywords);
		}
		if($order != '')
		{
			$this->db->order_by($order);
		}
		else
		{
			$this->db->order_by('create_time desc');
		}
		//$this->db->where('status <','2');
		$this->db->where(array('status'=>'1','checked <'=>'2'));
		$query = $this->db->get();
		return $query->num_rows();
	}

	//新进公司
	public function new_company()
	{
		$this->db->select('company_uuid,company_name,company_desc,company_pic');
		$this->db->order_by('create_time desc');
		$this->db->limit('5');
		$query = $this->db->get_where('ysw_company',array('status'=>'1','checked <'=>'2','company_pic !='=>'','company_pic !='=>'0'));
		return $query->result();
	}

	//外包服务商
	public function company()
	{
		$this->db->select('id,name,parent');
		$this->db->from('ysw_company_type');
		$this->db->where(array('parent'=>6,'status'=>0));
		$this->db->order_by('order asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function companys($type)
	{
		$this->db->select('company_uuid,company_name,company_desc,company_pic');
		$this->db->where('concat(\',\',company_type,\',\') like \'%,'.$type.',%\'');
		$this->db->limit('6');
		$this->db->order_by('recommend desc , order desc , create_time desc');
		$query = $this->db->get_where('ysw_company',array('status'=>1,'checked'=>1));
		$arr = array();
		foreach($query->result() as $row)
		{
			$arr[] = array(
				'company_uuid'=>$row->company_uuid,
				'company_name'=>$row->company_name,
				'company_desc'=>$row->company_desc,
				'company_pic'=>$row->company_pic
			);
		}
		return $arr;
	}

	//修改公司纠错状态
	public function updating($company_uuid)
	{
		$data = array('updating'=>1);
		$this->db->update('ysw_company',$data,array('company_uuid'=>$company_uuid));
	}



}