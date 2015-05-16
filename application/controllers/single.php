<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Single extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('single_model');
	}

	//合作详细页
	public function show()
	{
		$id = intval($this->uri->segment(3));

		$this->output->cache($this->config->config['cache_time']/60);
		$data['data'] = $this->single_model->fetch_id(intval($id));
		if(!$id || !$data['data'])
		{
			show_404();
		}
		
		$data['web_title'] = $data['data']->title.'-游商网';
		$data['web_keywords'] = $data['data']->title.'创业,游商网,融资网站,游戏品台';
		$data['web_description'] = $data['data']->title.'游商网,第一个做融资网络游戏的平台！';
		$data['headerh2'] = $data['data']->title;	

		$this->load->view('include/header',$data);
		$this->load->view('single_show',$data);
		$this->load->view('include/footer',$data);
	}

	/**
	 * ajax 合作详细页
	 **/
	public function ajaxshow()
	{
		$id = intval($this->uri->segment(3));
		$this->output->cache($this->config->config['cache_time']/60);
		$data = $this->single_model->fetch_id(intval($id));
		if(!$id || !$data)
		{
			json_encode(lang('Error'));
		}
		echo "<div class='ajaxsingle'>".$data->content."</div>";
	}
}
