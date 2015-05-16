<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Card extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->is_login())
		{
			@session_start();
			$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
			redirect(site_url('prompt'), 'refresh');
		}
		$this->load->database();
		$this->load->model("card_model");
	}

	public function index()
	{
		$data['web_title'] = '个人名片-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		//判断会员是否关联公司
		$nums = $this->card_model->user_company(UUID);
		
		//读取个人名片信息
		$data['card'] = $this->card_model->card(UUID,$nums);

		//判断名片是否存在,存在查出需要显示的信息
		$data['my_card'] = $this->card_model->my_card(UUID);
		if($data['my_card']>0)
		{
			$data['card_show'] = $this->card_model->card_show(UUID);
		}
		else
		{
			$data['card_show']='';
		}

		//名片边框
		if($this->card_model->card_border(USERGRADE))
		{
			$data['card_border'] = $this->card_model->card_border(USERGRADE);
			//print_r($data['card_border']);exit;
		}
		else
		{
			$data['card_border'] = '';
		}
		
		

		//名片底纹
		if($this->card_model->card_bg(USERGRADE))
		{
			$data['card_bg'] = $this->card_model->card_bg(USERGRADE);
			//print_r($data['card_bg']);exit;
		}
		else
		{
			$data['card_bg']='';
		}

		$this->load->view('include/header',$data);
		$this->load->view('include/user_left',$data);
		$this->load->view('user/card',$data);
		$this->load->view('include/footer',$data);
	}
	//自定义名片现实内容
	public function show($str)
	{
		$str = substr($str,0,strlen($str)-1);
		$str = explode("-", $str);
		$data['str'] = $str;

		$num = count($str);
		if(in_array('first_name',$str))
		{
			$num = $num -1;
		}
		if(in_array('realname',$str))
		{
			$num = $num -1;
		}
		if(in_array('nickname',$str))
		{
			$num = $num -1;
		}
		if(in_array('job',$str))
		{
			$num = $num -1;
		}
		if(in_array('border',$str))
		{
			$num = $num -1;
		}
		if(in_array('background',$str))
		{
			$num = $num -1;
		}
		$data['num'] = $num;

		//读取个人名片信息
		$nums = 0 ;
		$data['card'] = $this->card_model->card(UUID,$nums);

		$this->load->view('user/card_show',$data);
	}

	//添加或修改名片
	public function edit($str,$border='0',$bg='0')
	{
		$str = substr($str,0,strlen($str)-1);
		$str = explode("-", $str);
		$a = array('realname','nickname','first_name','job','company','email','mobile','qq','weixin');
		foreach($a as $value)
		{
			if( in_array($value,$str))
			{
				if($value == 'realname')
				{
					$data['name'] = '0';
				}
				elseif($value == 'nickname')
				{
					$data['name'] = '1';
				}
				elseif($value != 'realname' && $value != 'nickname')
				{
					$data[$value] = '1';
				}
			}
			else
			{
				if($value != 'realname' && $value != 'nickname')
				{
					$data[$value] = '0';
				}
			}
		}
		//判断名片是否存在
		if($this->card_model->my_card(UUID)>0)
		{		
			$data['border'] = $border;
			$data['background'] = $bg;
			$data['status'] = 0;
			$this->card_model->edit_card($data,UUID);
			echo '编辑名片已成功！';
		}
		else
		{
			$sql = "select uuid() uuid";
			$q = $this->db->query($sql)->row();
			$data['card_uuid'] = $q->uuid;
			$data['uuid'] = UUID;
			$data['border'] = $border;
			$data['background'] = $bg;
			$data['status'] = 0;
			$data['create_time'] = strtotime(date("Y-m-d H:i:s"));
			$data['create_ip'] = $this->input->ip_address();
			$this->card_model->add_card($data);
			echo '添加名片已成功！';
		}
	}

}