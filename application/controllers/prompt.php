<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prompt extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['web_title'] = '信息提示页-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$data['title'] = '您正在查看的页面需要登录！';
		$data['img'] = 'warning.png';
		$data['message'] = '您正在查看的页面需要登录，<em id="timer">5</em> 秒后跳转到登陆页！';
		$data['where_1'] = '立即登录';
		$data['url_1'] = site_url('user/login');
		$data['target_1']  = '';
		$data['where_2'] = '网站首页';
		$data['url_2'] = site_url();
		$data['target_2']  = '';
		$this->load->view('include/header',$data);
		$this->load->view('include/message',$data);
		$this->load->view('include/footer',$data);
	}

	public function error()
	{
		$data['web_title'] = '访问出错-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$data['title'] = '信息已删除或被管理员屏蔽！';
		$data['img'] = 'warning.png';
		$data['message'] = '此信息已删除或被管理员屏蔽，<em id="timer">5</em> 秒后跳转到网站首页！';
		$data['where_1'] = '网站首页';
		$data['url_1'] = site_url();
		$data['target_1']  = '';
		$data['where_2'] = '会员登录';
		$data['url_2'] = site_url('user/login');
		$data['target_2']  = '';
		$this->load->view('include/header',$data);
		$this->load->view('include/message',$data);
		$this->load->view('include/footer',$data);
	}

	public function data()
	{
		$data['web_title'] = '信息提示-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$data['title'] = '文件上传失败！';
		$data['img'] = 'warning.png';
		$data['message'] = '文件上传失败，<em id="timer">5</em> 秒后跳转到资料上传！';
		$data['where_1'] = '资料上传';
		$data['url_1'] = site_url('data/add_data');
		$data['target_1']  = '';
		$data['where_2'] = '网站首页';
		$data['url_2'] = site_url();
		$data['target_2']  = '';
		$this->load->view('include/header',$data);
		$this->load->view('include/message',$data);
		$this->load->view('include/footer',$data);
	}

	public function img_error()
	{
		$data['web_title'] = '信息提示-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$data['title'] = '文件上传失败！';
		$data['img'] = 'warning.png';
		$data['message'] = '选择的图片超过规定大小或尺寸，<em id="timer">5</em> 秒后跳转到产品上传！';
		$data['where_1'] = '上传产品';
		$data['url_1'] = site_url('user/add_product');
		$data['target_1']  = '';
		$data['where_2'] = '网站首页';
		$data['url_2'] = site_url();
		$data['target_2']  = '';
		$this->load->view('include/header',$data);
		$this->load->view('include/message',$data);
		$this->load->view('include/footer',$data);
	}

	public function add_error()
	{
		$data['web_title'] = '信息提示-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$damain = 'http://'.$_SERVER['HTTP_HOST'];
		$url = base_url().''.index_page();
		$filter = str_replace($damain,'',$url);
		$redirect = str_replace($filter,'',$_SESSION['redirect']);

		$data['title'] = '信息填写有误！';
		$data['img'] = 'warning.png';
		$data['message'] = '信息填写有误，<em id="timer">5</em> 秒后自动返回！';
		$data['where_1'] = '直接返回';
		$data['url_1'] = $redirect;
		$data['target_1']  = '';
		$data['where_2'] = '网站首页';
		$data['url_2'] = site_url();
		$data['target_2']  = '';
		$this->load->view('include/header',$data);
		$this->load->view('include/message',$data);
		$this->load->view('include/footer',$data);
	}

	public function develop()
	{
		$data['web_title'] = '功能开发中-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$data['title'] = '此功能正在开发中……';
		$data['img'] = 'warning.png';
		$data['message'] = '此功能正在开发中，<em id="timer">5</em> 秒后跳转到网站首页！';
		$data['where_1'] = '网站首页';
		$data['url_1'] = site_url();
		$data['target_1']  = '';
		$data['where_2'] = '合作列表';
		$data['url_2'] = site_url('cooperation');
		$data['target_2']  = '';
		$this->load->view('include/header',$data);
		$this->load->view('include/message',$data);
		$this->load->view('include/footer',$data);
	}

	public function company($company_uuid = '')
	{
		$data['web_title'] = '公司入驻成功-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$data['title'] = '公司入驻成功，请等待审核！';
		$data['img'] = 'warning.png';
		$data['message'] = '<span style="padding-left:30px;">若是您的在职公司，请选择设为<a style="margin:0px;padding:0px;background:none;font:none;color:#ff8a00;" href="'.site_url('/user/company/my_post/'.$company_uuid).'">我的公司</a></span>';
		$data['where_1'] = '网站首页';
		$data['url_1'] = site_url();
		$data['target_1']  = '';
		$data['where_2'] = '公司列表';
		$data['url_2'] = site_url('company');
		$data['target_2']  = '';
		$this->load->view('include/header',$data);
		$this->load->view('include/message',$data);
		$this->load->view('include/footer',$data);
	}

}