<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cooperation extends MY_Controller {

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

	public function index($company_uuid = 0,$page = 1)
	{
		$data['web_title'] = '我发布的合作-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$this->load->model("cooperation_model");

		//分页
		$this->load->library('pagination');
		$config['base_url']   = site_url('user/cooperation/index/'.$company_uuid.'/');
	    $config['total_rows'] = $this->cooperation_model->total_rows(UUID,$company_uuid);
	    $config['per_page']   = 12;
	    $config['num_links']  = 3;
		$config['uri_segment'] = 5;
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

		// 合作信息列表
		$data['cooperation_product'] = $this->cooperation_model->cooperation_product(UUID,$company_uuid,$config['per_page'],$page);

		$this->load->view('include/header',$data);
		$this->load->view('include/user_left',$data);
		$this->load->view('user/cooperation',$data);
		$this->load->view('include/footer',$data);
	}

	// 修改编辑我发布的任务
	public function edit($task_uuid,$status)
	{
		$data['web_title'] = '修改编辑产品-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$data['title'] = '功能开发中...';
		$data['img'] = 'true.png';
		$data['message'] = '功能正在开发中，敬请期待！';
		$data['where_1'] = '我发布的合作';
		$data['url_1'] = site_url('user/cooperation');
		$data['target_1']  = '';
		$data['where_2'] = '网站首页';
		$data['url_2'] = site_url('');
		$data['target_2']  = '';
		$this->load->view('include/header',$data);
		$this->load->view('include/message',$data);
		$this->load->view('include/footer',$data);
	}

	// 删除我发布的任务
	public function del($task_uuid)
	{
		$data['web_title'] = '删除产品-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$this->load->model("cooperation_model");
		$this->cooperation_model->del_cooperation($task_uuid);

		$data['title'] = '删除合作已成功';
		$data['img'] = 'true.png';
		$data['message'] = '我发布的合作已成功删除！';
		$data['where_1'] = '我发布的合作';
		$data['url_1'] = site_url('user/cooperation');
		$data['target_1']  = '';
		$data['where_2'] = '网站首页';
		$data['url_2'] = site_url('');
		$data['target_2']  = '';
		$this->load->view('include/header',$data);
		$this->load->view('include/message',$data);
		$this->load->view('include/footer',$data);
	}

}
