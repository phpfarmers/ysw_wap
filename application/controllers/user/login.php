<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->is_login())
		{
			redirect(site_url(), 'refresh');
		}
		$this->load->model('user_model');
		$this->lang->load('user');
	}

	public function index()
	{
		$this->load->library('form_validation');
		$this->_login_save();
		$this->_login_form();
	}

	/**
	 * form
	 */
	protected function _login_form()
	{
		$data['web_title'] = '会员注册-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$data['headerh2'] = lang('Sign in');
		$this->load->view('include/header',$data);
		$this->load->view('user/login',$data);
		$this->load->view('include/footer',$data);
	}

	/**
	 * save
	 */
	protected function _login_save()
	{
		if($this->input->post(NULL,TRUE))
		{
			$this->form_validation->set_rules('username','lang:Username','trim|required|valid_email|max_length[30]|xss_clean');
			$this->form_validation->set_rules('password','lang:Password','trim|required|min_length[6]|max_length[32]|callback_check_exists');
			if ($this->form_validation->run())
			{
				$data = array();
				$ip = $this->input->ip_address();
				$time = time();				
				
				// 获取配置文件中登录积分、威望值
				$arr = $this->config->item('intergral');
				$intergral = $arr['user_login'];
				$uuid = $this->session->userdata('uuid');
				$intergrals = $this->session->userdata('intergral');
				$prestiges = $this->session->userdata('prestige');
				$username = $this->session->userdata('username');

				//判断是否满足会员赠送积分规则
				$type = '19';
				$times = strtotime(date('Y-m-d'));
				$this->load->model('intergral_model');
				if($this->intergral_model->integral_num($uuid,$type,$times) < '1')
				{
					//intergral_uuid
					$intergral_uuid = $prestige_uuid = $this->intergral_model->uuid();

					$prestige = $this->config->item('prestige');
					$prestige = $prestige['user_login'];

					//每日登录增加积分
					$data = array(
						'intergral_uuid' => $intergral_uuid,
						'uuid' => $uuid,
						'intergral' => $intergral,
						'title' => '每日登录 积分+'.$intergral,
						'create_time' => $time,
						'create_ip' => $ip,
						'status' => '1',
						'type' => $type
						);
					$this->intergral_model->integral($data);

					//更新总积分
					$intergral = $intergrals + $intergral;
					$this->intergral_model->update_total($uuid,$intergral);
					$this->session->set_userdata('intergral',$intergral);

					//每日登录增加声望
					$this->load->model('prestige_model');
					$data = array(
						'prestige_uuid' => $prestige_uuid,
						'uuid' => $uuid,
						'prestige' => $prestige,
						'title' => '每日登录 声望+'.$prestige,
						'create_time' => $time,
						'create_ip' => $ip,
						'status' => '1',
						'type' => $type
						);
					$this->prestige_model->prestige($data);

					//更新总声望
					$prestige = $prestiges + $prestige;
					$this->prestige_model->update_total($uuid,$prestige);
					$this->session->set_userdata('prestige',$prestige);

					// 设置提示cookie
					$this->session->set_userdata('login','1');
				}

				$type = '2';
				$desc = '会员登录';
				$table = 'ysw_user';
				$json = '';
				$ctr = '';
				$log_sql = "UPDATE `ysw_user` SET `last_ip` = '$ip', `last_time` = '$time' WHERE `username` = '$username'";
				$this->user_model->update_user_last($username);
				$this->user_model->insert_user_log($uuid,$type,$desc,$table,$log_sql,$json,$time,$ctr,$ip);
				redirect(site_url(), 'refresh');
			}
		}
	}
	
	/**
	*
	*/
	public function check_exists()
	{
		$where = "";
		$username = $this->input->get_post('username',TRUE);
		$password = $this->input->get_post('password',TRUE);
		if($username) 
		{
			$password = md5($password);
			$where = "username = '".$username."' and password = md5(concat('".$password."',salt)) and islock != '1'";
		}
		$row = $this->user_model->fetch_row($where);
		if(!$row)
		{
			$this->form_validation->set_message('check_exists', lang('The user is locked or is not exsits'));
			return FALSE;
		}
		else
		{		
			// 记录cookie
			$session_data = array(
				'uuid'=>$row->uuid,
				'username'=>$row->username,
				'nickname'=>$row->nickname,
				'avatar'=>$row->user_pic,
				'usergrade'=>$row->user_grade,
				'intergral'=>$row->intergral,
				'prestige'=>$row->prestige
			);
			$this->session->set_userdata($session_data);
			return TRUE;
		}
	}
}