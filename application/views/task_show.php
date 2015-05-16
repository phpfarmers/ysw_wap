<div data-role="main" class="ui-content paddingtop0 paddingleft0 paddingright0 cooperation">
	<h2><?php echo $task_info->title;?></h2>
	<p class="floatleft pdlr8">
		<span class="greycolor">
			<?php echo lang('Live Time');?>:
		</span>
		<?php
		$time = time();
		$end_time = $task_info->end_time;
		$cycle = $task_info->cycle;
		if(!$end_time && $cycle)
		{
			$end_time = $task_info->create_time + $cycle*86400;
		}
		$now = $end_time - $time;
		if($task_info->success){echo '已结束';}elseif(!$end_time){echo '长期有效';}elseif($time > $end_time and $time < $end_time + 259200){echo '选标中';}elseif($time > $end_time){echo '已过期';}else{
			if($now < 60){ echo $now.'秒';}elseif($now < 3600){echo intval($now/60).'分';}elseif($now < 86400){echo intval($now/3600).'小时';}elseif($now < 31536000){echo intval($now/86400).'天';}else{echo '很久';}
		};?>
	</p>
	<p class="floatright pdlr8"><span class="greycolor"><?php echo lang('SN');?>:</span>C<?php echo $task_info->sn;?></p>
	
	<div class="line"></div>
	
	<div data-role="tabs" id="tabs">
		<div data-role="navbar">
			<ul  id="tab">
				<li><a href="#cooperationinfo" data-ajax="false"><?php echo lang('Cooperation').lang('Info');?></a></li>
				<li><a href="<?php echo site_url('products/ajaxtask/'.$task_info->product_uuid);?>" data-ajax="false"><?php echo lang('Product').lang('Details');?></a></li>
				<li><a href="<?php echo site_url('intention/ajaxintention/'.$task_info->task_uuid);?>" data-ajax="false"><?php echo lang('Intention').lang('Message');?></a></li>
			</ul>
		</div>
		<div id="cooperationinfo" class="ui-body-d ui-content">
			<?php
			load_view('ajax/task_info', $task_info);
			if($task_info->entrusted)
			{?>
				<br>
				<?php echo $task_info->admin_info;?>
			<?php
			}?>
		</div>
	</div>
</div>

	<footer data-role="footer" data-position="fixed" data-tap-toggle="false" id="task_footer">		
		<ul class="ui-grid-b">
			<li class="ui-block-a"><a href="<?php echo site_url('taskupon/ajaxtaskupon').'/'.$task_info->task_uuid;?>" class="ui-btn">点赞</a></li>
			<li class="ui-block-b"><a href="<?php echo site_url('intention/ajaxtaskintention').'/'.$task_info->task_uuid;?>" class="ui-btn">我有意向</a></li>
			<li class="ui-block-c"><a href="<?php echo site_url('taskcollect/ajaxtaskcollect').'/'.$task_info->task_uuid;?>" class="ui-btn">收藏</a></li>
		<ul/>
	</footer><!-- /footer -->
</div>
<script src="<?php echo static_url('statics/js/jquery.min.js');?>"></script>
<script src="<?php echo static_url('m/wap.js');?>"></script>
<script src="<?php echo static_url('m/jquery.mobile-1.4.5.min.js');?>"></script>
</body>
</html>