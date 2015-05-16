<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_success extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->database();
		if (!$this->is_login())
		{
			@session_start();
			$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
			redirect(site_url('prompt'), 'refresh');
		}
	}

	public function index($product_uuid='')
	{
		$data['web_title'] = '发布产品-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$data['product_uuid'] = $product_uuid;
		$this->load->view('include/header',$data);
		$this->load->view('user/product_success',$data);
		$this->load->view('include/footer',$data);
	}

}