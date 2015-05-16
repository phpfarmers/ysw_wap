<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 递归 jeff 2014/11/21
*/
if ( ! function_exists('category'))
{
	function category($data=array(),$parent=0,$for_name='',$clear='')
	{
		global $jefffoo,$jeffstr;
		if('clear' === $clear)
			$jefffoo = $jeffstr = '';	

		if($data)
		{
			foreach($data as $k=>$row)
			{
				if($row->parent == $parent)
				{
					if('0' === $row->parent)
					{
						//$jeffstr = '|-';
						$jeffstr = '&nbsp;&nbsp;';
					}
					else
					{
						//$jeffstr .= '-';
						$jeffstr .= '&nbsp;&nbsp;';
					}
					
					if($for_name)
						$row->$for_name = $jeffstr.$row->$for_name;
					if('0' !== $row->parent)
						$jeffstr = substr($jeffstr,0,-12);
					category($data,$row->id,$for_name);
					$jefffoo[] = $row;
					unset($data[$k]);
				}
			}
		}
		
		return $jefffoo;
	}
}
/**
 *
 *改写递归  jeff 2014/12/2
 */
if ( ! function_exists('get_in_tree'))
{
	function  get_in_tree($array, $pid = 0, $y=0, $html='' , $column='id' , $name='name' , & $tdata = array(), &$tname = array())
	{
		foreach ($array as $k=>$row)
		{
			if ($row->parent == $pid)
			{

				$n = $y + 1;
				$row->grade = $y;
				$tdata[] = $row;
				$html.='&nbsp;&nbsp;';
				$tname[$row->$column] = $html.$row->$name;
				get_in_tree($array, $row->id, $n, $html , $column , $name , $tdata, $tname);
				$html = substr($html,0,-12);
				unset($array[$k]);
			}
		}
		$data['data'] = $tdata;
		$data['name'] = $tname;
		return $data;
	}
}

/**
 *  针对文章回复 
 * 改写递归  jeff 2014/12/16
 */
if ( ! function_exists('get_in_treess'))
{
	function  get_in_treess($array, $pid = 0, $y=0, $html='' , $column='id' , $name='id' , & $tdatas = array(), &$tname = array())
	{
		foreach ($array as $k=>$row)
		{
			if ($row->parent == $pid)
			{

				$n = $y + 1;
				$tdatas[$row->parent][] = $row;
				$html.='&nbsp;&nbsp;';
				$tname[$row->$column] = $html.$row->$name;
				get_in_treess($array, $row->comment_uuid, $n, $html , $column , $name , $tdatas, $tname);
				$html = substr($html,0,-12);
				//unset($array[$k]);
			}
		}
		$data['data'] = $tdatas;
		return $data;
	}
}


/**
 * 将数据格式化成树形结构（文章评论）
 * @author Sunny
 * @param array $items
 * @return array
 */
if(!function_exists("comment")){
	function comment($items,$id = 'id' ,$pid = 'pid' ,$child = 'children' ) {
	    $tree = array(); //格式化好的树
	    foreach ($items as $item)
			//var_dump(isset($items[$item[$pid]]));
	        if (isset($items[$item[$pid]]))
	            $items[$item[$pid]][$child][] = &$items[$item[$id]];
			else
	            $tree[] = &$items[$item[$id]];
	    return $tree;
	}	
}

/**
 * view load view
 */
if ( ! function_exists('load_view'))
{
	function load_view($view, $vars = '', $return = FALSE)
	{
		$CI =& get_instance();
		return $CI->load->view($view, $vars, $return);
	}
}