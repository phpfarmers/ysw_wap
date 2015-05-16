<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pioneer extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		redirect(site_url('prompt/develop'), 'refresh');
		/*$data['web_title'] = '创业-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$this->load->view('include/header_12',$data);
		$this->load->view('pioneer',$data);
		$this->load->view('include/footer_12',$data);*/
	}
}
