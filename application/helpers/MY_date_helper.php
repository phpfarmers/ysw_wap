<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 *
 *  jeff 2015/3/20
 */
if ( ! function_exists('good_time'))
{
	function good_time()
	{
		$hour = date('H',now());
		$str = '';
		if(7 <= $hour and $hour < 11)
		{
			$str = '上午';
		}elseif(11 <= $hour and $hour < 13)
		{
			$str = '中午';
		}elseif(13 <= $hour and $hour < 19)
		{
			$str = '下午';
		}elseif(19 <= $hour and $hour < 24)
		{
			$str = '晚上';
		}
		else
		{
			$str = '凌晨';
		}
		return $str;
	}
}
