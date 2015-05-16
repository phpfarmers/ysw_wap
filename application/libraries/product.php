<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product {

	/* 新进产品 */
	public function _new_product($new = array(),$type = array())
	{
		echo '<div class="coop_newp">';
		echo '<div class="hot_more coop_hot"><strong>新进产品</strong><span><a href="'.site_url('products/index/order/create_time-desc').'" target="_blank">查看更多&gt;&gt; </a></span></div>';
		$jj = 0;
		foreach($new as $row)
		{
			$jj++;
			if($jj > 4 )
			{
				echo '<dl style="border-bottom:none;">';
			}
			else
			{
				echo '<dl>';
			}
			if(!empty($row->product_icon))
			{
				echo '<dt><a title="'.$row->product_name.'" href="'.site_url('products/show/'.$row->product_uuid).'" target="_blank"><img width="60" height="60" src="'.static_url('uploadfile/image/product/'.$row->product_icon).'"></a></dt>';
			}
			else
			{
				echo '<dt><a title="'.$row->product_name.'" href="'.site_url('products/show/'.$row->product_uuid).'" target="_blank"><img width="60" height="60" src="'.static_url('public/images/not_pics.jpg').'"></a></dt>';
			}
			echo '<dd class="newcon_aa" style="margin:10px 0px 0px 0px;"><a title="'.$row->product_name.'" href="'.site_url('products/show/'.$row->product_uuid).'" target="_blank">'.cut_str($row->product_name,8,'...').'</a></dd>';
			echo '<dd>类型：';
			$arrs = array_filter(explode(',',$row->radio1.','.$row->radio2.','.$row->product_type));
			$arr = array_slice($arrs,0,2);
			$ii=0;
			foreach($arr as $value)
			{
				$ii++;
				if($value<4)
				{
					echo '<a href="'.site_url('products/index/radio1/'.$value).'" target="_blank">'.$type[$value].'</a>';
				}
				else if($value>=4 && $value<6)
				{
					echo '<a href="'.site_url('products/index/radio2/'.$value).'" target="_blank">'.$type[$value].'</a>';
				}
				else
				{
					echo '<a href="'.site_url('products/index/checkbox/'.$value).'" target="_blank">'.$type[$value].'</a>';
				}
				if($ii<count($arr))
				{
					echo '、';
				}
			}
			if(count($arrs)>2)
			{
				echo '<span style="font-family:Arial;">...</span>';
			}
			echo '</dd>';
			echo '</dl>';
		}
		echo '</div>';
	}

}