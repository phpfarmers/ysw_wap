<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('product');
		$this->load->library('task');
		$this->load->model('type_model');
		$this->load->model('product_model');
		$this->load->model('task_model');
		$this->load->model('producttype_model');
		$this->lang->load('product');
	}

	

	/**
	 *
	 **/
	public function ajaxtask(){
		$product_uuid = $this->uri->segment(3);
		if(!$product_uuid || strlen(trim($product_uuid)) !== 36)
		{
			echo lang('None').lang('Product');RETURN;
		}
		
		//产品详细信息
		$data['data'] = $this->product_model->product($product_uuid);
		if(!$data['data'])
		{
			echo lang('None').lang('Product');RETURN;
		}
		//product_type
		$data['type'] = $this->producttype_model->get_name();

		$data['platform'] = '';
		if($platform = $data['data']->product_platform)
		{
			$platform_arr = array();
			if(strpos($platform,','))
			{
				$platform_arr = explode(',',$platform);
			}
			else
			{
				$platform_arr[] = intval($platform);
			}
			$this->load->model('platform_model');
			$platform = $this->platform_model->get_name('id',$platform_arr);
			$data['platform'] = implode(',',$platform);
		}

		$this->load->view('ajax/task_product',$data);
	}

	public function index()
	{
		$this->output->cache($this->config->config['cache_time']/60);
		$this->_list();
	}

	public function show()
	{
		$product_uuid = $this->uri->segment(3);
		if(!$product_uuid)
			show_404();
		$this->_show($product_uuid);
	}

	protected function _list()
	{
		$data['web_title'] = '产品-游商网';
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

		//游戏平台
		$data['plat'] = $this->type_model->plat('0');

		//游戏平台(二级)
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

		//游戏类型
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

		//产品列表(判断条件)
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
				//single_type
				if(in_array('single_type',$data['sort']))
				{
					if($key == 'single_type')
					{
						$where['single_type'] = $value;
					}
				}
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
			}
		}

		//产品分页
		$this->load->library('pagination');
		$config['base_url'] = str_replace('/page/'.$page,'',$data['url']).'/page/';
	    $config['total_rows'] = $this->product_model->total_product($where,$order,$keywords);
	    $config['per_page']   = 12;
	    $config['num_links']  = 3;
		if(in_array('page',$data['sort']))
		{
			$config['uri_segment'] = count($data['sort'])*2 + 2;
		}
		else
		{
			$config['uri_segment'] = (count($data['sort'])+1)*2 + 2;
		}
		//$config['uri_segment'] = (count($data['sort']))*2 + 2;
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

		$data['total'] = $config['total_rows'];

		//产品列表
		$data['products'] = $this->product_model->product_lists($where,$order,$keywords,$config['per_page'],$page);

		//游戏平台
		$data['platform'] = $this->product_model->platform();

		//新进产品
		$data['new'] = $this->product_model->new_product();
		$data['type'] = $this->product_model->product_type();

		//热门合作
		$data['hot'] = $this->task_model->hot_task();

		$this->load->view('include/header_12',$data);
		$this->load->view('product',$data);
		$this->load->view('include/footer_12',$data);
	}
	
	protected function _show($product_uuid)
	{

		//产品详细信息
		$data['product'] = $this->product_model->product($product_uuid);
		if(!$data['product'])
		{
			redirect(site_url('prompt/error'), 'refresh');
		}

		//游戏类型
		$data['product_type'] = $this->product_model->product_type();

		//游戏平台
		$data['product_platform'] = $this->product_model->platform();

		//游戏图片
		$data['product_pics'] = $this->product_model->product_pics($product_uuid);

		$data['web_title'] = $data['product']->product_name.' - 产品 - 游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$this->load->view('include/header_12',$data);
		$this->load->view('product_show',$data);
		$this->load->view('include/footer_12',$data);
	}

	//产品下载
	public function download()
	{
		$product_uuid = $this->uri->segment(3);
		if(!$product_uuid)
			show_404();
		$this->_download($product_uuid);
	}

	protected function _download($product_uuid)
	{
		$this->load->model('product_model');
		$this->load->helper('download');
		$download = $this->product_model->fetch_id($product_uuid,' product_down',array('status >'=>'0','status <'=>'3'));//产品信息结果
		if(!$download)
			show_404();
		if($this->input->is_ajax_request())
		{
			//可根据条件返回不同值
			$data = 'Here is some text!';
			$name = 'mytext.txt';
			force_download($name, $data);
		}
		else
		{
			$data = 'Here is some text!';
			$name = 'mytext.txt';
			force_download($name, $data);
		}
	}

}
