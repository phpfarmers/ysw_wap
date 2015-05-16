<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Task {

	/* 热门合作 */
	public function _hot_task($hot = array())
	{
		echo '<div class="coop_newp">';
		echo '<div class="hot_more coop_hot"><strong>热门合作</strong><span><a href="'.site_url('cooperation/index/order/intents-desc').'" target="_blank">查看更多&gt;&gt;</a></span></div>';
		$ii = 0 ;
		foreach($hot as $row)
		{
			$ii++;
			if($ii > 4 )
			{
				echo '<dl style="border-bottom:none;">';
			}
			else
			{
				echo '<dl>';
			}
			if(!empty($row->product_icon))
			{
				echo '<dt><a href="'.site_url('cooperation/show/'.$row->task_uuid).'" target="_blank"><img width="60" height="60" src="'.static_url('uploadfile/image/product/'.$row->product_icon).'"></a></dt>';
			}
			else
			{
				echo '<dt><a href="'.site_url('cooperation/show/'.$row->task_uuid).'" target="_blank"><img width="60" height="60" src="'.static_url('public/images/not_pics.jpg').'"></a></dt>';
			}
			echo '<dd class="coop_newdd"><a href="'.site_url('cooperation/show/'.$row->task_uuid).'" target="_blank">'.cut_str($row->title,8,'...').'</a></dd>';
			if($row->amount!='0')
			{
				echo '<dd class="coop_newsp">赏金： <span>￥'.$row->amount.'</span></dd>';
			}
			else
			{
				echo '<dd class="coop_newsp">赏金： <span>商议</span></dd>';
			}
			echo '</dl>';
		}
		echo '</div>';
	}

}