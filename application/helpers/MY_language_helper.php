<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*当原文没有对应的翻译，将返回原文 jeff 2014/10/29
*/
if ( ! function_exists('lang'))
{
	function lang($line, $id = '')
	{
		$CI =& get_instance();
		$original = $line;
		$line = $CI->lang->line($line);
		$line = $line?$line:$original;
		if ($id != '')
		{
			$line = '<label for="'.$id.'">'.$line."</label>";
		}

		return $line;
	}
}