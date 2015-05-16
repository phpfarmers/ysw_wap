<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Center extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		if (!$this->is_login())
		{
			@session_start();
			$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
			redirect(site_url('prompt'), 'refresh');
		}
		$this->load->model("center_model");
	}

	public function index()
	{
		$this->load->helper('date');
		$data['web_title'] = '个人中心-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		//评论数量
		$data['comment_num'] = $this->center_model->comment_num(UUID);

		//发布合数
		$data['task_num'] = $this->center_model->task_num(UUID);

		//提交产品数量
		$data['product_num'] = $this->center_model->product_num(UUID);

		//关注合作数
		$data['task_collection'] = $this->center_model->task_collection(UUID);

		//关注产品数
		$data['product_collection'] = $this->center_model->product_collection(UUID);

		//资料上传数
		$data['data_upload'] = $this->center_model->data_upload(UUID);

		//资料收藏数
		$data['data_favorites'] = $this->center_model->data_favorites(UUID);

		//判断当前是否绑定公司
		if($this->center_model->linked_company(UUID)>0)
		{
			//个人资料(当前关联公司)
			$data['user_info'] = $this->center_model->user_info(UUID,'true');
		}
		else
		{
			//个人资料(当前未关联公司)
			$data['user_info'] = $this->center_model->user_info(UUID,'flase');
		}

		//查询会员登录次数(判断会员在此次登录之前是否登录过)
		$data['login_num'] = $this->center_model->login_num(UUID);
		if($data['login_num']>1)
		{
			//上次登录时间和登录IP
			$data['last_login'] = $this->center_model->last_login(UUID);
		}
		$this->load->view('include/header',$data);
		$this->load->view('include/user_left',$data);
		$this->load->view('user/center',$data);
		$this->load->view('include/footer',$data);
	}

}
