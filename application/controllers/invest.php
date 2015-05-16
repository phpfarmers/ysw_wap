<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Invest extends MY_Controller {

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
	}

	public function index()
	{
		$this->output->cache($this->config->config['cache_time']/60);
		$this->_list();
	}

	protected function _list()
	{
		$data['web_title'] = '合作-游商网';
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

		//项目阶段
		$data['product_step'] = $this->type_model->product_step();

		//平台/合作 类型(二级)
		$sort_p = $this->type_model->assort('ysw_product_platform');

		$data['plat_t'] = array();
		foreach($data['select'] as $key=>$value)
		{
			if($key =='plat')
			{
				if(in_array($data['select']['plat'],$sort_p))
				{
					$data['plat_t'] = $this->type_model->plat($value);
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
				//product_type
				if(in_array('checkbox',$data['sort']))
				{
					if($key == 'checkbox')
					{
						$where['product_type'] = implode(',',array_filter(explode('-',$value)));
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
				//region
				if(in_array('region',$data['sort']))
				{
					if($key == 'region')
					{
						$where['region'] = implode(',',array_filter(explode('-',$value)));
					}
				}
			}
		}

		//合作分页
		$this->load->library('pagination');
		$config['base_url'] = str_replace('/page/'.$page,'',$data['url']).'/page/';
		$entrusted = '';
		$task_target_id = '4';
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

		//合作列表
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
		
		$this->load->view('include/header_12',$data);
		$this->load->view('invest',$data);
		$this->load->view('include/footer_12',$data);
	}

}
