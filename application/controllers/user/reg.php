<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reg extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->lang->load('user');
		$this->load->model('user_model');
	}

	public function index()
	{
		$this->load->library('form_validation');
		$this->_reg_save();
		$this->_reg_form();
	}
	
	/**
	 *
	 *
	 */
	protected function _reg_form()
	{
		$data['web_title'] = '会员注册-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$data['headerh2'] = lang('Sign up');
		$this->load->view('include/header',$data);
		$this->load->view('user/reg',$data);
		$this->load->view('include/footer',$data);
	}

	/**
	 *
	 */
	protected function _reg_save()
	{
		if($this->input->post(NULL,TRUE))
		{
			$this->form_validation->set_rules('username','lang:Username','trim|required|valid_email|max_length[30]|xss_clean|is_unique[User.username]');
			$this->form_validation->set_rules('nickname','lang:Nickname','trim|required|min_length[2]|max_length[30]|xss_clean');
			$this->form_validation->set_rules('password','lang:Password','trim|required|min_length[6]|max_length[32]');
			$this->form_validation->set_rules('passconf','lang:Passconf','trim|required|min_length[6]|max_length[32]|matches[password]');
			$this->form_validation->set_rules('agree','lang:Agree','required|is_natural_no_zero');

			if ($this->form_validation->run())
			{
				$data = array();
				$ip = $this->input->ip_address();
				$time = time();				
				// 获取配置文件中注册赠送积分数量
				$arr = $this->config->item('intergral');

				$data['intergral'] = $intergral = $arr['user_reg'];
				$data['username'] = $data['email'] = $this->input->post('username',TRUE);
				$data['nickname'] = $this->input->post('nickname',TRUE);
				$password = $this->input->post('password',TRUE);
				$data['salt'] = mt_rand(1000,9999);
				$data['password'] = md5(md5($password).$data['salt']);
				$data['reg_ip'] = $ip;
				$data['create_time'] = $time;
				//当前表中编号最大值
				$this->load->model('sn_model');
				$sn = $this->sn_model->sn('user');
				$data['sn'] = $sn;
				$data['uuid'] = $this->user_model->uuid();
			    $this->user_model->create($data); //插入会员注册信息

				// 注册赠送积分
				$intergral_uuid = $this->user_model->uuid();

				$this->load->model('intergral_model');
				$dataa = array(
					'intergral_uuid' => $intergral_uuid,
					'uuid' => $data['uuid'],
					'intergral' => $intergral,
					'title' => '注册新账号赠送'.$intergral.'积分',
					'create_time' => $time,
					'create_ip' => $ip,
					'status' => '1',
					'type' => '1'
					);
				$this->intergral_model->integral($dataa);
				redirect('user/login');
			}
		}
	}
}