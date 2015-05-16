<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 过滤敏感词
 * @author Sunny
 *
 */

// 敏感词替换成*
if(!function_exists("check_keyword"))
{
	function check_keyword($content)
	{
		include(APPPATH.'config/keyword.php');
		$keyword = $config['keyword'];
		$checkword = array_combine($keyword,array_fill(0,count($keyword),'*'));
		$str = strtr($content,$checkword);
		return $str;
	}	
}

