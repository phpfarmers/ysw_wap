<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Intergral extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->is_login())
		{
			@session_start();
			$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
			redirect(site_url('prompt'), 'refresh');
		}
	}

	public function index()
	{
	}

	//登录增加的积分和声望提示
	public function prompt()
	{
		//删除登录提示cookie
		$this->session->unset_userdata('login');

		// 获取配置文件中登录增加的积分和声望值
		$intergral = $this->config->item('intergral');
		$intergral = $intergral['user_login'];

		$prestige = $this->config->item('prestige');
		$prestige = $prestige['user_login'];

		echo '每日登录 积分+'.$intergral.' 声望+'.$prestige;
	}
}