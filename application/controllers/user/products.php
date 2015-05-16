<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends MY_Controller {

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

	public function index($page = 1)
	{
		$data['web_title'] = '我提交的产品-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$this->load->model("product_model");

		//分页
		$this->load->library('pagination');
		$config['base_url']   = site_url('user/products/index/');
	    $config['total_rows'] = $this->product_model->total_rows(UUID);
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

		// 合作信息列表
		$data['product_list'] = $this->product_model->product_company_list(UUID,$config['per_page'],$page);

		$this->load->view('include/header',$data);
		$this->load->view('include/user_left',$data);
		$this->load->view('user/products',$data);
		$this->load->view('include/footer',$data);
	}

	// 删除产品
	public function del($product_uuid)
	{
		$data['web_title'] = '删除产品-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$this->load->model("product_model");
		$this->product_model->del_product($product_uuid);

		$data['title'] = '删除产品已成功';
		$data['img'] = 'true.png';
		$data['message'] = '产品已成功删除！';
		$data['where_1'] = '我提交的产品';
		$data['url_1'] = site_url('user/products');
		$data['target_1']  = '';
		$data['where_2'] = '网站首页';
		$data['url_2'] = site_url('');
		$data['target_2']  = '';
		$this->load->view('include/header',$data);
		$this->load->view('include/message',$data);
		$this->load->view('include/footer',$data);
	}
	
	/**
	 * 删除相册
	 * jeff 2014/12/16
	 *
	 */
	public function delalbum()
	{
		$album_uuid = $this->uri->segment(4);
		if($this->input->is_ajax_request())
		{		
			if(!$album_uuid || !UUID)
			{
				echo '0';
				exit;
			}
			$this->load->model('productalbum_model');
			$query = $this->productalbum_model->delete($album_uuid,'',UUID);
			if($query)
			{
				echo '1';
				exit;
			}
			else
			{			
				echo '0';
				exit;
			}
		}
		else
		{		
			if(!$album_uuid) return FALSE;
			$this->load->model('productalbum_model');
			return $this->productalbum_model->delete($album_uuid,UUID);
		}
	}

	
}
