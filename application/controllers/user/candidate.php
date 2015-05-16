<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidate extends MY_Controller {

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
	}

	public function index()
	{
		$data['web_title'] = '我投递的简历-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$data['title'] = '功能正在开发中...';
		$data['img'] = 'true.png';
		$data['message'] = '功能正在开发中，敬请期待！';
		$data['where_1'] = '会员中心';
		$data['url_1'] = site_url('user/account');
		$data['target_1']  = '';
		$data['where_2'] = '网站首页';
		$data['url_2'] = site_url('');
		$data['target_2']  = '';
		$this->load->view('include/header',$data);
		$this->load->view('include/message',$data);
		$this->load->view('include/footer',$data);
	}

}
