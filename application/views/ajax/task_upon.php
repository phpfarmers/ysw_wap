
<div data-role="page" data-dialog="true" tabindex="0" class="ui-page ui-page-theme-a ui-dialog ui-page-active">
	<div role="dialog" class="ui-overlay-shadow ui-corner-all">
		<div data-role="header" data-theme="a" role="banner" class="ui-header ui-bar-a">
			<a href="#" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-notext ui-btn-left" data-rel="back">Close</a>
			<h1 class="ui-title" role="heading" aria-level="1">点赞</h1>
		</div>
		<div role="main" class="ui-content">		
			<?php
			if($uponed){echo '您已赞过';}else{echo '点赞成功';}?>
		</div>
	</div>
</div>