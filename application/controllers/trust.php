<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trust extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('product');
		$this->load->library('task');
		$this->load->library('ad');
		$this->load->model('type_model');
		$this->load->model('product_model');
		$this->load->model('task_model');
		$this->load->model('trust_model');
	}

	public function index()
	{
		$this->output->cache($this->config->config['cache_time']/60);
		$this->_list();
	}

	protected function _list()
	{
		$data['web_title'] = '委托-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		//获取当前地址(设置连接初始值)
		if($this->uri->segment('2')!='')
		{
			$data['url'] = current_url();
		}
		else
		{
			$data['url'] = current_url().'/index';
		}

		//获取当前url的属性
		$data['select'] = $this->uri->uri_to_assoc();

		//判断选择那些属性分类
		$data['sort'] = array();
		foreach($data['select'] as $key=>$value)
		{
			$data['sort'][] = $key;
		}

		//设置page默认值
		if(!in_array('page',$data['sort']))
		{
			$data['select']['page'] = '1';
		}
		else
		{
			if($data['select']['page']=='')
			{
				$data['select']['page'] = '1';
			}
		}

		//设置display默认值
		if(!in_array('display',$data['sort']))
		{
			$data['select']['display'] = 'none';
		}
		else
		{
			if($data['select']['display']=='')
			{
				$data['select']['display'] = 'none';
			}
		}

		//设置display默认值
		if(!in_array('display',$data['sort']))
		{
			$data['select']['display'] = 'none';
		}
		else
		{
			if($data['select']['display']=='')
			{
				$data['select']['display'] = 'none';
			}
		}

		//平台类型
		$data['plat'] = $this->type_model->plat('0');

		//合作类型
		$data['target'] = $this->type_model->target('0');

		//项目阶段
		$data['product_step'] = $this->type_model->product_step();

		//平台/合作 类型(二级)
		$sort_p = $this->type_model->assort('ysw_product_platform');
		$sort_t = $this->type_model->assort('ysw_task_target');

		$data['plat_t'] = array();
		$data['target_t'] = array();
		foreach($data['select'] as $key=>$value)
		{
			if($key =='plat')
			{
				if(in_array($data['select']['plat'],$sort_p))
				{
					$data['plat_t'] = $this->type_model->plat($value);
				}
			}
			if($key =='target')
			{
				if(in_array($data['select']['target'],$sort_t))
				{
					$data['target_t'] = $this->type_model->target($value);
				}
			}
		}

		//项目类型
		$types = $this->type_model->types();
		foreach($types as $row)
		{
			if($row->input_name == 'radio1')
			{
				$data['radio1'][$row->id] = $row->type_name;
			}
			if($row->input_name == 'radio2')
			{
				$data['radio2'][$row->id] = $row->type_name;
			}
			if($row->input_name == 'typename')
			{
				$data['checkbox'][$row->id] = $row->type_name;
			}
		}

		//合作列表(判断条件)
		$where = array();
		$order = '';
		$keywords = '';
		foreach($data['select'] as $key=>$value)
		{
			if($key =='order')
			{
				$order = str_replace('-',' ',$value);
			}
			else if($key =='keywords')
			{
				$keywords = rawurldecode($value);				
			}
			else if($key =='page')
			{
				$page = $value;				
			}
			else
			{
				//product_platform
				if(in_array('plat',$data['sort']))
				{
					if($key == 'plat')
					{
						if(!in_array($value,$sort_p))
						{
							$where['product_platform'] = $value;
						}
						else
						{
							foreach($data['plat_t'] as $key_p=>$value_p)
							{
								$arr_1[] = $key_p;
							}
							$where['product_platform'] = implode(',',$arr_1);
						}
					}
				}
				if(in_array('plat_t',$data['sort']))
				{
					if($key == 'plat_t')
					{
						$where['product_platform'] = $value;
					}
				}
				//task_target_id
				if(in_array('target',$data['sort']))
				{
					if($key == 'target')
					{
						if(!in_array($value,$sort_p))
						{
							$where['task_target_id'] = $value;
						}
						else
						{
							foreach($data['target_t'] as $key_t=>$value_t)
							{
								$arr_2[] = $key_t;
							}
							$where['task_target_id'] = implode(',',$arr_2);
						}
					}
				}
				if(in_array('target_t',$data['sort']))
				{
					if($key == 'target_t')
					{
						$where['task_target_id'] = $value;
					}
				}
				//radio1
				if(in_array('radio1',$data['sort']))
				{
					if($key == 'radio1')
					{
						$where['radio1'] = $value;
					}
				}
				//radio2
				if(in_array('radio2',$data['sort']))
				{
					if($key == 'radio2')
					{
						$where['radio2'] = $value;
					}
				}
				//product_step
				if(in_array('product_step',$data['sort']))
				{
					if($key == 'product_step')
					{
						$where['product_step'] = $value;
					}
				}
				//product_type
				if(in_array('checkbox',$data['sort']))
				{
					if($key == 'checkbox')
					{
						$where['product_type'] = implode(',',array_filter(explode('-',$value)));
					}
				}				
			}
		}

		//委托分页
		$this->load->library('pagination');
		$config['base_url'] = str_replace('/page/'.$page,'',$data['url']).'/page/';
		$entrusted = '1';
		$task_target_id = '';
	    $config['total_rows'] = $this->task_model->total_task($where,$order,$keywords,$entrusted,$task_target_id);
	    $config['per_page']   = 20;
	    $config['num_links']  = 3;
		if(in_array('page',$data['sort']))
		{
			$config['uri_segment'] = count($data['sort'])*2 + 2;
		}
		else
		{
			$config['uri_segment'] = (count($data['sort'])+1)*2 + 2;
		}
		//$config['uri_segment'] = count($data['sort'])*2 + 2;
	    $config['use_page_numbers'] = TRUE;

	    $config['first_link'] = '首页';
	    $config['last_link']  = '最后';
	    $config['next_link']  = '下一页';
	    $config['prev_link']  = '上一页';

		$config['num_tag_open']   = '';
	    $config['num_tag_close']  = '';

	    $config['cur_tag_open']   = '<a class="page_currer">';
	    $config['cur_tag_close']  = '</a>';

	    $config['prev_tag_open']  = '';
	    $config['prev_tag_close'] = '';

	    $config['next_tag_open'] = '';
	    $config['next_tag_close'] = '';

	    $config['last_tag_open'] = '';
	    $config['last_tag_close'] = '';

	    $config['first_tag_open'] = '';
	    $config['first_tag_close'] = '';

		$config['full_tag_open'] = '<div id="paging">';
		$config['full_tag_close'] = '</div>';

    	$this->pagination->initialize($config);

		//委托列表
		$data['lists'] = $this->task_model->task_lists($where,$order,$keywords,$config['per_page'],$page,$entrusted,$task_target_id);

		//所有地区
		$this->load->model('region_model');

		//所有地区
		$data['region_all'] = $this->task_model->region();

		//地区1
		$region_t = array(
			'江浙沪'=>'江苏,浙江,上海',
			'珠三角'=>'广州,深圳,中山,珠海,佛山,东莞,惠州',
			'京津唐'=>'北京,天津,唐山',
			'东三省'=>'黑龙江,吉林,辽宁',
			'港澳台'=>'香港,澳门,台湾'
			);
		foreach($region_t as $key=>$value)
		{
			$arrs = $this->region_model->region_hot(explode(',',$value));
			$str = array();
			foreach($arrs as $key_t=>$value_t)
			{
				$str[] = $key_t;
			}
			$data['region_t'][$key] = implode('-',$str);
		}

		//地区2
		$arr = array('北京','上海','广州','深圳','重庆');
		$data['region_h'] = $this->region_model->region_hot($arr);

		//地区3
		$data['region'] = $this->region_model->region();

		//用户真实IP
		$ip = $this->input->ip_address();

		//更具IP获取地理位置
		$this->load->model('city_model');
		$city = $this->city_model->getCity($ip);

		$data['city'] = str_replace('市','',$city['city']);
		foreach($data['region'] as $key=>$value)
		{
			if($value == $data['city'])
			{
				$data['city_id'] = $key;
			}
		}

		//新进产品
		$data['new'] = $this->product_model->new_product();
		$data['type'] = $this->product_model->product_type();

		//热门合作
		$data['hot'] = $this->task_model->hot_task();

		$this->load->view('include/header1',$data);
		$this->load->view('trust',$data);
		$this->load->view('include/footer_12',$data);
	}

	//跳转页面
	public function redirect()
	{
		@session_start();
		$_SESSION['redirect'] = str_replace('/redirect','',$_SERVER['REQUEST_URI']);
		redirect(site_url('user/login'), 'refresh');
	}

	//加载委托信息
	public function load_trust()
	{
		//默认联系方式
		if(UUID)
		{
			$this->load->model('user_model');
			$data['contact'] = $this->user_model->contact(UUID);
		}
		else
		{
			$data['contact'] = array(
				'mobile' => '',
				'qq' => '',
				'email' => ''
				);
		}
		//获取我添加到俄合作
		$data['my_task'] = $this->task_model->my_task(UUID);
		$data['in_task'] = $data['end_task'] = array();
		if($data['my_task'])
		{
			foreach($data['my_task'] as $row)
			{
				if($row->success > 0)
				{
					$data['end_task'][] = $row;
				}
				else
				{
					$data['in_task'][] = $row;
				}
			}
		}
		$this->load->view('load_trust',$data);
	}

	//添加委托
	public function add_trust()
	{
		header("Content-type:text/html;charset=utf-8");
		$msg = $this->input->post('msg', TRUE);
		$mobile = $this->input->post('mobile', TRUE);
		$qq = $this->input->post('qq', TRUE);
		$email = $this->input->post('email', TRUE);
		$task_uuid = $this->input->post('task_uuid', TRUE);
		if($task_uuid !='')
		{
			$arr = array_filter(explode(',',$task_uuid));
			$this->load->model('task_model');
			$task_trust = $this->task_model->task_trust($arr);
		}

		/* 验证表单 */
		$this->load->library('form_validation');
		$this->form_validation->set_rules('msg','委托描述','required');

		if ($this->form_validation->run() == FALSE)
		{
			@session_start();
			$_SESSION['redirect'] = str_replace('/redirect','',$_SERVER['REQUEST_URI']);
			redirect(site_url('prompt/add_error'), 'refresh');
		}
		else
		{
			if(count($task_trust)>0)
			{
				foreach($task_trust as $row)
				{
					//合作信息
					$data = $row;
					$data->id = '';
					//委托信息
					$sql = "select uuid() uuid";
					$q = $this->db->query($sql)->row();
					$entrust_uuid = $q->uuid;
					$data->entrust_uuid = $entrust_uuid;
					$data->entrust_uuid = $entrust_uuid;
					$data->msg = $msg;
					$data->mobile = $mobile;
					$data->qq = $qq;
					$data->email = $email;
					$data->entrust_createtime = strtotime(date("Y-m-d H:i:s"));
					$this->trust_model->add_trust($data);
				}
			}
			else
			{
				$sql = "select uuid() uuid";
				$q = $this->db->query($sql)->row();
				$entrust_uuid = $q->uuid;

				$data =array(
					'entrust_uuid' => $entrust_uuid,
					'uuid' => UUID,
					'msg' => $msg,
					'mobile' => $mobile,
					'qq' => $qq,
					'email' => $email,
					'entrust_createtime' => strtotime(date("Y-m-d H:i:s"))
				);
				$this->trust_model->add_trust($data);
			}
			redirect(site_url('trust'), 'refresh');
		}
	}

}
