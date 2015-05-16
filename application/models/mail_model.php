<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail_model extends  CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//发送邮件
	function send_mail($mail,$title,$message)
	{
		$config['protocol'] = 'smtp'; 
		$config['smtp_host'] = 'smtp.51gamebiz.com'; 
		$config['smtp_user'] = 'webmaster@51gamebiz.com'; 
		$config['smtp_pass'] = 'shdsadmin123'; 
		$config['smtp_port'] = '25'; 
		$config['smtp_timeout'] = '5';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html'; 
		$config['charset'] = 'utf-8'; 
		$config['validate'] = true;  
		$config['priority'] = '3';
		$this->load->library('email');
		$this->email->initialize($config);   
		$this->email->from('webmaster@51gamebiz.com','游商网'); 
		$this->email->to($mail);
		$this->email->subject($title); 
		$this->email->message($message);
		$this->email->send();
	}

	//更新会员表中的邮件验证码
	function update_mail_code($mail,$code)
	{
		$data = array(
		'email_code' => $code
		);
		$this->db->update('ysw_user', $data,array('username' => $mail));
	}

	// 验证邮件和邮件验证码是否正确
	function check_mail($mail,$email_code)
	{
		$mail = base64_decode(rawurldecode($mail));
		$query = $this->db->get_where('ysw_user',array('username' => $mail,'email_code' => $email_code));
		return $query->num_rows();
	}

	// 验证邮箱，更新邮箱验证状态
	function update_mail_check($mail,$email_code)
	{
		$mail = base64_decode(rawurldecode($mail));
		$data = array(
		'email_checked' => '1',
		'email_code' => ''
		);
		$this->db->update('ysw_user',$data,array('username' => $mail,'email_code' => $email_code));
	}

	//更新会员表中的发送找回密码邮件时间
	function update_forget_time($mail,$forget_time)
	{
		$data = array(
		'forget_time' => $forget_time
		);
		$this->db->update('ysw_user', $data,array('username' => $mail));
	}

	// 验证邮箱和发送找回邮件时间是否正确
	function check_reset_mail($mail,$forget_time)
	{
		//echo date("Y-m-d H:i:s",time()+3600*7);
		//exit;
		$forget_time = $forget_time - 3600;
		$mail = base64_decode(rawurldecode($mail));
		$query = $this->db->get_where('ysw_user',array('username' => $mail,'forget_time >=' => $forget_time));
		return $query->num_rows();
	}

	// 重置会员密码
	function update_password($password,$mail,$forget_time)
	{
		$salt = mt_rand(1000,9999);
		$mail = base64_decode(rawurldecode($mail));
		$data = array(
		'salt' => $salt,
		'password' => md5(md5($password).$salt),
		'forget_time' => ''
		);
		$this->db->update('ysw_user',$data,array('username' => $mail,'forget_time' => $forget_time));
	}
	
	//生成随机码
	public function code($length)
    {
      $code = "";
      $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      for ($i = 0; $i < $length; $i++)
      {
		//$code .= $chars { mt_rand(0, 35) };
        $code .= $chars { mt_rand(0, 9) };
      }
      return $code;
    }

}