<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Showimg extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->_show_img();
	}

	protected function _show_img()
	{
		$img = $this->uri->segment(3);
		$date = '';
		if($img && strlen($img) > 10)
		{
			$date = '/'.substr($img,0,8).'/';
		}
		$data['img'] = static_url('uploadfile/image').$date.$img;		
		$this->load->view('img_show',$data);
	}
}
