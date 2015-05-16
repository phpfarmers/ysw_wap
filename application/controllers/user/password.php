<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
	}

	public function index()
	{
		$data['web_title'] = '邮件找回密码-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$data['title'] = '非法操作';
		$data['img'] = 'false.png';
		$data['message'] = '请重发找回密码邮件';
		$data['where_1']  = '找回密码';
		$data['url_1'] = site_url('user/forget');
		$data['target_1']  = '';
		$data['where_2'] = '网站首页';
		$data['url_2']  = site_url('');
		$data['target_2']  = '';
		$this->load->view('include/header',$data);
		$this->load->view('include/message',$data);
		$this->load->view('include/footer',$data);
	}

	public function email($mail='',$forget_time='')
	{
		$data['web_title'] = '修改密码-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$data['mail'] = $mail;
		$data['forget_time'] = $forget_time;
		if($mail!=''&&$forget_time!='')
		{
			$this->load->model("mail_model");
			if($this->mail_model->check_reset_mail($mail,$forget_time) == 1)
			{
				$password = $this->input->post('password', TRUE);

				$this->load->library('form_validation');
				$this->form_validation->set_rules('password','密码','trim|required|min_length[6]|max_length[32]');
				$this->form_validation->set_rules('passconf','确认密码','trim|required|min_length[6]|max_length[32]|matches[password]');

				if ($this->form_validation->run() == FALSE)
				{
					$this->load->view('include/header',$data);
					$this->load->view('user/password',$data);
					$this->load->view('include/footer',$data);
				}
				else
				{
					$this->mail_model->update_password($password,$mail,$forget_time); //重置会员密码
					$data['title'] = '重置密码已完成';
					$data['img'] = 'true.png';
					$data['message'] = '密码修改已完成，可登录会员中心！';
					$data['where_1']  = '会员登录';
					$data['url_1'] = site_url('user/login');
					$data['target_1']  = '';
					$data['where_2'] = '网站首页';
					$data['url_2']  = site_url('');
					$data['target_2']  = '';
					$this->load->view('include/header',$data);
					$this->load->view('include/message',$data);
					$this->load->view('include/footer',$data);
				}
			}
			else
			{
				$data['title'] = '邮件已过期';
				$data['img'] = 'false.png';
				$data['message'] = '此密码重置邮件已过期，请重发找回密码邮件';
				$data['where_1']  = '找回密码';
				$data['url_1'] = site_url('user/forget');
				$data['target_1']  = '';
				$data['where_2'] = '网站首页';
				$data['url_2']  = site_url('');
				$data['target_2']  = '';
				$this->load->view('include/header',$data);
				$this->load->view('include/message',$data);
				$this->load->view('include/footer',$data);
			}
		}
		else
		{
			$data['title'] = '非法操作';
			$data['img'] = 'false.png';
			$data['message'] = '请重发找回密码邮件';
			$data['where_1']  = '找回密码';
			$data['url_1'] = site_url('user/forget');
			$data['target_1']  = '';
			$data['where_2'] = '网站首页';
			$data['url_2']  = site_url('');
			$data['target_2']  = '';
			$this->load->view('include/header',$data);
			$this->load->view('include/message',$data);
			$this->load->view('include/footer',$data);
		}
	}

}