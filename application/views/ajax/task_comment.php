<div data-role="page" data-dialog="true" tabindex="0" class="ui-page ui-page-theme-a ui-dialog ui-page-active">
	<div role="dialog" class="ui-overlay-shadow ui-corner-all">
		<div data-role="header" data-theme="a" role="banner" class="ui-header ui-bar-a">
			<a href="<?php echo site_url('cooperation/show/').'/'.$task_uuid;?>" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-notext ui-btn-left"<?php if('2' !== $created){echo 'data-rel="back"';}else{echo 'data-ajax="false"';}?>>Close</a>
			<h1 class="ui-title" role="heading" aria-level="1"><?php echo lang('Intention');?></h1>
		</div>
		<div role="main" class="ui-content">		
			<?php
			if('2' === $created)
			{
				echo '您已成功提交留言';
			}
			elseif('1' === $created)
			{
				echo validation_errors();
			}
			else
			{?>
				<form action="<?php echo site_url('taskcomment/ajaxtaskcomment').'/'.$task_uuid;?>" name="task_comment_forms" id="task_comment_forms" method="post">
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
						<input type="hidden" name="parent" value='<?php echo $parent;?>'>
						<input type="submit" name="submit" value="发布">
					</div>
				</form>
			<?php
			}?>
		</div>
	</div>
</div>