<div data-role="main" class="ui-content  pd0" id="about">
	<div data-role="tabs" id="tabs" class="paddingtop0">
		<div data-role="navbar"  class="fixd_1 paddingtop0">
			<ul id="tab">
				<li><a href="#aboutusinfo" data-ajax="false"><?php echo $data->title;?></a></li>
				<li><a href="<?php echo site_url('single/ajaxshow/1');?>" data-ajax="false">公司简介</a></li>
				<li><a href="<?php echo site_url('single/ajaxshow/4');?>" data-ajax="false">联系我们</a></li>
			</ul>
		</div>
		
		<div id="aboutusinfo" class="ui-body-d ui-content">
			<?php echo $data->content;?>
		</div>
	</div>
</div>