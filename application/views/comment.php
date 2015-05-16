<?php
if(!empty($comment))
{
	foreach($comment as $row): 
?>
	<div class="newlist_dlu_b">
		<div class="newlist_alf"><img src="<?php if($row['user_pic']){echo static_url('uploadfile/image/user/100_'.$row['user_pic']);}else{echo static_url('public/images/cardd.jpg');}?>" width="80" height="80"></div>
		<div class="newlist_art">
			<div class="ft new_us"><span class="new_c"><?php echo $row['nickname'];?></span> <span class="new_v">[<?php if($row['user_grade'] == 0){echo '普通会员';}elseif($row['user_grade'] == 1){echo '中级会员';}elseif($row['user_grade'] == 2){echo '高级会员';}?>]</span>&nbsp;&nbsp;<?php echo $row['province'];?></div> 
			<div class="gt new_hui">
			<?php
			$times = strtotime(date("Y-m-d H:i:s"))- $row['create_time'];
			if($times < 60)
			{
				echo $times.'秒前';
			}
			elseif($times >= 60 && $times < 3600)
			{
				echo floor($times/60).'分钟前';
			}
			elseif($times >= 3600 && $times < 86400)
			{
				echo floor($times/3600).'小时前';
			}
			elseif($times >= 86400 && $times < 2592000)
			{
				echo floor($times/86400).'天前';
			}
			elseif($times >= 2592000 && $times < 31536000)
			{
				echo floor($times/2592000).'月前';
			}
			else
			{
				echo floor($times/31536000).'年前';
			}
			?>
			</div>
			<div class="clear"></div>
			<p><?php echo parse_smileys($row['content'],static_url('public/smileys/'));?></p>
			<div class="new_dc">
				<span><a href="JavaScript:void(0);" id="up_<?php echo $row['comment_uuid'];?>" onclick="num('<?php echo $row['comment_uuid'];?>','up')">顶</a> (<em id="up_num_<?php echo $row['comment_uuid'];?>"><?php echo $row['up'];?></em>)</span>
				<span><a href="JavaScript:void(0);" id="down_<?php echo $row['comment_uuid'];?>" onclick="num('<?php echo $row['comment_uuid'];?>','down')">踩</a> (<em id="down_num_<?php echo $row['comment_uuid'];?>"><?php echo $row['down'];?></em>)</span>
				<?php if(UUID !=''){?>
				<span><a href="JavaScript:void(0);" id="<?php echo $row['comment_uuid'];?>" class="new_huifu add_reply" onclick="add_reply(id)">回复</a></span>
				<?php }else{?>
				<span><a href="JavaScript:void(0);" id="comment" class="new_huifu add_reply" onclick="animate(id)">回复</a></span>
				<?php }?>
			</div>
			<!-- 回复 -->
			<div class="reply" id='reply<?php echo $row['comment_uuid'];?>' style="display:none"></div>
			<!-- 评论 -->
			<?php if(isset($row['childs'])){?>
				<div class="clear"></div>
				<?php foreach($row['childs'] as $rows):?>
				<div class="newlist_sm">
					   <div class="ft newlist_sm_a"><img src="<?php if($rows['user_pic']){echo static_url('uploadfile/image/user/100_'.$rows['user_pic']);}else{echo static_url('public/images/cardd.jpg');}?>" width="60" height="60"></div>
					   <div class="gt newlist_sm_b">
						   <div class="ft new_us"><span class="new_c"><?php echo $rows['nickname'];?></span> <span class="new_v">[<?php if($rows['user_grade'] == 0){echo '普通会员';}elseif($rows['user_grade'] == 1){echo '中级会员';}elseif($rows['user_grade'] == 2){echo '高级会员';}?>]</span>&nbsp;&nbsp;<?php echo $rows['province'];?></div> 
						   <div class="gt new_hui">
							<?php
							$timess = strtotime(date("Y-m-d H:i:s"))- $rows['create_time'];
							if($timess < 60)
							{
								echo $timess.'秒前';
							}
							elseif($timess >= 60 && $timess < 3600)
							{
								echo floor($timess/60).'分钟前';
							}
							elseif($timess >= 3600 && $timess < 86400)
							{
								echo floor($timess/3600).'小时前';
							}
							elseif($timess >= 86400 && $timess < 2592000)
							{
								echo floor($timess/86400).'天前';
							}
							elseif($timess >= 2592000 && $timess < 31536000)
							{
								echo floor($timess/2592000).'月前';
							}
							else
							{
								echo floor($timess/31536000).'年前';
							}
							?>
							</div>
						   <div class="clear"></div>
						   <p><?php echo parse_smileys($rows['content'],static_url('public/smileys/'));?></p>
						   <div class="new_dc">
								<span><a href="JavaScript:void(0);" id="up_<?php echo $rows['comment_uuid'];?>" onclick="num('<?php echo $rows['comment_uuid'];?>','up')">顶</a> (<em id="up_num_<?php echo $rows['comment_uuid'];?>"><?php echo $rows['up'];?></em>)</span>
								<span><a href="JavaScript:void(0);" id="down_<?php echo $rows['comment_uuid'];?>" onclick="num('<?php echo $rows['comment_uuid'];?>','down')">踩</a> (<em id="down_num_<?php echo $rows['comment_uuid'];?>"><?php echo $rows['down'];?></em>)</span>
						   </div>
					   </div>
				</div>
				<div class="clear"></div>
				<?php endforeach; ?>
			<?php } ?>
		</div>
		<div class="clear"></div>
	</div>
<?php 
	endforeach;
}
?>