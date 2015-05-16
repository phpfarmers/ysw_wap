<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check_company extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->database();
		$this->load->model('product_model');
		if (!$this->is_login())
		{
			@session_start();
			$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
			redirect(site_url('prompt'), 'refresh');
		}
	}

	public function index($product_uuid = '',$company_uuid = '')
	{
		$data['web_title'] = '发布产品-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		// 游戏平台
		$data['platform_list'] = $this->product_model->assort('id,platform_name','ysw_product_platform');

		if($product_uuid != '')
		{
			$data['product_uuid'] = $product_uuid;
			$data['company_uuid'] = $company_uuid;

			//获取表单数据
			$producer_uuid = $this->input->post('producer_uuid', TRUE);
			$producer_name = $this->input->post('producer_name', TRUE);
			//$producer_pic = $this->input->post('producer_pic', TRUE);
			$producer_product = $this->input->post('producer_product', TRUE);
			$producer_info = $this->input->post('producer_info', TRUE);
			$producer_pic = '';
			//处理上传图片 返回图片名称
			$producer_pic = $this->_upload_single('producer_pic','company');

			$agent_uuid = $this->input->post('agent_uuid', TRUE);
			$agent_name = $this->input->post('agent_name', TRUE);
			if($this->input->post('agent_area', TRUE))
			{
				$agent_area = implode(',', $this->input->post('agent_area', TRUE));
			}
			else
			{
				$agent_area = $this->input->post('agent_area', TRUE);
			}

			if($this->input->post('agent_platform', TRUE))
			{
				$agent_platform = implode(',', $this->input->post('agent_platform', TRUE));
			}
			else
			{
				$agent_platform = $this->input->post('agent_platform', TRUE);
			}
			
			//判断关联公司uuid是否为空
			if($this->input->post('company_uuid', TRUE)!='')
			{
				$company_uuid = $this->input->post('company_uuid', TRUE);
				//company_uuid 不为空时,产品直接关联公司
				$this->product_model->linked_company($product_uuid,$company_uuid);

				//游戏制作人信息
				if($producer_name != '' || $producer_pic != '' || $producer_product !='' || $producer_info !='' )
				{
					if($producer_uuid != '')
					{
						$data = array(
							'producer_name' => $producer_name ,
							'producer_product' => $producer_product ,
							'producer_info' => $producer_info 
						);
						if($producer_pic)							
							$data['producer_pic'] = $producer_pic;
						$this->product_model->update_producer($data,$producer_uuid);
					}
					else
					{
						$sql = "select uuid() uuid";
						$q = $this->db->query($sql)->row();
						$producer_uuid = $q->uuid;
						$data = array(
							'producer_uuid' => $producer_uuid ,
							'producer_name' => $producer_name ,
							'producer_product' => $producer_product ,
							'producer_info' => $producer_info,
							'status' => 0,
							'uuid' => UUID,
							'product_uuid' => $product_uuid,
							'create_time' => strtotime(date("Y-m-d H:i:s")),
							'create_ip' => $this->input->ip_address()
						);
						if($producer_pic)
							$data['producer_pic'] = $producer_pic;
						$this->product_model->insert_producer($data);
					}
				}

				//游戏合作代理商
				if($agent_name != '' || $agent_area != '' || $agent_platform !='')
				{
					if($agent_uuid != '')
					{
						$data = array(
							'agent_name' => $agent_name ,
							'agent_area' => $agent_area ,
							'agent_platform' => $agent_platform
						);
						$this->product_model->update_agent($data,$agent_uuid);
					}
					else
					{
						$sql = "select uuid() uuid";
						$q = $this->db->query($sql)->row();
						$agent_uuid = $q->uuid;
						$data = array(
							'agent_uuid' => $agent_uuid ,
							'agent_name' => $agent_name ,
							'agent_area' => $agent_area ,
							'agent_platform' => $agent_platform ,
							'status' => 0,
							'uuid' => UUID,
							'product_uuid' => $product_uuid,
							'create_time' => strtotime(date("Y-m-d H:i:s")),
							'create_ip' => $this->input->ip_address()
						);
						$this->product_model->insert_agent($data);
					}
				}
				redirect(site_url('user/product_success/index'.'/'.$product_uuid), 'refresh'); //产品关联研发公司已成功，跳转到成功页面
			}
			else
			{
				//company_uuid 为空时,验证填写的表单，然后新添加公司

				$company_uuid = $this->input->post('company_uuid', TRUE);
				$company_name = $this->input->post('company_name', TRUE);
				//$company_pic = $this->input->post('company_pic', TRUE);
				$company_pic = '';
				//处理上传图片 返回图片名称
				$company_pic = $this->_upload_single('company_pic','company');

				if($this->input->post('company_type', TRUE))
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
					if($data['company_uuid'] != '')
					{
						$data['linked_company'] = $this->product_model->company_info($product_uuid);
					}
					else
					{
						// 查询产品所对应的平台
						$product_platform = $this->product_model->product_platform($product_uuid);

						$data['linked_company'] = array(
							'company_uuid' => '',
							'company_name' => '',
							'company_pic' => '',
							'company_type' => '',
							'company_size' => '',
							'province' => '25',
							'city' => '2705',
							'company_desc' => '',
							'company_address' => '',
							'company_web' => '',
							'company_phone' => '',
							'company_email' => '',
							'producer_uuid' => '',
							'producer_name' => '',
							'producer_pic' => '',
							'producer_product' => '',
							'producer_info' => '',
							'agent_uuid' => '',
							'agent_name' => '',
							'agent_area' => '',
							'agent_platform' => '',
							'product_platform' => $product_platform
						);
					}

					//读取所在区域
					$data['province'] = $data['linked_company']['province'];
					$data['city'] = $data['linked_company']['city'];

					$this->load->model('region_model');
					$data['provinces'] = $this->region_model->provinces();
					$data['citys'] = $this->region_model->children_of($data['province']);

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

					$this->load->view('include/header',$data);
					$this->load->view('user/check_company',$data);
					$this->load->view('include/footer',$data);
				}
				else
				{
					$this->load->model("company_model");
					if($this->company_model->company_name($company_name) > 0)// 判断公司名称是否存在
					{
						$company_uuid = $this->company_model->select_company_uuid($company_name);
						$this->product_model->linked_company($product_uuid,$company_uuid);
						redirect(site_url('user/product_success/index'.'/'.$product_uuid), 'refresh'); //产品关联研发公司已成功，跳转到成功页面
					}
					else
					{
						//当前表中编号最大值
						$this->load->model('sn_model');
						$sn = $this->sn_model->sn('company');

						//添加公司信息
						$sql = "select uuid() uuid";
						$q = $this->db->query($sql)->row();
						$company_uuid = $q->uuid;
						$data = array(
							'company_uuid' => $company_uuid,
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
							'create_time' => strtotime(date("Y-m-d H:i:s")),
							'create_ip' => $this->input->ip_address(),
							'create_uuid' => UUID,
							'sn' => $sn
						);
						if($company_pic)
							$data['company_pic'] = $company_pic;
							
						$this->load->model('company_model');
						$this->company_model->insert_company($data);

						//添加用户公司关联信息
						$this->company_model->add_user_company(UUID,$company_uuid);

						//产品关联公司
						$this->product_model->linked_company($product_uuid,$company_uuid);

						//游戏制作人信息
						if($producer_name != '' || $producer_pic != '' || $producer_product !='' || $producer_info !='' )
						{
							if($producer_uuid != '')
							{
								$data = array(
									'producer_name' => $producer_name ,
									'producer_product' => $producer_product ,
									'producer_info' => $producer_info 
								);
								if($producer_pic)
									$data['producer_pic'] = $producer_pic;
								$this->product_model->update_producer($data,$producer_uuid);
							}
							else
							{
								$sql = "select uuid() uuid";
								$q = $this->db->query($sql)->row();
								$producer_uuid = $q->uuid;
								$data = array(
									'producer_uuid' => $producer_uuid ,
									'producer_name' => $producer_name ,
									'producer_product' => $producer_product ,
									'producer_info' => $producer_info,
									'status' => 0,
									'uuid' => UUID,
									'product_uuid' => $product_uuid,
									'create_time' => strtotime(date("Y-m-d H:i:s")),
									'create_ip' => $this->input->ip_address()
								);
								if($producer_pic)
									$data['producer_pic'] = $producer_pic;
								$this->product_model->insert_producer($data);
							}
						}

						//游戏合作代理商
						if($agent_name != '' || $agent_area != '' || $agent_platform !='')
						{
							if($agent_uuid != '')
							{
								$data = array(
									'agent_name' => $agent_name ,
									'agent_area' => $agent_area ,
									'agent_platform' => $agent_platform
								);
								$this->product_model->update_agent($data,$agent_uuid);
							}
							else
							{
								$sql = "select uuid() uuid";
								$q = $this->db->query($sql)->row();
								$agent_uuid = $q->uuid;
								$data = array(
									'agent_uuid' => $agent_uuid ,
									'agent_name' => $agent_name ,
									'agent_area' => $agent_area ,
									'agent_platform' => $agent_platform ,
									'status' => 0,
									'uuid' => UUID,
									'product_uuid' => $product_uuid,
									'create_time' => strtotime(date("Y-m-d H:i:s")),
									'create_ip' => $this->input->ip_address()
								);
								$this->product_model->insert_agent($data);
							}
						}
						redirect(site_url('user/product_success/index'.'/'.$product_uuid), 'refresh'); //产品关联研发公司已成功，跳转到成功页面
					}
				}
			}
		}
		else
		{
			$data['title'] = '非法操作';
			$data['img'] = 'false.png';
			$data['message'] = '非法操作！';
			$data['where_1'] = '发布产品';
			$data['url_1'] = site_url('user/add_product');
			$data['target_1']  = '';
			$data['where_2'] = '网站首页';
			$data['url_2'] = site_url('');
			$data['target_2']  = '';
			$this->load->view('include/header',$data);
			$this->load->view('include/message',$data);
			$this->load->view('include/footer',$data);
		}
	}

	//公司名称列表
	public function company_name_list($str)
	{
		$str = urldecode($str);
		if(strlen($str) >0) {
			$this->load->model("company_model");
			if($this->company_model->company_name_list($str))
			{
				echo '<ul>';
				foreach ($this->company_model->company_name_list($str) as $row){
					echo '<li onClick="fill(\''.$row['company_name'].'\',\''.$row['company_uuid'].'\');">'.$row['company_name'].'</li>';
				}
				echo '</ul>';
			}
		}
	}

	/**
	 *
	 * jeff 2014/12/17 上传单个图片
	 *
	 */
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