<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Keyword extends MY_Controller {

	public function index()
	{
		echo '错误';
	}

	public function check($content)
	{
		$content = urldecode($content);
		$this->config->load('keyword');
		$keyword = $this->config->item('keyword');
		$keyword="/".implode("|",$keyword)."/i";
		if(preg_match($keyword, $content, $matches))
		{
			echo implode("、",$matches);
		} 
	}

}
