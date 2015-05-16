<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('product');
		$this->load->library('task');
		$this->load->model('type_model');
		$this->load->model('product_model');
		$this->load->model('task_model');
	}

	public function index()
	{
		$this->output->cache($this->config->config['cache_time']/60);
		$this->_list();
	}

	public function show()
	{
		$company_uuid = $this->uri->segment(3);
		if(!$company_uuid)
			 redirect(site_url('company/index'), 'refresh');;
		$this->_show($company_uuid);
	}


	/**
	 *
	 *
	 */
	protected function _list()
	{
		$data['web_title'] = '公司-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$this->load->model('company_model');

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

		//公司类型
		$data['company_type'] = $this->company_model->company_types('0');

		//公司类型(二级)
		$this->load->model('type_model');
		$sort_p = $this->type_model->assort('ysw_company_type');

		$data['type_t'] = array();
		foreach($data['select'] as $key=>$value)
		{
			if($key =='type')
			{
				if(in_array($data['select']['type'],$sort_p))
				{
					$data['type_t'] = $this->company_model->company_types($value);
				}
			}
		}

		//公司列表(判断条件)
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
				//company_type
				if(in_array('type',$data['sort']))
				{
					if($key == 'type')
					{
						if(!in_array($value,$sort_p))
						{
							$where['company_type'] = $value;
						}
						else
						{
							foreach($data['type_t'] as $key_p=>$value_p)
							{
								$arr_1[] = $key_p;
							}
							$where['company_type'] = implode(',',$arr_1);
						}
					}
				}
				if(in_array('type_t',$data['sort']))
				{
					if($key == 'type_t')
					{
						$where['company_type'] = $value;
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
	    $config['total_rows'] = $this->company_model->total_company($where,$order,$keywords);
	    $config['per_page']   = 10;
	    $config['num_links']  = 3;
		if(in_array('page',$data['sort']))
		{
			$config['uri_segment'] = count($data['sort'])*2 + 2;
		}
		else
		{
			$config['uri_segment'] = (count($data['sort'])+1)*2 + 2;
		}
		//$config['uri_segment'] = (count($data['select']))*2 + 2;
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

		//合作列表
		$data['lists'] = $this->company_model->company_lists($where,$order,$keywords,$config['per_page'],$page);

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
		$this->load->view('company',$data);
		$this->load->view('include/footer_12',$data);
	}

	/**
	 * _order_by
	 * anchors为安全排序字段范围
	 * 处理排序
	 */
	protected function _order_by($orderby='',$anchors=array())
	{
		if(!$orderby) return FALSE;
		$orderby = str_replace('new','create_time',$orderby);//对应数据库字段
		return url_orderby($orderby,$anchors);
	}

	protected function _show($company_uuid)
	{		
		$this->load->model('company_model');
		$this->load->model('product_model');
		$this->load->model('companytype_model');
		$this->load->model('usercompany_model');
		$this->load->helper('text');
		$this->load->helper('array');
		$this->load->helper('myfunction');
		$data['company'] = $this->company_model->fetch_id($company_uuid,' * ',array('status <='=>'1'));
		if(!$data['company'])
		{
			redirect(site_url('prompt/error'), 'refresh');
		}
		$data['companytype'] = $this->companytype_model->get_names();
		$data['product'] = $this->product_model->product_list($column = ' product_uuid,product_icon,product_name ',array('company_uuid'=>$company_uuid,'status <'=>'4'));
		$data['usercompany'] = $this->usercompany_model->get_company_user($company_uuid,array('ysw_user_company.status <'=>'2'));

		//查找此公司发布者和公司相关成员
		$member = $this->company_model->member($company_uuid);
		$create = $data['company']->create_uuid;
		$data['member'] = '"'.implode('","',array_unique(explode(',',$create.''.$member))).'"';

		//读取成员是否纠错和纠错的处理状态
		$correction = $this->company_model->correction(UUID,$company_uuid);
		if($correction)
		{
			$data['status'] = $correction->status;
		}
		else
		{
			$data['status'] = '';
		}

		$data['web_title'] = $data['company']->company_name.' - 公司 - 游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$this->load->view('include/header_12',$data);
		$this->load->view('company_show',$data);
		$this->load->view('include/footer_12',$data);
	}

	public function correction($company_uuid,$status='')
	{
		$data['status'] = $status;
		$data['web_title'] = '公司-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$this->load->helper('form');
		$this->load->model('company_model');

		//游戏类型
		$list = $this->company_model->company_type();
		$this->load->helper('myfunction');
		$result = array();
		if($list){
			foreach($list as $k=>$v)
			{
				$result[$v['id']]  = $v ;
			}
		}
		$data['company_type'] = comment($result,'id','parent','childs');

		//公司信息
		$data['company'] = $this->company_model->fetch_id($company_uuid,' * ',array('status <='=>'1'));

		//读取所在区域
		$data['province'] = $data['company']->province;
		$data['city'] = $data['company']->city;

		$this->load->model('region_model');
		$data['provinces'] = $this->region_model->provinces();
		$data['citys'] = $this->region_model->children_of($data['province']);

		//查找此公司发布者和公司相关成员
		$member = $this->company_model->member($company_uuid);
		$create = $data['company']->create_uuid;
		$data['member'] = array_unique(explode(',',$create.''.$member));
		if(!in_array(UUID,$data['member']))
		{
			redirect(site_url('company/show/'.$company_uuid), 'refresh');
		}

		//读取成员是否纠错和纠错的处理状态
		$correction = $this->company_model->correction(UUID,$company_uuid);
		if($correction)
		{
			if($correction->status=='1')
			{
				redirect(site_url('company/show/'.$company_uuid), 'refresh');
			}
		}

		$this->load->view('include/header_12',$data);
		$this->load->view('company_edit',$data);
		$this->load->view('include/footer_12',$data);

	}

	//纠错信息
	public function edit($company_uuid,$status='')
	{
		$this->load->database();
		$company_name = $this->input->post('company_name', TRUE);
		$company_pic = '';
		$company_pic = $this->_upload_single('company_pic','company');
		if($this->input->post('company_type', TRUE) != '')
		{
			$company_type = implode(',', $this->input->post('company_type', TRUE));
		}
		else
		{
			$company_type = $this->input->post('company_type', TRUE);
		}
		$company_size = $this->input->post('company_size', TRUE);
		$province = $this->input->post('province', TRUE);
		$city = $this->input->post('city', TRUE);
		$company_desc = $this->input->post('company_desc', TRUE);
		$company_address = $this->input->post('company_address', TRUE);
		$company_web = $this->input->post('company_web', TRUE);
		$company_phone = $this->input->post('company_phone', TRUE);
		$company_email = $this->input->post('company_email', TRUE);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('company_name','研发公司/团队的名字','trim|required');
		$this->form_validation->set_rules('company_type','研发公司/团队类型','required');
		$this->form_validation->set_rules('company_size','研发公司/团队规模','required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->correction($company_uuid);
		}
		else
		{
			$this->load->model('company_model');
			$sql = "select uuid() uuid";
			$q = $this->db->query($sql)->row();
			$update_uuid = $q->uuid;
			$data = array(
				'company_name' => $company_name,
				'company_type' => $company_type,
				'company_size' => $company_size,
				'province' => $province,
				'city' => $city,
				'company_desc' => $company_desc,
				'company_address' => $company_address,
				'company_web' => $company_web,
				'company_phone' => $company_phone,
				'company_email' => $company_email,
				'company_pic' => $company_pic,
				'status' => 0,
				'create_time' => strtotime(date("Y-m-d H:i:s")),
				'create_ip' => $this->input->ip_address(),
				'create_uuid' => UUID
			);
			if($status == '0')
			{
				$this->company_model->update_correction($data,$company_uuid,UUID);
				//修改公司纠错状态
				$this->company_model->updating($company_uuid);
			}
			elseif($status == '1')
			{
				redirect(site_url('company/show/'.$company_uuid), 'refresh');
			}
			else
			{
				$data['update_uuid'] = $update_uuid;
				$data['company_uuid'] = $company_uuid;
				$this->company_model->insert_correction($data);

				//修改公司纠错状态
				$this->company_model->updating($company_uuid);
			}

			$data['web_title'] = '公司-游商网';
			$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
			$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
			$data['title'] = '提交纠错信息已成功！';
			$data['img'] = 'true.png';
			$data['message'] = '纠错信息正在审核中，请耐心等待...！';
			$data['where_1'] = '会员中心';
			$data['url_1'] = site_url('user/center');
			$data['target_1']  = '';
			$data['where_2'] = '公司列表';
			$data['url_2'] = site_url('company');
			$data['target_2']  = '';
			$this->load->view('include/header_12',$data);
			$this->load->view('include/message',$data);
			$this->load->view('include/footer_12',$data);
		}
	}

	protected function _upload_single($pic_name='upfiles',$dir='company')
	{	
		//上传图片
		if($_FILES && $_FILES[$pic_name] && $_FILES[$pic_name]['tmp_name'])
		{
			$config['upload_path'] = RESPATH.'/uploadfile/image/'.$dir.'/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '1024';
			$config['max_width']  = '800';
			$config['max_filename']  = '50';//生成的文件名最大长度
			$config['max_height']  = '800';
			$config['file_name']	= time();//上传后的文件名称

			$this->load->library('upload', $config);
			if(!$this->upload->do_upload($pic_name)) {
				echo "<script>alert('上传错误,请返回重新上传');history().go(-1)</script>";return FALSE;exit;
			}else{

				$data['upload_data']=$this->upload->data();  //文件的一些信息
				$file_name = $data['upload_data']['file_name'];  //取得文件名
				if(isset($data['upload_data']['full_path']) && $data['upload_data']['full_path'])
				{
					//处理图片开始
						$cfg['image_library'] = 'gd2';
						$cfg['source_image'] = $data['upload_data']['full_path'];
						$cfg['create_thumb'] = TRUE;
						$cfg['maintain_ratio'] = TRUE;
						$cfg['width'] = 180;
						$cfg['height'] = 180;
			
						$this->load->library('image_lib', $cfg);
						$this->image_lib->resize();
						//$this->image_lib->crop();
					//处理图片结束
				}
				return $file_name;
			}			
		}
		return FALSE;
		//上传图片结束
	}

	//添加公司
	public function add_company()
	{
		if (!$this->is_login())
		{
			@session_start();
			$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
			redirect(site_url('user/login'), 'refresh');
		}
		$data['web_title'] = '公司入驻-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$company_name = $this->input->post('company_name', TRUE);
		$company_pic = '';
		//处理上传图片 返回图片名称
		$company_pic = $this->_upload_single('company_pic','company');

		if($this->input->post('company_type', TRUE) != '')
		{
			$company_type = implode(',', $this->input->post('company_type', TRUE));
		}
		else
		{
			$company_type = $this->input->post('company_type', TRUE);
		}

		$company_size = $this->input->post('company_size', TRUE);
		$province = $this->input->post('province', TRUE);
		$city = $this->input->post('city', TRUE);
		$company_desc = $this->input->post('company_desc', TRUE);

		$company_address = $this->input->post('company_address', TRUE);
		$company_web = $this->input->post('company_web', TRUE);
		$company_phone = $this->input->post('company_phone', TRUE);
		$company_email = $this->input->post('company_email', TRUE);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('company_name','公司名称','trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			//游戏类型
			$this->load->model('company_model');
			$list = $this->company_model->company_type();
			$this->load->helper('myfunction');
			$result = array();
			if($list){
				foreach($list as $k=>$v)
				{
					$result[$v['id']]  = $v ;
				}
			}
			$data['company_type'] = comment($result,'id','parent','childs');

			//所属区域
			$this->load->model('region_model');
			$data['province'] = '25';
			$data['city'] = '2703';
			$data['provinces'] = $this->region_model->provinces();
			$data['citys'] = $this->region_model->children_of($data['province']);

			$this->load->view('include/header',$data);
			$this->load->view('add_company',$data);
			$this->load->view('include/footer',$data);
		}
		else
		{
			//当前表中编号最大值
			$this->load->model('sn_model');
			$sn = $this->sn_model->sn('company');

			//company_uuid
			$sql = "select uuid() uuid";
			$q = $this->db->query($sql)->row();
			$company_uuid = $q->uuid;

			$data = array(
				'company_uuid' => $company_uuid,
				'company_pic' => $company_pic,
				'company_name' => $company_name,
				'company_type' => $company_type,
				'company_size' => $company_size,
				'province' => $province,
				'city' => $city,
				'company_desc' => $company_desc,
				'company_address' => $company_address,
				'company_web' => $company_web,
				'company_phone' => $company_phone,
				'company_email' => $company_email,
				'status' => 1,
				'checked' => 0,
				'create_time' => strtotime(date("Y-m-d H:i:s")),
				'create_ip' => $this->input->ip_address(),
				'create_uuid' => UUID,
				'sn' => $sn
			);
			$this->load->model('company_model');
			$this->company_model->insert_company($data);

			//添加用户公司关联信息
			$this->company_model->add_user_company(UUID,$company_uuid);
			redirect(site_url('prompt/company/'.$company_uuid), 'refresh'); //绑定新公司后跳转到我的职位信息页面
		}
	}

}
