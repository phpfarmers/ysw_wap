<?php
if($intents['data'])
{
	$k = 0;
	foreach($intents['data'] as $k=>$v)
	{
		$k++;
	?>
		<div class="ui-grid-a ui-content">
			<div class="inline-block width25 floatleft">
				<?php
				if(isset($users[$v->create_uuid]) && $users[$v->create_uuid]->user_pic)
				{
					$pic = static_url('uploadfile/image/user').'/100_'.$users[$v->create_uuid]->user_pic;
				}else{
					$pic = static_url('public/images/avatar.jpg');
				}
				?>
				<img src="<?php echo $pic;?>" class="max_width95">
			</div>
			<div class="inline-block width75 floatleft websize">
				<div class="inline-block width75 floatleft">
					<?php
					if(isset($users[$v->create_uuid]) && $uvu = $users[$v->create_uuid])
					{?>
						<?php echo $uvu->nickname;?> / <?php if('0' === $uvu->user_grade){echo lang('Ordinary').lang('Member');}else{echo lang('Senior').lang('Member');}?>
						<br>
						<?php echo lang('Certification').': ';
						if('1' === $uvu->iscompany) echo lang('Company');
						if('1' === $uvu->mobile_checked) echo lang('Mobile');
						if('1' === $uvu->email_checked) echo lang('Email');
						?>
						<br>
						<?php echo lang('Local positon').': ';
						if($uvu->province && isset($areas[$uvu->province])) echo $areas[$uvu->province];
						if($uvu->city && isset($areas[$uvu->city])) echo ' - '.$areas[$uvu->city];
						?>
					<?php					
					}?>
				</div>
				<div class="inline-block width25 floatleft">
					发送站内信
					<br>
					<?php
					if($this->session->userdata('uuid') && isset($task->uuid) && $this->session->userdata('uuid') == $task->uuid)
					{?>
						<a href="#" class="ui-btn ui-mini ui-btn-inline guanzhu">重点关注</a>
					<?php
					}?>
				</div>
			</div>
		</div>
		<div class="ui-content">
			<div class="collapsible">
			  <a onclick="$('#ajax_task_product<?php echo $k;?>').fadeToggle()" class="ui-btn ui-mini"><?php echo "<strong>".lang('Info')."</strong>";?>:</a>
			  <div class="ui-collapsible-content ui-collapsible-content-collapsed" id="ajax_task_product<?php echo $k;?>">
				<?php if($v->content){echo $v->content;}else{echo '很懒,没有留下任务信息。';}?>
			  </div>
			</div>
		</div>
<?php
	}
}?>
	<!--./intention-->
<div class="ui-content">
	<?php
	if($this->session->userdata('uuid'))
	{?>
		<form action="<?php echo site_url('taskcomment/ajaxtaskcomment').'/'.$task->task_uuid;?>" name="task_comment_form" id="task_comment_form" method="post">
			<div class="floatleft width100">
				<div class="inline-block width20 floatleft">
					<?php
					if($this->session->userdata('avatar'))
					{
						$pic = static_url('uploadfile/image/user').'/100_'.$this->session->userdata('avatar');
					}else{
						$pic = static_url('public/images/avatar.jpg');
					}
					?>
					<img src="<?php echo $pic;?>" class="max_width95">
				</div>
				<div class="inline-block width80 floatleft websize">
					<textarea name="content" id="content" class="width100" required min="5" max=""></textarea>
				</div>
			</div>
			<div class="floatright">
				<input type="hidden" name="parent" value='0'>
				<input type="submit" name="submit" value="发布">
			</div>
		</form>
	<?php
	}else{
	echo "<p class='text_align_center' id='message_login'>请[<a href='".site_url('user/login')."'>".lang('Sign in')."</a>]后评论<br>还未账号？请先[<a href='".site_url('user/reg')."'>".lang('Sign up')."</a>]</p>";
	}?>
</div>
<!--./comment form-->
<?php
if($comments['data'])
{
	$k = 0;
	foreach($comments['data'] as $k=>$v)
	{
		$k++;
	?>
		<div class="ui-content bm_line_dashed paddingbottom0">
			<div class="floatleft width100">
				<div class="inline-block width20 floatleft">
					<?php
					if(isset($users[$v->uuid]) && $users[$v->uuid]->user_pic)
					{
						$pic = static_url('uploadfile/image/user').'/100_'.$users[$v->uuid]->user_pic;
					}else{
						$pic = static_url('public/images/avatar.jpg');
					}
					?>
					<img src="<?php echo $pic;?>" class="max_width95">
				</div>
				<div class="inline-block width80 floatleft websize">
					<div class="inline-block">
						<?php
						if(isset($users[$v->uuid]) && $uvu = $users[$v->uuid])
						{?>
							<?php echo $uvu->nickname;?> [<?php if('0' === $uvu->user_grade){echo lang('Ordinary').lang('Member');}else{echo lang('Senior').lang('Member');}?>]
							<?php
							if($uvu->province && isset($areas[$uvu->province])) echo $areas[$uvu->province];
							//if($uvu->city && isset($areas[$uvu->city])) echo ' - '.$areas[$uvu->city];
							?>
							<br>
							<?php echo $v->content;
							?>
						<?php					
						}?>
					</div>
					<div class="inline-block floatright">
						<br>
						<?php
						$time = time()-$v->create_time;
						if($time < 60){ echo $time.'秒前';}elseif($time < 3600){echo intval($time/60).'分前';}elseif($time < 86400){echo intval($time/3600).'小时前';}elseif($time < 31536000){echo intval($time/86400).'天前';}else{echo '很久';}
						?>
					</div>
				</div>
			</div>
			<div class="floatright">
				<a href="<?php echo site_url('taskupdown/ajaxtaskupdown').'/'.$v->comment_uuid.'/'.$task->task_uuid.'/1';?>" class="websize">顶(<?php echo $v->up;?>)</a>
				<a href="<?php echo site_url('taskupdown/ajaxtaskupdown').'/'.$v->comment_uuid.'/'.$task->task_uuid.'/0';?>" class="websize">踩(<?php echo $v->down;?>)</a>
				<a href="<?php echo site_url('taskcomment/ajaxtaskcomment').'/'.$task->task_uuid.'/'.$v->comment_uuid;?>" class="websize">回复</a>
			</div>
		</div>
			
<?php
	}
}?>
<!--./comment-->