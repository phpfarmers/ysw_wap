<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->output->cache($this->config->config['cache_time']/60);
		$data['web_title'] = '咨询-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$this->load->view('include/header_12',$data);
		$this->load->view('building',$data);
		$this->load->view('include/footer_12',$data);
	}

	public function show()
	{
		$data['web_title'] = '咨询-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$this->load->view('include/header_12',$data);
		$this->load->view('building',$data);
		$this->load->view('include/footer_12',$data);
	}
}
