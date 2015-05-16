<div role="main" id="views_txt">
	<div class="ui-content paddingtop0">
		<a href="<?php echo site_url('information/index');?>" data-rel="back" class="ui-btn ui-icon-back ui-btn-icon-notext ui-corner-all ui-btn-inline" data-mini="true" id="back">
			Back
		</a>
		<h2 class="view_tit"><?php echo $article_info->title;?></h2>
		<p class="floatleft text_1">
			<span class="webcolor"><?php echo $article_info->author;?></span>
			<?php echo date('Y-m-d H:i',$article_info->open_time);?>
		</p>
		<p class="floatright text_1"><span class="greycolor"><?php echo lang('SN');?>:</span>N<?php echo $article_info->sn;?></p>
	</div>
	<div class="ui-body-d ui-content content_img paddingtop0">
		<?php echo $article_info->content;?>
	</div>
</div>