
<div data-role="page" data-dialog="true" tabindex="0" class="ui-page ui-page-theme-a ui-dialog ui-page-active">
	<div role="dialog" class="ui-overlay-shadow ui-corner-all">
		<div data-role="header" data-theme="a" role="banner" class="ui-header ui-bar-a">
			<a href="<?php echo site_url('cooperation/show/'.'/'.$task_uuid);?>" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-notext ui-btn-left" <?php if($created){echo 'data-rel="back"';}else{echo 'data-ajax="false"';}?>>Close</a>
			<h1 class="ui-title" role="heading" aria-level="1">顶踩</h1>
		</div>
		<div role="main" class="ui-content">		
			<?php
			$str = $updown?'顶':'踩';
			if($created){echo '您已'.$str.'过此评论';}else{echo $str.'成功';}?>
		</div>
	</div>
</div>