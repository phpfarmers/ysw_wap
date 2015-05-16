<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('account_model');
		if (!$this->is_login())
		{
			@session_start();
			$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
			redirect(site_url('prompt'), 'refresh');
		}
	}

	public function index()
	{
		$data['web_title'] = '账户资料-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$this->load->library('form_validation');
		if($this->input->post())
		{
			$nickname = $this->input->post('nickname', TRUE);

			$oldpassword = $this->input->post('oldpassword', TRUE);
			$password = $this->input->post('password', TRUE);
			$passconf = $this->input->post('passconf', TRUE);

			$realname = $this->input->post('realname', TRUE);
			$sex = $this->input->post('sex', TRUE);
			$identity = $this->input->post('identity', TRUE);
			$mobile = $this->input->post('mobile', TRUE);
			$province = $this->input->post('province', TRUE);
			$city = $this->input->post('city', TRUE);
			$qq = $this->input->post('qq', TRUE);
			$weixin = $this->input->post('weixin', TRUE);
			$weibo = $this->input->post('weibo', TRUE);

			$this->form_validation->set_rules('nickname','昵称','trim|required|min_length[2]');
			if($oldpassword)
			{
				$this->form_validation->set_rules('oldpassword','原始密码','trim|required|min_length[6]|max_length[32]');
				$this->form_validation->set_rules('password','新密码','trim|required|min_length[6]|max_length[32]');
				$this->form_validation->set_rules('passconf','确认密码','trim|required|min_length[6]|max_length[32]|matches[password]');
			}
			$this->form_validation->set_rules('realname','姓名','trim|required|min_length[2]');
			$this->form_validation->set_rules('sex','性别','trim|required');
			$this->form_validation->set_rules('mobile','手机','required|numeric|exact_length[11]');
			$this->form_validation->set_rules('identity','身份证号','trim|min_length[15]|max_length[18]');
			$this->form_validation->set_rules('qq','QQ','numeric|min_length[5]|max_length[15]');
			$this->form_validation->set_rules('weixin','微信','trim|min_length[1]|max_length[25]');
			$this->form_validation->set_rules('weibo','微博','trim|min_length[1]|max_length[30]');
			$this->form_validation->set_rules('province','省','numeric|min_length[1]|max_length[5]');
			$this->form_validation->set_rules('city','市','numeric|min_length[1]|max_length[5]');
			if ($this->form_validation->run())
			{
				if($nickname || $mobile)
				{
					if($oldpassword)
					{
						$this->load->model('user_model');
						$row_p = $this->user_model->user_login(USERNAME,$oldpassword); // 验证原始密码是否有误
						if($row_p['password'] == md5(md5($oldpassword).$row_p['salt']))
						{
							$this->account_model->update_user_account(UUID,$nickname,$mobile,$password); //修改密码时更新会员信息（ysw_user）
						}
						else
						{
							$data['title'] = '修改密码失败';
							$data['img'] = 'false.png';
							$data['message'] = '原始密码有误，请重新修改或者找回密码！';
							$data['where_1'] = '账户资料';
							$data['url_1'] = site_url('user/account');
							$data['target_1']  = '';
							$data['where_2'] = '找回密码';
							$data['url_2'] = site_url('user/forget');
							$data['target_2']  = '';
							$this->load->view('include/header',$data);
							$this->load->view('include/message',$data);
							$this->load->view('include/footer',$data);
						}	
					}
					else
					{
						$this->account_model->update_user(UUID,$nickname,$mobile); //更新会员信息（ysw_user）
					}
					
					if($_SESSION['uuid'])
					{
						$_SESSION['nickname']=$nickname;
					}
					elseif(!$this->session->userdata('uuid')) 
					{
						$session_data = array(
							'nickname'=>$nickname
						);
						$this->session->set_userdata($session_data);
					}
				}
				
				if($this->input->post('uuid', TRUE)==='')
				{
					$this->account_model->insert_user_info(UUID,$realname,$sex,$identity,$province,$city,$qq,$weixin,$weibo); //插入会员信息（ysw_user_info）
				}
				else
				{
					$this->account_model->update_user_info(UUID,$realname,$sex,$identity,$province,$city,$qq,$weixin,$weibo); //更新会员信息（ysw_user_info）
				}

				$data['title'] = '修改完善账户资料已成功';
				$data['img'] = 'true.png';
				$data['message'] = '修改完善账户资料已成功！';
				$data['where_1'] = '账户资料';
				$data['url_1']  = site_url('user/account');
				$data['target_1']  = '';
				$data['where_2'] = '网站首页';
				$data['url_2'] = site_url('');
				$data['target_2']  = '';
				$this->load->view('include/header',$data);
				$this->load->view('include/message',$data);
				$this->load->view('include/footer',$data);
				
			}
		}
		$this->_form();
	}

	protected function _form()
	{
		$this->load->model('region_model');		
		$row = $this->account_model->user_info(UUID);
		if($this->account_model->check_user_info(UUID) !== 0)
		{
			$data['uuid'] = $row['uuid'];
			$data['province'] = $row['province'];
			$data['city'] = $row['city'];
		}
		else
		{
			$data['uuid'] = '';
			$data['province'] = '25';
			$data['city'] = '2703';
		}
		$data['provinces'] = $this->region_model->provinces();
		$data['citys'] = $this->region_model->children_of($data['province']);
		$data['email_checked'] = $row['email_checked'];
		$data['user_pic'] = $row['user_pic'];
		$data['realname'] = $row['realname'];
		$data['nickname'] = $row['nickname'];
		$data['sex'] = $row['sex'];
		$data['identity'] = $row['identity'];
		if($row['mobile'] !== 0)
		{
			$data['mobile'] = $row['mobile'];
		}
		else
		{
			$data['mobile'] = '';
		}
		$data['mobile_checked'] = $row['mobile_checked'];
		
		if('0' !== $row['qq'])
		{
			$data['qq'] = $row['qq'];
		}
		else
		{
			$data['qq'] = '';
		}
		$data['weixin'] = $row['weixin'];
		$data['weibo'] = $row['weibo'];
		$this->load->view('include/header',$data);
		$this->load->view('include/user_left',$data);
		$this->load->view('user/account',$data);
		$this->load->view('include/footer',$data);		
	}
	// 邮箱验证
	public function verify_email()
	{
		$data['web_title'] = '邮箱验证-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$data['nickname'] = $nickname = NICKNAME;
		$this->load->model('user_model');
		$mail = $this->user_model->email(USERNAME);

		if($mail!='')
		{
			$this->load->model('mail_model');
			$code = $this->mail_model->code('4'); //生成邮件验证码
			$this->mail_model->update_mail_code($mail,$code); //更新会员表中的邮件验证码
			
			$title = '游商网邮箱验证通知';
			$href = site_url('user/verify/email').'/'.urlencode(base64_encode($mail)).'/'.$code;
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
							<p>您正在使用邮箱：'.$mail.',在游商网执行了邮箱验证操作。</p>
							<p>请您打开或复制下面的地址来执行邮箱验证操作。</p>
							<p>'.$href.'</p>
							<p>您的本次验证操作将在 60分钟 后过期，过期后请重新执行邮箱验证操作。</p>
							<p>如果不是您发起的邮箱验证请求或者您不想使用邮箱验证请忽略本邮件。</p>
							<p>本邮件由系统发出,请不要直接进行回复。</p>
						</div>
						<div class="mail_footer"><p>Copyright © 2015 游商网 All Rights Reserved</p></div>
					</div>';
			$this->mail_model->send_mail($mail,$title,$message);

			$data['title'] = '验证邮件发送成功';
			$data['img'] = 'true.png';
			$data['message'] = '验证邮件发送成功，请查看邮件点击验证！';
			$data['where_1'] = '账户资料';
			$data['url_1'] = site_url('user/account');
			$data['target_1']  = '';
			$data['where_2'] = '验证邮箱';
			$ma = explode('@',$mail);
			$domain = $ma[1];
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
