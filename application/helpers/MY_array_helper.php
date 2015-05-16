<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * array2str
 * jeff 2014/12/6
 * 将数组的每个值添加''
 */
if(! function_exists('array2str'))
{
	function array2str($array=array())
	{
		$str = '';
		if(empty($array)) return FALSE;
		foreach($array as $k=>$v)
		{
			$str .= "'".$v."',";
		}
		return trim($str,',');
	}
}

/**
 * 用0替代false
 */
if ( ! function_exists('elements'))
{
	function elements($items, $array, $default = FALSE)
	{
		$return = array();
		
		if ( ! is_array($items))
		{
			$items = array($items);
		}
		
		foreach ($items as $item)
		{
			if (isset($array[$item]) && $array[$item])
			{
				$return[$item] = $array[$item];
			}
			else
			{
				$return[$item] = $default;
			}
		}

		return $return;
	}
}
