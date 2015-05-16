<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forget extends MY_Controller {

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

		
		$username = $this->input->post('mail', TRUE);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('mail','账号','trim|required|valid_email');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('include/header',$data);
			$this->load->view('user/forget',$data);
			$this->load->view('include/footer',$data);
		}
		else
		{
			$this->load->model('user_model');
			$data['mail'] = $mail = $this->user_model->email($username);
			if ($this->user_model->check_mail($username) == 0)
			{
				$data['title'] = '邮件发送失败';
				$data['img'] = 'false.png';
				$data['message'] = '此账号不存在，请重新填写或新注册会员！';
				$data['where_1'] = '重新填写';
				$data['url_1']  = site_url('user/forget');
				$data['target_1']  = '';
				$data['where_2'] = '注册会员';
				$data['url_2'] = site_url('user/reg');
				$data['target_2']  = '';
				$this->load->view('include/header',$data);
				$this->load->view('include/message',$data);
				$this->load->view('include/footer',$data);
			}
			else
			{
				if($mail!='')
				{
					$this->load->model('mail_model');
					$forget_time = strtotime(date("Y-m-d H:i:s"));
					$this->mail_model->update_forget_time($mail,$forget_time); //更新会员表中的发送找回密码邮件时间

					//获取重置密码会员昵称
					$nickname = $this->user_model->check_nickname($mail);

					$title = '游商网找回账户密码通知';
					$href = site_url('user/password/email').'/'.urlencode(base64_encode($mail)).'/'.$forget_time;
					$message = '
					<style type="text/css">
					.mail_main{width:98%;max-width:730px;margin:0px auto;border:#f1f1f1 5px solid;font:normal normal normal 12px/22px Arial, Helvetica, sans-serif,宋体;color:#333333;}
					.mail_header{margin:5px;padding:5px 0px;border-bottom:#f1f1f1 1px solid;}
					.mail_content{margin:5px;min-height:100px;overflow:hidden;padding:5px 0px;}
					.mail_content p{margin:5px 0px;padding:0px 5px;}
					.mail_footer{margin:5px;border-top:#f1f1f1 1px solid;padding:5px 0px;}
					.mail_footer p{margin:0px;padding:0px 5px;text-align:right;}
					.mail_main a:link{color:#333333;}
					.mail_main a:visited{color:#333333;}
					.mail_main a:hover{color:#ff9400;}
					.mail_main a:active{color:#ff9400;}
					</style>
					<div class="mail_main">
						<div class="mail_header"><img src="http://res.51gamebiz.com/public/images/logo.gif" style="width:50%;max-width:342px;"></div>
						<div class="mail_content">
							<p>您好 '.$nickname.'：</p>
							<p>您正在使用邮箱：'.$mail.',在游商网执行了找回密码操作。</p>
							<p>请您打开或复制下面的地址来执行重置密码操作。</p>
							<p>'.$href.'</p>
							<p>您的本次验证操作将在 60分钟 后过期，过期后请重新执行密码找回步骤。</p>
							<p>如果不是您发起的密码找回请求或者您不想找回密码请忽略本邮件。</p>
							<p>本邮件由系统发出,请不要直接进行回复。</p>
						</div>
						<div class="mail_footer"><p>Copyright © 2015 游商网 All Rights Reserved</p></div>
					</div>';
					$this->mail_model->send_mail($mail,$title,$message);

					$data['title'] = '邮件发送成功！';
					$data['img'] = 'true.png';
					$data['message'] = '邮件已发送到你的邮箱，请通过安全链接修改密码。';
					$data['where_1'] = '重新发送';
					$data['url_1'] = site_url('user/forget');
					$data['target_1']  = '';
					$data['where_2'] = '登录邮箱';
					$mai=explode('@',$mail);
					$domain = $mai[1];
					$data['url_2']  = 'http://mail.'.$domain;
					$data['target_2']  = "target='_blank'";
					$this->load->view('include/header',$data);
					$this->load->view('include/message',$data);
					$this->load->view('include/footer',$data);
				}
				else
				{
					$data['title'] = '验证邮件发送失败';
					$data['img'] = 'false.png';
					$data['message'] = '邮箱地址为空，发送验证邮件失败';
					$data['where_1'] = '账户资料';
					$data['url_1'] = site_url('user/account');
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
	}
}