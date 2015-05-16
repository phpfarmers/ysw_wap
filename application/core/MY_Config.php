<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Config extends CI_Config {
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 静态资源
	 */
	function static_url($uri = '')
	{
		if($this->item('static_url') == '')
		{
			return $this->slash_item('base_url').ltrim($this->_uri_string($uri), '/');
		}
		else
		{
			return $this->slash_item('static_url').ltrim($this->_uri_string($uri), '/');
		}
	}
}
