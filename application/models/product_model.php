<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends  CI_Model {
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'product';
	}
	//添加产品
	function insert_product($data)
	{
		$this->db->insert($this->table_name,$data);
	}

	//更新产品关联的公司
	function linked_company($product_uuid,$company_uuid)
	{
		$data = array(
			'company_uuid' =>$company_uuid
		);
		$this->db->update($this->table_name,$data,array('product_uuid' => $product_uuid));
	}
	
	/**
	 * jeff 2014/12/4
	 */
	public function product_list($column = ' * ',$where='',$limit='',$order_by='')
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
	* jeff 2014/12/5
	*/
	public function get_list($select='*',$where_in = array(),$column = 'product_uuid')
	{
		$data = array();
		if($where_in && is_array($where_in) && !empty($where_in))
			$this->db->where_in($column,$where_in);
		$this->db->select($select);
		$query = $this->db->get($this->table_name);
		if(! $query) return FALSE;

		foreach($query->result() as $row)
		{
			$data[$row->$column]=$row;
		}
		return $data;
	}

	/**
	*
	*/
	public function get_name($column='product_uuid',$where_in = array())
	{
		$data = array();
		if($where_in && is_array($where_in) && !empty($where_in))
			$this->db->where_in($column,$where_in);
		$query = $this->db->get($this->table_name);
		if(! $query) return FALSE;

		foreach($query->result() as $row)
		{
			$data[$row->$column]=$row->product_name;
		}
		return $data;
	}

	/**
	*
	*/
	public function get_name_array($column='product_uuid',$where_in = array(),$columnelse=array(''))
	{
		$data = array();
		if($where_in && is_array($where_in) && !empty($where_in))
			$this->db->where_in($column,$where_in);
		$query = $this->db->get($this->table_name);
		if(! $query) return FALSE;

		foreach($query->result() as $row)
		{
			if($columnelse && !empty($columnelse))
			{//处理其它 比如取company_uuid
				foreach($columnelse as $k=>$v)
				{				
					if(isset($row->$v) && $row->$v)
					{
						$data[$k][$row->product_uuid] = $row->$v;
					}
				}
			}

			$data[$column][$row->$column]=$row->product_name;
		}
		return $data;
	}
	/*
	* column 为查询的字段,
	* product_uuid 会员id
	* 取数据
	*/
	public function fetch_id($product_uuid='',$column='*',$where ='')
	{
		if(!$product_uuid) return FALSE;

		$this->db->where('product_uuid',$product_uuid);
		if($where)
			$this->db->where($where);
		$this->db->select($column);
		return $this->db->get($this->table_name)->row();
		
	}

	// 会员中心我发的产品
	public function product_company_list($uuid,$num,$page)
	{
		$this->db->select('ysw_product.product_uuid,ysw_product.product_name,ysw_product.product_icon,ysw_product.checked,ysw_company.company_name');
		$this->db->from('ysw_product');
		$this->db->join('ysw_company', 'ysw_product.company_uuid = ysw_company.company_uuid','left');
		//$this->db->where('ysw_product.uuid',$uuid);
		//$this->db->where('ysw_product.status !=','3');
		$this->db->where(array('ysw_product.uuid'=>$uuid,'ysw_product.status'=>'1'));
		$this->db->order_by('ysw_product.create_time','desc');
		$this->db->limit($num,$num*($page-1));
		$query = $this->db->get();
		return $query->result();
	}

	// 会员中心删除我发布的产品
	public function del_product($product_uuid)
	{
		$data = array(
		'status' => '3' // 修改产品状态
		);
		$this->db->update('ysw_product', $data,array('product_uuid'=>$product_uuid));
	}
	
	/**
	 *
	 */
	public function fetch_column($column = '*',$where='')
	{
		$this->db->select($column);
		if($where)
			$this->db->where($where);
		return $this->db->get($this->table_name);
	}


	/**
	 *
	 *
	 */
	public function get_id($column = '*',$where='')
	{
		$this->db->select($column);
		$this->db->where("status = '1' OR status = '2'");
		if($where)
			$this->db->where($where);
		return $this->db->get($this->table_name)->result();
	}

	/**
	 *
	 *
	 */
	public function get_id_array($where='')
	{
		$data = array();
		$this->db->where('status > 0 and status < 3');
		if($where)
			$this->db->where($where);
		$query = $this->db->get($this->table_name);
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $k=>$v)
			{
				$data[] = $v->product_uuid;
			}
		}
		return $data;
	}
	// 读取产品详细信息
	public function product_info($product_uuid)
	{
		$this->db->select('product_uuid,product_name,product_icon,product_platform,product_type,radio1,radio2,single_type,product_theme,product_style,product_info,product_feature,product_video,product_pic,product_down,company_uuid,create_time');
		$this->db->from('product');
		$this->db->where('product_uuid',$product_uuid);
		$query = $this->db->get();
		return $query->row_array();
	}

	// 更新产品信息
	public function update_product($data,$product_uuid)
	{
		$this->db->update('ysw_product',$data,array('product_uuid'=>$product_uuid));
	}

	// 读取产品关联公司信息
	public function company_info($product_uuid)
	{
		$this->db->select('ysw_product.product_platform,ysw_company.company_uuid,ysw_company.company_name,ysw_company.company_pic,ysw_company.company_type,ysw_company.company_size,ysw_company.province,ysw_company.city,ysw_company.company_desc,ysw_company.company_address,ysw_company.company_web,ysw_company.company_phone,ysw_company.company_email,ysw_company.status,ysw_producer.producer_uuid,ysw_producer.producer_name,ysw_producer.producer_pic,ysw_producer.producer_product,ysw_producer.producer_info,ysw_product_agent.agent_uuid,ysw_product_agent.agent_name,ysw_product_agent.agent_area,ysw_product_agent.agent_platform');
		$this->db->from('ysw_product');
		$this->db->join('ysw_company','ysw_product.company_uuid = ysw_company.company_uuid','left');
		$this->db->join('ysw_producer','ysw_product.product_uuid = ysw_producer.product_uuid','left');
		$this->db->join('ysw_product_agent','ysw_product.product_uuid = ysw_product_agent.product_uuid','left');
		$this->db->where('ysw_product.product_uuid',$product_uuid);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function assort($select = '*',$table = '')
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->order_by('order ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function type_sort()
	{
		$this->db->select('input_name');
		$this->db->from('ysw_product_type');
		$this->db->order_by('order ASC');
		$this->db->group_by('input_name');
		$query = $this->db->get();
		return $query->result_array();
	}

	// 添加游戏制作人信息
	public function insert_producer($data)
	{
		$this->db->insert('ysw_producer',$data);
	}

	// 更新游戏制作人信息
	public function update_producer($data,$producer_uuid)
	{
		$this->db->update('ysw_producer',$data,array('producer_uuid'=>$producer_uuid));
	}

	// 添加游戏合作代理商
	public function insert_agent($data)
	{
		$this->db->insert('ysw_product_agent',$data);
	}

	// 更新游戏合作代理商
	public function update_agent($data,$agent_uuid)
	{
		$this->db->update('ysw_product_agent',$data,array('agent_uuid'=>$agent_uuid));
	}

	//读取产品所对应的品台
	public function product_platform($product_uuid)
	{
		$this->db->select('product_platform');
		$this->db->from('ysw_product');
		$this->db->where('product_uuid',$product_uuid);
		$query = $this->db->get();
		foreach ($query->result_array() as $value)
		{
			$product_platform =  $value['product_platform'];
		}
		return $product_platform;
	}

	//我发布的合作总数
	public function total_rows($uuid) {
		$query = $this->db->get_where('ysw_product',array('ysw_product.uuid'=>$uuid,'ysw_product.status'=>'1'));
		return $query->num_rows();
	}

	/**
	* jeff
	*/
	public function lists($pagesize=0,$count=20,$where='',$order_by='',$groupby=array())
	{
		$result = array();
		//取task总数
		if($where)
			$this->db->where($where);
		$total_rows = $this->db->count_all_results($this->table_name);
		$result['total_rows'] = $total_rows;

		//取product_uuid集合
		if($where)
			$this->db->where($where);
		$this->db->distinct();
		$this->db->select('product_theme');
		$result['theme'] = $this->db->get($this->table_name)->result();
		//取task  limit20列表
		$pagesize = intval($pagesize);
		$count = intval($count);
		if($where)
			$this->db->where($where);
		$this->db->select($this->table_name.'.*');			
		$this->db->limit($count,$pagesize);
		$this->db->from($this->table_name);
		if($order_by)
		{
			$this->db->order_by($order_by);
		}
		else
		{//默认以会员级别排序
			$this->db->order_by($this->db->dbprefix.'user'.'.user_grade desc');
			$this->db->join($this->db->dbprefix.'user',$this->db->dbprefix.'user'.'.uuid'.'='.$this->table_name.'.uuid');
		}
		if($groupby)
			$this->db->group_by($groupby);
		$result['data']	= $this->db->get()->result();
		return $result;
	}

	/* 新进产品 */
	public function new_product()
	{
		$this->db->Select('product_uuid,product_name,product_icon,radio1,radio2,product_type');
		$this->db->limit('5');
		$this->db->order_by('status desc,create_time desc');
		$query = $this->db->get_where('ysw_product',array('status'=>'1','checked <'=>'2','product_icon !='=>''));
		return $query->result();
	}
	
    //游戏分类
	public function product_type()
	{
		$this->db->select('id,type_name');
		$query = $this->db->get('ysw_product_type');
		foreach($query->result() as $row)
		{
			$product_type[$row->id] = $row->type_name;
		}
		return $product_type;
	}

	//产品详细信息
	public function product($product_uuid)
	{
		$this->db->select('product_uuid,product_name,product_icon,product_platform,radio1,radio2,product_type,single_type,product_theme,product_style,product_info,product_feature,product_video,product_down,company_name,ysw_product.sn,ysw_product.checked,ysw_product.company_uuid');
		$this->db->from('ysw_product');
		$this->db->join('ysw_company','ysw_product.company_uuid = ysw_company.company_uuid','left');
		$this->db->where('ysw_product.product_uuid',$product_uuid);
		$query = $this->db->get();
		return $query->row();
	}

	//游戏平台
	public function platform()
	{
		$this->db->select('id,platform_name');
		$query = $this->db->get('ysw_product_platform');
		foreach($query->result() as $row)
		{
			$platform[$row->id] = $row->platform_name;
		}
		return $platform;
	}

	//游戏图片
	public function product_pics($product_uuid)
	{
		$this->db->select('create_time,url');
		$query = $this->db->get_where('ysw_product_album',array('product_uuid'=>$product_uuid,'status'=>'1'));
		return $query->result();
	}

	//产品列表
	public function product_lists($where,$order,$keywords,$num,$page)
	{
		$this->db->from('ysw_product');
		if(is_array($where))
		{
			foreach($where as $key=>$value)
			{
				if($key == 'product_platform' || $key =='product_type')
				{
					if($key == 'product_platform')
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
				}
				else
				{
					$this->db->where($key,$value);
				}
			}	
		}
		if(!empty($keywords))
		{
			$this->db->like('product_name',$keywords);
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

	//产品总数
	public function total_product($where,$order,$keywords)
	{
		$this->db->from('ysw_product');
		if(is_array($where))
		{
			foreach($where as $key=>$value)
			{
				if($key == 'product_platform' || $key =='product_type')
				{
					if($key == 'product_platform')
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
				}
				else
				{
					$this->db->where($key,$value);
				}
			}	
		}
		if(!empty($keywords))
		{
			$this->db->like('product_name',$keywords);
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
		$query = $this->db->get();
		return $query->num_rows();
	}



}