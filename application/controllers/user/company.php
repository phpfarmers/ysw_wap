<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('form');
		if (!$this->is_login())
		{
			@session_start();
			$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
			redirect(site_url('prompt'), 'refresh');
		}
	}

	public function index()
	{
		$data['web_title'] = '我的公司-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$this->load->model("company_model");
		if($this->company_model->check_company(UUID) >= 1) // 判断当前有没有绑定公司
		{
			$company_uuid = $this->company_model->company_uuid(UUID); // 读取绑定的公司的uuid
			redirect(site_url("user/company/my_company/$company_uuid"), 'refresh');  //跳转到我的公司页面
		}
		else
		{
			redirect(site_url("user/company/select_company"), 'refresh'); //跳转到选择公司页面
		}
	}

	// 选择公司
	public function select_company()
	{
		$data['web_title'] = '我的公司-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$company_name = $this->input->post('company_name', TRUE);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('company_name','公司名称','trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('include/header',$data);
			$this->load->view('include/user_left',$data);
			$this->load->view('user/select_company',$data);
			$this->load->view('include/footer',$data);
		}
		else
		{
			$this->load->model("company_model");

			if($this->company_model->company_name($company_name) > 0)// 判断公司名称是否存在
			{
				$company_uuid = $this->company_model->select_company_uuid($company_name);
				redirect(site_url("user/company/my_post/$company_uuid"), 'refresh'); //绑定新公司后跳转到我的职位信息页面
			}
			else
			{
				redirect(site_url("user/company/add_company/".urlencode(base64_encode($company_name))), 'refresh'); //跳转到添加公司信息页面
			}
		}
	}

	// 新添加公司
	public function add_company($company_name = '')
	{
		$data['web_title'] = '我的公司-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$data['company_name'] = base64_decode(rawurldecode($company_name));
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

			$this->load->model('region_model');
			$data['province'] = '25';
			$data['city'] = '2703';
			$data['provinces'] = $this->region_model->provinces();
			$data['citys'] = $this->region_model->children_of($data['province']);
			$this->load->view('include/header',$data);
			$this->load->view('include/user_left',$data);
			$this->load->view('user/add_company',$data);
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
			redirect(site_url('user/company/my_post/'.$company_uuid), 'refresh'); //绑定新公司后跳转到我的职位信息页面
		}

	}

	// 所在公司职位信息
	public function my_post($company_uuid)
	{
		$data['web_title'] = '我的公司-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$this->load->model("company_model");
		$data['company'] = $this->company_model->company_post(UUID,$company_uuid); // 读取公司信息

		$company_uuid = $this->input->post('company_uuid', TRUE);
		$employee_position = $this->input->post('employee_position', TRUE);
		$employee_dept = $this->input->post('employee_dept', TRUE);
		$year = $this->input->post('year', TRUE);
		$month = $this->input->post('month', TRUE);
		$day = $this->input->post('day', TRUE);
		$join_time = $year."-".$month."-".$day;
		//$verification_info = $this->input->post('verification_info', TRUE);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('employee_position','职位','trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('include/header',$data);
			$this->load->view('include/user_left',$data);
			$this->load->view('user/my_post',$data);
			$this->load->view('include/footer',$data);
		}
		else
		{
			if($_FILES['userfile']['size']>0)
			{
				$config['upload_path'] = RESPATH.'/uploadfile/image/licence/';
				$config['allowed_types'] = 'jpg|png|doc|pdf';
				$config['max_size'] = '1024'; //1M
				$config['file_name'] = date('YmdHis').rand(0,1000); //上传后文件重命名
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('userfile'))
				{
					$error = array('error' => $this->upload->display_errors());
					echo $error['error'];exit;
					$verification_info = '';
					exit;
				} 
				else
				{
					$data = array('upload_data' => $this->upload->data());
					$verification_info = $data['upload_data']['file_name'];
				}
			}
			else
			{
				$verification_info = '';
			}

			if($this->company_model->check_company(UUID) >= 1) // 判断当前有没有绑定公司
			{
				$row = $this->company_model->user_company(UUID);				
				$this->company_model->update_user_company_status(UUID,$row['company_uuid'],$row['status']); // 修改当前绑定公司状态
			}

			if($this->company_model->linked_company(UUID,$company_uuid) >= 1) // 判断需要绑定的公司以前是否绑定过
			{
				$this->company_model->update_user_post(UUID,$company_uuid,$employee_position,$employee_dept,$join_time,$verification_info); //更新所在公司的职位信息
			}
			else
			{
				$this->company_model->insert_user_post(UUID,$company_uuid,$employee_position,$employee_dept,$join_time,$verification_info); //插入新绑定公司的职位信息
			}
			redirect(site_url("user/company/my_company/$company_uuid"), 'refresh'); //跳转到我的公司页面
		}
	}

	// 当前绑定的公司
	public function my_company($company_uuid)
	{
		$data['web_title'] = '我的公司-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$this->load->model("company_model");
		$data['company'] = $this->company_model->company_post(UUID,$company_uuid); //读取当前绑定公司信息及职位信息
		//print_r($data['company']);exit;
		if($this->company_model->old_company_list(UUID))
		{
			$old_c = $this->company_model->old_company_list(UUID);
			$region_id = $old_c['region'];
			$this->load->model('region_model');
			$data['region'] = $this->region_model->fetch_name('',$region_id);
			//var_dump(!empty($old_c['old_company']));exit;
			if(!empty($old_c['old_company']))
			{
				$data['old_company'] = $old_c['old_company']; //读取我以前的公司列表信息
			}
			else
			{
				$data['old_company'] ='';
			}
		}
		else
		{
			$data['old_company'] ='';
		}
		$data['employee'] = $this->company_model->employee_list(UUID,$company_uuid); //读取当前绑定公司其他成员信息

		//公司相关产品
		$data['product'] = $this->company_model->links_product($company_uuid);

		//公司相关产品类型
		$this->load->model('product_model');
		$data['type'] = $this->product_model->product_type();

		$this->load->view('include/header',$data);
		$this->load->view('include/user_left',$data);
		$this->load->view('user/my_company',$data);
		$this->load->view('include/footer',$data);
	}

	//删除我以前的公司
	public function del($uuid,$company_uuid)
	{
		$this->load->model("company_model");

		//删除我以前的公司
		$this->company_model->del_user_company($uuid,$company_uuid);

		//判断公司是否是我添加的，是我添加的修改公司状态
		$company = $this->company_model->company_status($uuid,$company_uuid);
		if($company)
		{
			$this->company_model->del_company($uuid,$company_uuid,$company['status']);
		}
	}

	//图片上传
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

}
