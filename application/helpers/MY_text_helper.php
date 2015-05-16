<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * 截取指定字符串
 *  jeff 2014/12/4
 */
if ( ! function_exists('cut_str'))
{
	function cut_str($str = '',$length='',$sign='...')
	{
		if(!trim($str) || !intval($length)) return $str;
		if(function_exists('mb_strlen'))
		{
			$sign = intval(mb_strlen(trim($str),'utf-8'))>intval($length)?$sign:'';	
		}
		else
		{
			$sign = intval(strlen(trim($str)))>intval($length)?$sign:'';	
		}
			
		if(function_exists('mb_substr'))
		{
			return mb_substr($str,0,intval($length),'utf-8').$sign;
		}
		elseif(function_exists('iconv_substr'))
		{
			return iconv_substr($str,0,intval($length),'utf-8').$sign;
		}
		else
			return substr($str,0,intval($length)).$sign;
		
	}
}

/**
 * 取图片缩略图
 */
if( ! function_exists('get_thumb'))
{
	function get_thumb($url='',$thumb = '_thumb')
	{
		$str = '';
		if(!$url || !strpos($url,'.'))
			return FALSE;
		$strpos = strrpos($url,'.');
		$strlen = strlen($url);
		$str = substr($url,0,$strpos);
		$str .= $thumb;
		$str .= substr($url,$strpos,$strlen);
		return $str;
	}
}