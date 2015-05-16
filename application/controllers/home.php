<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('information_model');
		$this->load->model('task_model');
		$this->load->model('company_model');
		$this->load->model('friendlink_model');
	}

	public function index()
	{
		//$this->output->cache($this->config->config['cache_time']/60);
		$this->_view();
	}

	protected function _view()
	{
		$data['web_title'] = '游商网，一站式游戏商务综合门户';
		$data['headerh2'] = lang('YSW');
		//最新资讯
		//$data['news'] = $this->information_model->news();

		//最新合作
		$data['new_task'] = $this->task_model->new_task(10);

		//热门资讯
		$data['hot_news'] = $this->information_model->hot_news(8);

		//热们合作
		//$data['hot_task'] = $this->task_model->hot_task_h();

		//新进公司
		$data['new_company'] = $this->company_model->new_company();

		//外包服务商
		$company = $this->company_model->company();
		foreach($company as $row)
		{
			$arr = $this->company_model->companys($row->id);
			$data['company'][] = array(
				'id'=>$row->id,
				'parent'=>$row->parent,
				'name'=>$row->name,
				'arr'=>$arr
			);
		}

		//友情链接
		//$data['friendlink'] = $this->friendlink_model->get_lists();
		//print_r($data['hot_news']);exit;
		$this->load->view('include/header',$data);
		$this->load->view('home',$data);
		$this->load->view('include/footer',$data);
	}
}
