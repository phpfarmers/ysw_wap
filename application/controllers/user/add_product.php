<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_product extends MY_Controller {

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

	public function add($product_name='')
	{
		$data['web_title'] = '发布产品-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$data['product_name'] = urldecode($product_name);

		// 游戏平台
		$data['platform_list'] = $this->product_model->assort('id,platform_name','ysw_product_platform');

		// 游戏类型
		$data['type_list'] = $this->product_model->assort('id,type_name,input_type,input_name','ysw_product_type');

		// 游戏类型分类
		foreach($this->product_model->type_sort() as $key=>$value)
		{
		  $data['type_sort'][$key]=$value['input_name'];
		}

		$data['product_info'] = array(
			'product_uuid' => '',
			'product_name' => $data['product_name'],
			'product_icon' => '',
			'product_platform' => '',
			'product_type' => '',
			'single_type' => '',
			'product_theme' => '',
			'product_style' => '',
			'radio1' => '',
			'radio2' => '',
			'product_info' => '',
			'product_feature' => '',
			'product_video' => '',
			'product_pic' => '',
			'product_down' => '',
			'company_uuid' => '',
			'create_time' => time()
		);

		$this->load->view('include/header',$data);
		$this->load->view('user/add_product',$data);
		$this->load->view('include/footer',$data);
	}

	public function index($product_uuid='')
	{
		header("Content-type:text/html;charset=utf-8");
		$data['web_title'] = '发布产品-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$product_icon = '';
		//上传图片
		if($_FILES && $_FILES['product_icon'] && $_FILES['product_icon']['tmp_name'])
		{
			$config['upload_path'] = RESPATH.'/uploadfile/image/product/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '200';
			$config['max_width']  = '800';
			$config['max_filename']  = '50';//生成的文件名最大长度
			$config['max_height']  = '800';
			$config['file_name']	= time();//上传后的文件名称

			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('product_icon')) {
				redirect(site_url('prompt/img_error'), 'refresh'); //跳转文件上传页面
			}else{
				$data['upload_data']=$this->upload->data();  //文件的一些信息
				$product_icon = $data['upload_data']['file_name'];  //取得文件名
				if(isset($data['upload_data']['full_path']) && $data['upload_data']['full_path'])
				{
					//处理图片开始
						$cfg['image_library'] = 'gd2';
						$cfg['source_image'] = $data['upload_data']['full_path'];
						//$cfg['create_thumb'] = TRUE;
						$cfg['maintain_ratio'] = TRUE;
						$cfg['width'] = 180;
						$cfg['quality'] = 100;
						$cfg['height'] = 180;
			
						$this->load->library('image_lib', $cfg);
						$this->image_lib->resize();
						////$this->image_lib->crop();
					//处理图片结束
				}
			}			
		}
		//上传图片结束
		//product_album
		$this->load->model('productalbum_model');
		if($product_uuid)
			$data['album']=$this->productalbum_model->get_product_album($product_uuid,"uuid ='".UUID."' and status !='2'");
		/* 读取表单数据 */
		//$product_icon = $this->input->post('product_icon', TRUE);
		$product_name = $this->input->post('product_name', TRUE);
		if($this->input->post('product_platform', TRUE))
		{
			$product_platform = implode(',', $this->input->post('product_platform', TRUE));
		}
		else
		{
			$product_platform = $this->input->post('product_platform', TRUE);
		}
		if($this->input->post('product_type', TRUE))
		{
			$product_type = implode(',', $this->input->post('product_type', TRUE));
		}
		else
		{
			$product_type = $this->input->post('product_type', TRUE);
		}
		$radio1 = $this->input->post('radio1', TRUE);
		$radio2 = $this->input->post('radio2', TRUE);
		//update 关联表
		$product_2_platform = $this->input->post('product_platform', TRUE);
		$product_2_type = $this->input->post('product_type', TRUE);

		$single_type = $this->input->post('single_type', TRUE);
		$product_theme = $this->input->post('product_theme', TRUE);
		$product_style = $this->input->post('product_style', TRUE);
		$product_feature = $this->input->post('product_feature', TRUE);
		$product_video = $this->input->post('product_video', TRUE);
		$product_down = $this->input->post('product_down', TRUE);
		$product_info = $this->input->post('product_info', TRUE);
		$company_uuid = $this->input->post('company_uuid', TRUE);

		//echo $product_theme.'/'.$product_style;exit;

		/* 验证表单 */
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_name','游戏名称','trim|required');
		$this->form_validation->set_rules('product_platform','游戏平台','required');
		$this->form_validation->set_rules('product_type','游戏类型','required');
		$this->form_validation->set_rules('radio1','游戏类型','required');
		$this->form_validation->set_rules('radio2','游戏类型','required');
		$this->form_validation->set_rules('single_type','是否单机','required');

		if ($this->form_validation->run() == FALSE)
		{
			if($product_uuid != '')
			{
				$data['product_info'] = $this->product_model->product_info($product_uuid);
			}
			else
			{
				$data['product_info'] = array(
					'product_uuid' => '',
					'product_name' => '',
					'product_icon' => '',
					'product_platform' => '',
					'product_type' => '',
					'single_type' => '',
					'product_theme' => '',
					'product_style' => '',
					'radio1' => '',
					'radio2' => '',
					'product_info' => '',
					'product_feature' => '',
					'product_video' => '',
					'product_pic' => '',
					'product_down' => '',
					'company_uuid' => '',
					'create_time' => time()
				);
			}

			// 游戏平台
			$this->load->model('cooperation_model');
			$platform = $this->cooperation_model->platform_step();
			$this->load->helper('myfunction');
			$result = array();
			if($platform){
				foreach($platform as $k=>$v){
					$result[$v['id']]  = $v ;
				}
			}
			$plat = comment($result,'id','parent','childs');
			foreach($plat as $rows)
			{
				if(isset($rows['childs']))
				{
					foreach($rows['childs'] as $row)
					{
						$data['platform_list'][$row['id']] = $row['platform_name'];
					}
				}
				else
				{
					$data['platform_list'][$rows['id']] = $rows['platform_name'];
				}
			}

			// 游戏类型
			$data['type_list'] = $this->product_model->assort('id,type_name,input_type,input_name','ysw_product_type');

			// 游戏类型分类
			//$data['type_sort'] = $this->product_model->type_sort();

			foreach($this->product_model->type_sort() as $key=>$value)
			{
			  $data['type_sort'][$key]=$value['input_name'];
			}
			//print_r($data['type_sort']);exit;

			$this->load->view('include/header',$data);
			$this->load->view('user/add_product',$data);
			$this->load->view('include/footer',$data);
		}
		else
		{
			if($product_uuid != '')
			{
				$data = array(
					'product_name' => $product_name,
					'product_platform' => $product_platform,
					'product_type' => $product_type,
					'single_type' => $single_type,
					'product_theme' => $product_theme,
					'product_style' => $product_style,
					'radio1' => $radio1,
					'radio2' => $radio2,
					'product_feature' => $product_feature,
					'product_video' => $product_video,
					'product_down' => $product_down,
					'product_info' => $product_info,
					'company_uuid' => $company_uuid,
					'status' => 1,
					'checked' => 0,
					'last_time' => strtotime(date("Y-m-d H:i:s")),
					'last_ip' => $this->input->ip_address(),
					'uuid' => UUID
				);
				if($product_icon)
					$data['product_icon'] = $product_icon;
				$this->product_model->update_product($data,$product_uuid);	
				//update  product_2_type product_2_platform
				$this->_product_type_platform($product_uuid,$product_2_type,$product_2_platform);//更新关联表
				//update product_album
//				$where_album = array('uuid'=>UUID,'product_uuid'=>'','create_time >'=>strtotime(date("Y-m-d")),'create_time <'=>strtotime(date("Y-m-d"))+86400);
//				$data_album = array('product_uuid'=>$product_uuid);
//				$this->productalbum_model->update($data_album,$where_album);

			}
			else
			{
				//当前表中编号最大值
				$this->load->model('sn_model');
				$sn = $this->sn_model->sn('product');

				//product_uuid
				$sql = "select uuid() uuid";
				$q = $this->db->query($sql)->row();
				$product_uuid = $q->uuid;

				$data = array(
					'product_uuid' => $product_uuid,
					'product_name' => $product_name,
					'product_platform' => $product_platform,
					'product_type' => $product_type,
					'single_type' => $single_type,
					'radio1' => $radio1,
					'radio2' => $radio2,
					'product_theme' => $product_theme,
					'product_style' => $product_style,
					'product_feature' => $product_feature,
					'product_video' => $product_video,
					'product_down' => $product_down,
					'product_info' => $product_info,
					'company_uuid' => $company_uuid,
					'status' => 1,
					'checked' => 0,
					'create_time' => strtotime(date("Y-m-d H:i:s")),
					'create_ip' => $this->input->ip_address(),
					'uuid' => UUID,
					'sn' => $sn
				);
				if($product_icon)
					$data['product_icon'] = $product_icon;
				$this->product_model->insert_product($data);
				//update  product_2_type product_2_platform
				$this->_product_type_platform($product_uuid,$product_2_type,$product_2_platform);//更新关联表
				//update product_album
				$where_album = array('uuid'=>UUID,'product_uuid'=>'','create_time >'=>strtotime(date("Y-m-d")),'create_time <'=>strtotime(date("Y-m-d"))+86400);
				$data_album = array('product_uuid'=>$product_uuid);
				$this->productalbum_model->update($data_album,$where_album);
			}
			redirect(site_url('user/check_company/index/'.$product_uuid.'/'.$company_uuid), 'refresh'); //添加产品已成功，跳转到研发公司页面
		}
	}


	/**
	 * jeff 2014/12/19
	 * 更新关联表
	 */
	protected function _product_type_platform($product_uuid,$type,$platform)
	{
		$this->load->model('p2type_model');
		$this->load->model('p2platform_model');
		$this->p2type_model->update($product_uuid,$type);
		$this->p2platform_model->update($product_uuid,$platform);
	}
}