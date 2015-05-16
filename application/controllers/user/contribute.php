<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contribute extends MY_Controller {

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
		$this->load->model("contribute_model");
	}

	public function index($page=1)
	{
		$data['web_title'] = '我的投稿-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		//分页
		$this->load->library('pagination');
		$config['base_url']   = site_url('user/contribute/index/');
	    $config['total_rows'] = $this->contribute_model->total_rows(UUID);
	    $config['per_page']   = 12;
	    $config['num_links']  = 3;
		$config['uri_segment'] = 4;
	    $config['use_page_numbers'] = TRUE;

	    $config['first_link'] = '首页';
	    $config['last_link']  = '末页';
	    $config['next_link']  = '下一页';
	    $config['prev_link']  = '上一页';

		$config['num_tag_open']   = '';
	    $config['num_tag_close']  = '';

	    $config['cur_tag_open']   = '<a class="page_currer">';
	    $config['cur_tag_close']  = '</a>';

	    $config['prev_tag_open']  = '';
	    $config['prev_tag_close'] = '';

	    $config['next_tag_open'] = '';
	    $config['next_tag_close'] = '';

	    $config['last_tag_open'] = '';
	    $config['last_tag_close'] = '';

	    $config['first_tag_open'] = '';
	    $config['first_tag_close'] = '';

		$config['full_tag_open'] = '<div id="paging">';
		$config['full_tag_close'] = '</div>';

    	$this->pagination->initialize($config);

		// 我收藏的资料
		$data['contribute'] = $this->contribute_model->contribute_data(UUID,$config['per_page'],$page);
		//print_r($data['contribute']);exit;

		$this->load->view('include/header',$data);
		$this->load->view('include/user_left',$data);
		$this->load->view('user/contribute',$data);
		$this->load->view('include/footer',$data);
	}

	//删除
	public function del($data_uuid)
	{
		$this->contribute_model->del_data($data_uuid);
	}

}
