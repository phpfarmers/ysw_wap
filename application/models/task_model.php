<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
* jeff 2014/11/17
*/
class Task_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'task';
	}

	
	/**
	*
	*/
	public function lists($pagesize=0,$count=20,$where='',$order_by='',$groupby=array())
	{
		$data = $task_target_ids = $product_steps = $product_uuids = $result = $total_product_uuid = $total_step = $total_target = array();
		//取task总数
		if($where)
			$this->db->where($where);
		$total_rows = $this->db->count_all_results($this->table_name);
		$result['total_rows'] = $total_rows;

		if($groupby)
		{
			//取合并后的task总数，用于分页
			if($where)
				$this->db->where($where);
			$this->db->from($this->table_name);
			//$this->db->group_by($groupby);
			$results = $this->db->get();
			$result['page_rows'] = $results->num_rows;
		}
		$result['page_rows'] = $result['page_rows']?$result['page_rows']:$result['total_rows'];
		//取task  limit20列表
		$pagesize = intval($pagesize);
		$count = intval($count);
		if($where)
			$this->db->where($where);
		//$this->db->select($this->table_name.'.*');
		$this->db->select('task_uuid,title,amount,create_time,open_time,end_time,cycle,views,intents,stars,urgency,hidden,success,task_target_id,product_uuid,product_step');
		$this->db->limit($count,$pagesize);
		$this->db->from($this->table_name);
		$this->db->order_by($this->db->dbprefix.'task'.'.success asc');
		if($order_by)
		{
			$this->db->order_by($order_by);
		}
		else
		{	
			$this->db->order_by($this->db->dbprefix.'task'.'.stars desc');
			/*//默认以会员级别排序
			$this->db->order_by($this->db->dbprefix.'user'.'.user_grade desc');
			$this->db->join($this->db->dbprefix.'user',$this->db->dbprefix.'user'.'.uuid'.'='.$this->table_name.'.uuid','left');*/
		}
		$this->db->order_by($this->db->dbprefix.'task'.'.id desc');
		/*if($groupby)
			$this->db->group_by($groupby);*/
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		foreach($query->result() as $row)
		{
			$data[] = $row;
			if(!in_array($row->product_uuid,$product_uuids))
				$product_uuids[] = $row->product_uuid;
			if(!in_array($row->product_step,$product_steps))
				$product_steps[] = $row->product_step;
			if(!in_array($row->task_target_id,$task_target_ids))
				$task_target_ids[] = $row->task_target_id;
		}
		$result['data'] = $data;
		$result['product_uuids'] = $product_uuids;
		$result['product_steps'] = $product_steps;
		$result['task_target_ids'] = $task_target_ids;
		
		return $result;
	}
	
	/**
	*update
	*/
	public function update($data=array())
	{
		if(empty($data)) return FALSE;

		$task_uuid = isset($data['task_uuid'])&&$data['task_uuid']?$data['task_uuid']:'';
		if(!$task_uuid) return FALSE;
		unset($data['task_uuid']);
		$this->db->where('task_uuid',$task_uuid);
		if($this->db->update($this->table_name,$data)) return TRUE;

		return FALSE;		
	}

	/**
	*delete
	*/
	public function delete($task_uuid='')
	{
		if(!$task_uuid) return FALSE;
		$this->db->where('task_uuid',$task_uuid);
		if($this->db->delete($this->table_name)) return TRUE;

		return FALSE;		
	}

	/**
	*
	*/
	public function get_name($column='task_uuid',$where_in = array())
	{
		$data = array();
		if($where_in && is_array($where_in) && !empty($where_in))
			$this->db->where_in($column,$where_in);
		$query = $this->db->get($this->table_name);
		if(! $query) return FALSE;

		foreach($query->result() as $row)
		{
			$data[$row->$column]=$row->task_name;
		}
		return $data;
	}

	/*
	* column 为查询的字段,
	* task_uuid 会员id
	* 取数据
	*/
	public function fetch_id($task_uuid='',$column='*',$where = '')
	{
		if(!$task_uuid) return FALSE;
		if($where)
			$this->db->where($where);

		$this->db->where('task_uuid',$task_uuid);
		$this->db->select($column);
		return $this->db->get($this->table_name)->row();
		
	}

	/*
	* 
	* 验证数据
	*/
	public function check_name($name='',$task_uuid='')
	{
		if(!$name) return FALSE;

		$this->db->where('username',$name);
		if($task_uuid)
			$this->db->where('task_uuid !=',$task_uuid);

		$this->db->from($this->table_name);
		return $this->db->count_all_results();		
	}

	/**
	* 用户部份调用
	*/
	public function task_list($column = '*',$where='',$limit='',$order_by='' ,$groupby=array())
	{
		$data = $task_target_ids = $product_steps = $product_uuids = $uuids = $result = array();
		$this->db->select($this->table_name.'.'.$column);
		if($where)
			$this->db->where($where);
		$limit = intval($limit);
		if($limit)
			$this->db->limit($limit);
		$this->db->from($this->table_name);
		if($order_by)
		{
			$this->db->order_by($order_by);
		}
		else
		{//默认以会员级别排序
			$this->db->order_by($this->db->dbprefix.'user'.'.user_grade desc');
			$this->db->join($this->db->dbprefix.'user',$this->db->dbprefix.'user'.'.uuid'.'='.$this->table_name.'.uuid','left');
		}
		if($groupby)
			$this->db->group_by($groupby);
		$query = $this->db->get();
		if(!$query) return false;
		foreach($query->result() as $row)
		{
			$data[] = $row;
			if(!in_array($row->product_uuid,$product_uuids))
				$product_uuids[] = $row->product_uuid;
			if(!$order_by && !in_array($row->uuid,$uuids))
				$uuids[] = $row->uuid;
		}
		$result['data'] = $data;
		$result['uuids'] = $uuids;
		$result['product_uuids'] = $product_uuids;
		return $result;
	}

	//热门合作
	public function hot_task()
	{
		$this->db->select('task_uuid,task_target_id,ysw_task.product_uuid as product_uuid,product_icon,title,amount');
		$this->db->join('ysw_task_target','ysw_task.task_target_id = ysw_task_target.id','left');
		$this->db->join('ysw_product','ysw_task.product_uuid = ysw_product.product_uuid','left');
		$this->db->join('ysw_company','ysw_product.company_uuid = ysw_company.company_uuid','left');
		$this->db->order_by('ysw_task.recommend desc,ysw_task.order desc,ysw_task.intents desc');
		$this->db->group_by('ysw_task.product_uuid,ysw_task.task_target_id');
		$this->db->limit('5');
		$query = $this->db->get_where('ysw_task',array('ysw_task.status'=>'1','ysw_task.checked'=>'1','ysw_task.product_uuid !='=>'','ysw_task.open_time !='=>'','ysw_product.product_icon !='=>''));
		return $query->result();
	}

	//合作类型
	public function task_target($parent,$grade)
	{
		$this->db->select('id,name');
		$this->db->order_by('order asc');
		$query = $this->db->get_where('ysw_task_target',array('parent'=>$parent,'grade'=>$grade,'status'=>'0'));
		foreach($query->result() as $row)
		{
			$target[$row->id] = $row->name;
		}
		return $target;
	}

	//合作列表
	public function task_lists($where,$order,$keywords,$num,$page,$entrusted,$task_target_id)
	{
		// product_platform
		if(is_array($where))
		{
			foreach($where as $key=>$value)
			{
				if($key == 'product_platform' || $key == 'task_target_id' || $key == 'product_type' || $key == 'region')
				{
					if($key == 'product_platform')
					{
						$str = '';
						foreach(explode(',',$value) as $v)
						{
							if($str !='')
							{
								$str = $str.' or concat(\',\',platform,\',\') like \'%,'.$v.',%\'';
							}
							else
							{
								$str = 'concat(\',\',platform,\',\') like \'%,'.$v.',%\'';
							}
						}
						$this->db->where('('.$str.')');
					}
					if($key == 'product_type')
					{
						$str1 = '';
						foreach(explode(',',$value) as $v)
						{
							if($str1 !='')
							{
								$str1 = $str1.' or concat(\',\','.$key.',\',\') like \'%,'.$v.',%\'';
							}
							else
							{
								$str1 = 'concat(\',\','.$key.',\',\') like \'%,'.$v.',%\'';
							}
						}
						$this->db->where('('.$str1.')');
					}
					if($key == 'task_target_id')
					{
						$str2 = '';
						foreach(explode(',',$value) as $v)
						{
							if($str2 !='')
							{
								$str2 = $str2.' or concat(\',\','.$key.',\',\') like \'%,'.$v.',%\'';
							}
							else
							{
								$str2 = 'concat(\',\','.$key.',\',\') like \'%,'.$v.',%\'';
							}
						}
						$this->db->where('('.$str2.')');
					}
					if($key == 'region')
					{
						$str3 = '';
						foreach(explode(',',$value) as $v)
						{
							if($str3 !='')
							{
								$str3 = $str3.' or ysw_user_info.province = '.$v.' or ysw_user_info.city = '.$v ;
							}
							else
							{
								$str3 = 'ysw_user_info.province = '.$v.' or ysw_user_info.city = '.$v;
							}
						}
						$this->db->where('('.$str3.')');
					}
				}
				else
				{
					$this->db->where($key,$value);
				}
			}	
		}
		$this->db->select('task_uuid,title,amount,ysw_task.create_time,ysw_task.open_time,end_time,cycle,views,intents,stars,urgency,hidden,name,success');
		//$this->db->select('*');
		$this->db->from('ysw_task');
		$this->db->join('ysw_task_target','ysw_task.task_target_id=ysw_task_target.id','left');
		$this->db->join('ysw_product','ysw_task.product_uuid=ysw_product.product_uuid','left');
		$this->db->join('ysw_user_info','ysw_task.uuid=ysw_user_info.uuid','left');
		//$this->db->where('(ysw_task.status = 1 or ysw_task.status = 4)');
		$this->db->where(array('ysw_task.status'=>'1','ysw_task.checked'=>'1'));
		if(!empty($keywords))
		{
			$this->db->like('ysw_task.title',$keywords);
		}
		if(!empty($entrusted))
		{
			$this->db->where('ysw_task.entrusted',$entrusted);
			//$this->db->where('ysw_task.entrusted_status >','0');
		}
		if(!empty($task_target_id))
		{
			$this->db->where('ysw_task.task_target_id',$task_target_id);
		}
		if($order != '')
		{
			if($order =='complex desc')
			{
				$this->db->order_by('ysw_task.stars desc');
			}
			else
			{
				$this->db->order_by('ysw_task.'.$order);
			}
		}
		else
		{
			$this->db->order_by('ysw_task.stars desc');
		}
		$this->db->limit($num,$num*($page-1));
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result();
	}

	//合作总数
	public function total_task($where,$order,$keywords,$entrusted,$task_target_id)
	{
		if(is_array($where))
		{
			foreach($where as $key=>$value)
			{
				if($key == 'product_platform' || $key == 'task_target_id' || $key == 'product_type' || $key == 'region')
				{
					if($key == 'product_platform')
					{
						$str = '';
						foreach(explode(',',$value) as $v)
						{
							if($str !='')
							{
								$str = $str.' or concat(\',\',platform,\',\') like \'%,'.$v.',%\'';
							}
							else
							{
								$str = 'concat(\',\',platform,\',\') like \'%,'.$v.',%\'';
							}
						}
						$this->db->where('('.$str.')');
					}
					if($key == 'product_type')
					{
						$str1 = '';
						foreach(explode(',',$value) as $v)
						{
							if($str1 !='')
							{
								$str1 = $str1.' or concat(\',\','.$key.',\',\') like \'%,'.$v.',%\'';
							}
							else
							{
								$str1 = 'concat(\',\','.$key.',\',\') like \'%,'.$v.',%\'';
							}
						}
						$this->db->where('('.$str1.')');
					}
					if($key == 'task_target_id')
					{
						$str2 = '';
						foreach(explode(',',$value) as $v)
						{
							if($str2 !='')
							{
								$str2 = $str2.' or concat(\',\','.$key.',\',\') like \'%,'.$v.',%\'';
							}
							else
							{
								$str2 = 'concat(\',\','.$key.',\',\') like \'%,'.$v.',%\'';
							}
						}
						$this->db->where('('.$str2.')');
					}
					if($key == 'region')
					{
						$str3 = '';
						foreach(explode(',',$value) as $v)
						{
							if($str3 !='')
							{
								$str3 = $str3.' or ysw_user_info.province = '.$v.' or ysw_user_info.city = '.$v ;
							}
							else
							{
								$str3 = 'ysw_user_info.province = '.$v.' or ysw_user_info.city = '.$v;
							}
						}
						$this->db->where('('.$str3.')');
					}
				}
				else
				{
					$this->db->where($key,$value);
				}
			}	
		}
		$this->db->from('ysw_task');
		$this->db->join('ysw_task_target','ysw_task.task_target_id=ysw_task_target.id','left');
		$this->db->join('ysw_product','ysw_task.product_uuid=ysw_product.product_uuid','left');
		$this->db->join('ysw_user_info','ysw_task.uuid=ysw_user_info.uuid','left');
		//$this->db->where('ysw_task.status','1');
		//$this->db->where('(ysw_task.status = 1 or ysw_task.status = 4)');
		$this->db->where(array('ysw_task.status'=>'1','ysw_task.checked'=>'1'));
		if(!empty($keywords))
		{
			$this->db->like('ysw_task.title',$keywords);
		}
		if(!empty($entrusted))
		{
			$this->db->where('ysw_task.entrusted',$entrusted);
			//$this->db->where('ysw_task.entrusted_status >','0');
		}
		if(!empty($task_target_id))
		{
			$this->db->where('ysw_task.task_target_id',$task_target_id);
		}
		if($order != '')
		{
			if($order =='complex desc')
			{
				$this->db->order_by('ysw_task.stars desc');
			}
			else
			{
				$this->db->order_by('ysw_task.'.$order);
			}
		}
		else
		{
			$this->db->order_by('ysw_task.stars desc');
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	//判断当前合作是否已收藏
	public function collect_num($task_uuid,$uuid)
	{
		$query = $this->db->get_where('ysw_task_collection',array('task_uuid'=>$task_uuid,'uuid'=>$uuid));
		return $query->num_rows();
	}

	//添加收藏
	public function add_collect($data)
	{
		$this->db->insert('ysw_task_collection',$data);
	}

	//合作详细信息
	public function task_info($task_uuid,$uuid='')
	{
		$this->db->select('ysw_task.task_uuid,ysw_task.uuid,ysw_task.product_uuid,ysw_task.task_target_id,ysw_task.product_step,ysw_task.product_step_percent,ysw_task.area,ysw_task.info,ysw_task.desc,ysw_task.create_time,ysw_task.start_time,ysw_task.end_time,ysw_task.team_step,ysw_task.amount,ysw_task.stock,ysw_task.cycle,ysw_task.prospectus,ysw_task.financing,ysw_task.partner_num,ysw_task.platform,ysw_task.requires,ysw_task.styles,ysw_task.content_serialize,ysw_task.partner_type,ysw_task.partner_method,ysw_task.limit_time,ysw_task.entrusted,ysw_task.creater,ysw_task.title,ysw_task.views,ysw_task.intents,ysw_task.stars,ysw_task.sn,ysw_task.admin_info,ysw_task.open_time,ysw_task.success,ysw_task.status,ysw_task_target.name,ysw_product.product_icon,ysw_product.product_name,ysw_product.product_platform,ysw_product.radio1,ysw_product.radio2,ysw_product.product_type,ysw_product.single_type');
		$this->db->from('ysw_task');
		$this->db->join('ysw_task_target','ysw_task.task_target_id = ysw_task_target.id','left');
		$this->db->join('ysw_product','ysw_task.product_uuid = ysw_product.product_uuid','left');
		//$this->db->where(array('ysw_task.task_uuid'=>$task_uuid,'ysw_task.status'=>'1','ysw_task.checked'=>'1'));
		$this->db->where(array('ysw_task.task_uuid'=>$task_uuid));
		if($uuid =='')
		{
			$this->db->where(array('ysw_task.status' => '1','ysw_task.checked' => '1'));
		}
		else
		{
			$this->db->where('((ysw_task.status = 1 and ysw_task.checked = 1) or (ysw_task.status = 1 and ysw_task.uuid="'.$uuid.'"))');
		}
		$query = $this->db->get();
		return $query->row();
	}

	//产品平台类型
	public function plat_type()
	{
		$this->db->select('id,platform_name');
		$query = $this->db->get_where('ysw_product_platform',array('status'=>'0'));
		foreach($query->result() as $row)
		{
			$types[$row->id] = $row->platform_name;
		}
		return $types;
	}

	//合作发布者基本信息
	public function creater_info($uuid)
	{
		$this->db->select('ysw_user.uuid as uuid,username,nickname,mobile,mobile_checked,email_checked,iscompany,user_grade,email,intergral,prestige,ysw_user.user_pic as user_pic,qq,realname,ysw_user_info.province as province,ysw_user_info.city as city,weixin');
		$this->db->from('ysw_user');
		$this->db->join('ysw_user_info','ysw_user.uuid = ysw_user_info.uuid','left');
		$this->db->where(array('ysw_user.uuid'=>$uuid));
		$query = $this->db->get();
		return $query->row();
	}

	//创建者当前关联公司
	public function creater_company($uuid)
	{
		$this->db->select('company_name,employee_position');
		$this->db->from('ysw_user_company');
		$this->db->join('ysw_company','ysw_user_company.company_uuid = ysw_company.company_uuid','left');
		$this->db->where(array('ysw_user_company.uuid'=>$uuid,'ysw_user_company.status <'=>'2'));
		$query = $this->db->get();
		return $query->row();
	}



	//所在地
	public function region()
	{
		$this->db->select('id,name');
		$query = $this->db->get_where('ysw_region');
		foreach($query->result() as $row)
		{
			$region[$row->id] = $row->name;
		}
		return $region;
	}
	
	//添加合作留言
	public function get_comment($data)
	{
		$this->db->insert('ysw_task_comment',$data);
	}

	//合作评论列表
	public function comment_list($task_uuid,$order)
	{
		$this->db->select('ysw_task_comment.id,ysw_task_comment.parent,ysw_task_comment.uuid,ysw_task_comment.comment_uuid,ysw_task_comment.content,ysw_task_comment.up,ysw_task_comment.down,ysw_task_comment.create_time,ysw_user.nickname,ysw_user.user_grade,ysw_user.user_pic,ysw_region.name as province');
		$this->db->from('ysw_task_comment');
		$this->db->join('ysw_user','ysw_task_comment.uuid = ysw_user.uuid','left');
		$this->db->join('ysw_user_info','ysw_task_comment.uuid = ysw_user_info.uuid','left');
		$this->db->join('ysw_region','ysw_user_info.province = ysw_region.id','left');
		$this->db->where('ysw_task_comment.task_uuid',$task_uuid);
		$this->db->where('ysw_task_comment.status','1');
		if($order)
		{
			$this->db->order_by('ysw_task_comment.'.$order);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}

	// 合作评论 顶/踩 的数量
	public function num($comment_uuid,$act)
	{
		$this->db->select($act);
		$query = $this->db->get_where('ysw_task_comment',array('comment_uuid' => $comment_uuid));
		foreach ($query->result_array() as $value) {
			$num = $value[$act];
		}
		return $num;
	}

	// 更新合作评论 顶/踩 的数量
	public function update_num($comment_uuid,$num,$act)
	{
		$data = array($act => $num);
		$this->db->update('ysw_task_comment',$data,array('comment_uuid' => $comment_uuid));
	}

	// 评论参与参与评论人数
	public function comment_join_num($task_uuid,$columns)
	{
		$this->db->from('ysw_task_comment');
		$this->db->where('task_uuid',$task_uuid);
		if($columns)
		{
			$this->db->group_by($columns);
		}
		$this->db->where('status','1');
		$query = $this->db->get();
		return $query->num_rows();
	}

	//提交合作意向
	public function add_intention($data)
	{
		$this->db->insert('ysw_task_intents',$data);
	}

	//判断此合作是否已提交一下
	public function intnets_num($task_uuid,$uuid)
	{
		$query = $this->db->get_where('ysw_task_intents',array('task_uuid'=>$task_uuid,'create_uuid'=>$uuid));
		return $query->num_rows();
	}

	//合作意向列表
	public function intnets_list($task_uuid,$where,$order,$num,$page)
	{
		$this->db->select('ysw_task_intents.intents_uuid,ysw_task_intents.content,ysw_task_intents.create_uuid,ysw_task_intents.hidden,ysw_task_intents.create_time,ysw_task_intents.attention,ysw_user.nickname,ysw_user.mobile,ysw_user.email,ysw_user.user_grade,ysw_user.user_pic,ysw_user.mobile_checked,ysw_user.email_checked,ysw_user.iscompany,ysw_user_info.realname,ysw_user_info.qq,ysw_user_info.weixin,ysw_user_info.province,ysw_user_info.city,ysw_user_card_border.url as border_url,ysw_user_card_bg.url as bg_url,ysw_user_card.card_uuid,ysw_user_card.name as name_s,ysw_user_card.first_name as first_name_s,ysw_user_card.job as job_s,ysw_user_card.company as company_s,ysw_user_card.email as email_s,ysw_user_card.mobile as mobile_s,ysw_user_card.qq as qq_s,ysw_user_card.weixin as weixin_s,ysw_user_card.border as border_s,ysw_user_card.background as background_s');
		$this->db->from('ysw_task_intents');
		$this->db->join('ysw_user','ysw_task_intents.create_uuid = ysw_user.uuid','left');
		$this->db->join('ysw_user_info','ysw_user.uuid = ysw_user_info.uuid','left');
		$this->db->join('ysw_user_card','ysw_user.uuid = ysw_user_card.uuid','left');
		$this->db->join('ysw_user_card_border','ysw_user_card.border=ysw_user_card_border.id','left');
		$this->db->join('ysw_user_card_bg','ysw_user_card.background=ysw_user_card_bg.id','left');
		$this->db->where(array('ysw_task_intents.task_uuid'=>$task_uuid,'ysw_task_intents.checked'=>'1'));
		if($where)
		{
			$this->db->where($where);
		}
		if($order)
		{
			$this->db->order_by($order);
		}
		$this->db->limit($num,$num*($page-1));
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	//合作意向总数
	public function total_intnets($task_uuid,$where,$order)
	{
		$this->db->from('ysw_task_intents');
		$this->db->join('ysw_user','ysw_task_intents.create_uuid = ysw_user.uuid','left');
		$this->db->join('ysw_user_info','ysw_user.uuid = ysw_user_info.uuid','left');
		$this->db->join('ysw_user_card','ysw_user.uuid = ysw_user_card.uuid','left');
		$this->db->join('ysw_user_card_border','ysw_user_card.border=ysw_user_card_border.id','left');
		$this->db->join('ysw_user_card_bg','ysw_user_card.background=ysw_user_card_bg.id','left');
		$this->db->where(array('ysw_task_intents.task_uuid'=>$task_uuid,'ysw_task_intents.checked'=>'1'));
		if($where)
		{
			$this->db->where($where);
		}
		if($order == 'create_time desc')
		{
			$this->db->order_by('ysw_task_intents.'.$order);
		}
		else if($order == 'user_grade desc')
		{
			$this->db->order_by('ysw_user.'.$order);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	//判断会员当前是否关联公司
	public function link_company($uuid)
	{
		$query = $this->db->get_where('ysw_user_company',array('uuid'=>$uuid,'status <'=>2));
		return $query->num_rows();
	}

	//查询会员公司信息
	public function user_company($uuid)
	{
		$this->db->select('company_name,employee_position');
		$this->db->from('ysw_user_company');
		$this->db->join('ysw_company','ysw_user_company.company_uuid = ysw_company.company_uuid','left');
		$this->db->where(array('ysw_user_company.uuid'=>$uuid,'ysw_user_company.status < '=>'2'));
		$query = $this->db->get();
		return $query->row_array();
	}

	//任务点赞
	public function intents_num($task_uuid)
	{
		$this->db->select('intents');
		$query = $this->db->get_where('ysw_task',array('task_uuid'=>$task_uuid));
		foreach($query->result_array() as $row)
		{
			$num = $row['intents'];
		}
		return $num;
	}

	//更新任务意向数
	public function update_intents($task_uuid,$num)
	{
		$data = array('intents'=>$num);
		$this->db->update('ysw_task',$data,array('task_uuid'=>$task_uuid));
	}

	//更新合作浏览量
	public function update_views($task_uuid,$views)
	{
		//echo $task_uuid.'--'.$intents;exit;
		$data = array('views'=>$views +1);
		$this->db->update('ysw_task',$data,array('task_uuid'=>$task_uuid));
	}

	//合作意向列表
	public function intents_lists($task_uuid)
	{
		$this->db->select('create_uuid,task_uuid,nickname,province,city,attention');
		$this->db->from('ysw_task_intents');
		$this->db->join('ysw_user','ysw_task_intents.create_uuid = ysw_user.uuid','left');
		$this->db->join('ysw_user_info','ysw_user.uuid = ysw_user_info.uuid','left');
		$this->db->where(array('ysw_task_intents.task_uuid'=>$task_uuid));
		$query = $this->db->get();
		return $query->result();
	}

	//结束合作
	public function task_ending($create_uuid,$task_uuid)
	{
		$data = array(
			'status'=>'1',
			'creater'=>'0'
		);
		if($task_uuid!='')
		{
			$this->db->where('task_uuid',$task_uuid);
		}
		$this->db->where_in('create_uuid',$create_uuid);
		$this->db->update('ysw_task_intents',$data);
	}

	//修改合作状态
	public function task_end($task_uuid)
	{
		$data = array(
			'success'=>'1'
		);
		$this->db->update('ysw_task',$data,array('task_uuid'=>$task_uuid));
	}

	//最新合作
	public function new_task($limit = 12)
	{
		$this->db->select('task_uuid,title,name,product_icon');
		$this->db->from('ysw_task');
		$this->db->join('ysw_task_target','ysw_task.task_target_id=ysw_task_target.id','left');
		$this->db->join('ysw_product','ysw_task.product_uuid=ysw_product.product_uuid','left');
		$this->db->where(array('ysw_task.status'=>'1','ysw_task.checked'=>'1','ysw_task.product_uuid !='=>'','ysw_task.open_time !='=>'','ysw_product.product_icon !='=>''));
		$this->db->order_by('ysw_task.open_time desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result();
	}

	//热门合作
	public function hot_task_h()
	{
		$this->db->select('task_uuid,title,name,product_icon');
		$this->db->from('ysw_task');
		$this->db->join('ysw_task_target','ysw_task.task_target_id=ysw_task_target.id','left');
		$this->db->join('ysw_product','ysw_task.product_uuid=ysw_product.product_uuid','left');
		$this->db->where(array('ysw_task.status'=>'1','ysw_task.checked'=>'1','ysw_task.product_uuid !='=>'','ysw_task.open_time !='=>'','ysw_product.product_icon !='=>''));
		$this->db->order_by('ysw_task.recommend desc,ysw_task.order desc,ysw_task.intents desc');
		$this->db->limit('7');
		$query = $this->db->get();
		return $query->result();
	}

	//关注提交的意向
	public function attention($intents_uuid,$status)
	{
		if($status == '1')
		{
			$attention = '0';
		}
		else
		{
			$attention = '1';
		}
		$data = array('attention'=>$attention);
		$this->db->update('ysw_task_intents',$data,array('intents_uuid'=>$intents_uuid));
	}

	//判断是否已点赞
	public function praise_num($task_uuid,$uuid)
	{
		$query = $this->db->get_where('ysw_task_upon',array('task_uuid'=>$task_uuid,'uuid'=>$uuid));
		return $query->num_rows();
	}

	//合作点赞
	public function praise($data)
	{
		$this->db->insert('ysw_task_upon',$data);
	}

	//合作数量
	public function partner_num($task_uuid)
	{
		$this->db->select('partner_num');
		$query = $this->db->get_where('ysw_task',array('task_uuid'=>$task_uuid));
		$partner_num = $query->row()->partner_num;
		return $partner_num;
	}

	//修改合作成功状态
	public function success_state($task_uuid)
	{
		$data = array(
			'success'=>'2'
		);
		$this->db->update('ysw_task',$data,array('task_uuid'=>$task_uuid));
	}

	//读取我发布的合作
	public function my_task($uuid)
	{
		$this->db->select('task_uuid,title,success,create_time');
		$query = $this->db->get_where('ysw_task',array('uuid'=>$uuid,'status'=>'1'));
		return $query->result();
	}

	//合作委托
	public function task_trust($arr)
	{
		$this->db->where_in('task_uuid',$arr);
		$query = $this->db->get_where('ysw_task');
		return $query->result();
	}


}