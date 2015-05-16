
<div data-role="page" data-dialog="true" tabindex="0" class="ui-page ui-page-theme-a ui-dialog ui-page-active">
	<div role="dialog" class="ui-overlay-shadow ui-corner-all">
		<div data-role="header" data-theme="a" role="banner" class="ui-header ui-bar-a">
			<a href="<?php echo site_url('cooperation/show/').'/'.$task_uuid;?>" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-notext ui-btn-left"<?php if('2' !== $intented){echo 'data-rel="back"';}else{echo 'data-ajax="false"';}?>>Close</a>
			<h1 class="ui-title" role="heading" aria-level="1"><?php echo lang('Intention');?></h1>
		</div>
		<div role="main" class="ui-content">		
			<?php
			if('1' === $intented)
			{
				echo '您已提交过意向';
			}
			elseif('2' === $intented)
			{
				echo '您已成功提交意向';
			}
			elseif('3' === $intented)
			{
				echo $error;
			}
			else
			{?>
				<form action = "<?php echo site_url('intention/ajaxtaskintention/').'/'.$task_uuid;?>" method="post" id="task_intention_form" name="task_intention_form">
					<label for="intention_content">内容</label>
					<textarea name="content" id="intention_content" required min="5" max="255"></textarea>
					<input type="submit" name="submit" value="提交">
				</form>
			<?php
			}?>
		</div>
	</div>
</div>