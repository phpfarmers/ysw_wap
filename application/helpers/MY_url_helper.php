<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 *
 *  jeff 2014/11/28
 */
if ( ! function_exists('static_url'))
{
	function static_url($uri = '')
	{
		$CI =& get_instance();
		return $CI->config->static_url($uri);
	}
}

/**
 * orderby传递的排序
 * anchors 作用于字段集合
 * jeff 2014/12/2
 * 处理 排序显示
 */
if(! function_exists('url_orderby'))
{
	function url_orderby($orderby,$anchors)
	{
		$str = $column ='';
		if(!$orderby)
			return FALSE;
		$cont = strpos($orderby,'.');
		if(FALSE !== $cont)
		{
			$desc = 'desc' === trim(substr($orderby,$cont+1))?'desc':'asc';
			$column = trim(substr($orderby,0,$cont));
			$str  = $column.' '.$desc;
		}
		else
		{
			$column = trim($orderby);
			$str = $column.' asc';
		
		}
		if(!$anchors||!in_array($column,$anchors))
			return FALSE;
		return $str;
	}
}

/**
 * url 当前页面的url，排序将在此基础上增加
 * anchor 数组 要组装的字段名
 * orderby 当前传递的排序名
 * 组装排序链接
 */
if(! function_exists('anchor_url'))
{
	function anchor_url($url = '', $anchor = array(), $orderby='')
	{
		$current = $desc = '';
		$data = array();
		if($orderby)
		{
			$str = strpos($orderby,'.');
			if(FALSE !== $str)
			{
				$current = substr($orderby,0,$str);
				$desc = substr($orderby,$str+1);
			}
			else
			{
				$current = $orderby;
				$desc = 'asc';
			}
		}
		else
		{
			$current='';
			$desc = '';
		}
		if(!is_array($anchor) || !$anchor) return FALSE;
		foreach($anchor as $row)
		{
			$current_desc = $desc_current = '';
			if($current)
			{
				if($row === $current)
				{
					$current_desc = $desc;		
					$desc_current = 'desc' === $desc?'.asc':'.desc';		
				}
				$data[$row] = ' class="sort-link '.$current_desc.'" href='.$url.'/orderby/'.$row.$desc_current;
			}
			else
			{
				$data[$row] = ' class="sort-link " href='.$url.'/orderby/'.$row;
			}
		}
	return $data;
	}
}

// ------------------------------------------------------------------------
/**
 * URL String
 *
 * Returns the URI segments.
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('uri_string'))
{
	function uri_string()
	{
		$CI =& get_instance();
		if(!$CI->uri->uri_string())
			return $CI->router->default_controller.'/'.$CI->router->method;
		return $CI->uri->uri_string();
	}
}

// ------------------------------------------------------------------------