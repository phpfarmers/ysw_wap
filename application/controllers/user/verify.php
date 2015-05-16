<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verify extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
	}

	public function index()
	{
		$data['web_title'] = '验证邮箱-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
	
		$data['title'] = '非法操作';
		$data['img'] = 'false.png';
		$data['message'] = '请登录会员中心重发验证邮件';
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

	public function email($mail='',$email_code='')
	{
		$data['web_title'] = '验证邮箱-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		if($mail!=''&&$email_code!='')
		{
			$this->load->model("mail_model");
			if($this->mail_model->check_mail($mail,$email_code) == 1)
			{
				//获取会员信息
				$this->load->model('user_model');
				$where = 'email = "'.base64_decode(rawurldecode($mail)).'" or email_code = "'.$email_code.'"';
				$row = $this->user_model->user_info($where);

				$this->mail_model->update_mail_check($mail,$email_code); //验证邮箱，更新邮箱验证状态

				//intergral_uuid
				$sql = "select uuid() uuid";
				$q = $this->db->query($sql)->row();
				$intergral_uuid = $q->uuid;

				// 获取配置文件中登录赠送积分数量
				$arr = $this->config->item('intergral');
				$intergral = $arr['email_check'];

				$this->load->model('intergral_model');
				$data = array(
					'intergral_uuid' => $intergral_uuid,
					'uuid' => $row->uuid,
					'intergral' => $intergral,
					'title' => '邮箱验证赠送'.$intergral.'积分',
					'create_time' => strtotime(date('Y-m-d H:i:s')),
					'create_ip' => $this->input->ip_address(),
					'status' => '1'
					);
				$this->intergral_model->integral($data);

				//更新总积分
				$intergral = $row->intergral + $intergral;
				$this->intergral_model->update_total($row->uuid,$intergral);

				$data['web_title'] = '验证邮箱-游商网';
				$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
				$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

				$data['title'] = '邮箱已验证';
				$data['img'] = 'true.png';
				$data['message'] = '邮箱已验证，可登录会员中心查看！';
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
			else
			{
				$data['web_title'] = '验证邮箱-游商网';
				$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
				$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

				$data['title'] = '非法操作';
				$data['img'] = 'false.png';
				$data['message'] = '请登录会员中心重发验证邮件';
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
			$data['title'] = '非法操作';
			$data['img'] = 'false.png';
			$data['message'] = '请登录会员中心重发验证邮件';
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
}