<section role="main" class="ui-content paddingleft0 paddingright0 paddingtop0 bgf4f4f4">
	<ul data-role="listview" data-inset="true" data-icon="" id="listview_on_icon">
		<li data-role="divider">
			<?php echo lang('Latest').lang('Cooperation');?>
		</li>
		<?php if(isset($new_task) && $new_task)
		{
			foreach($new_task as $k=>$v)
			{?>
		<li class="listbg">
            <a href="<?php echo site_url('/cooperation/show/'.$v->task_uuid);?>" data-ajax="false"  >
				<img src="<?php echo static_url('/uploadfile/image/product/'.$v->product_icon);?>">
				<h2><?php echo $v->name;?></h2>
				<p><?php echo $v->title;?></p>
			</a>
		</li>
		<?php
			}
		}?>
	</ul>
	<!--/newest task-->
	<ul data-role="listview" data-inset="true" data-icon="" id="listview_on_icon">
		<li data-role="divider">
			<?php echo lang('Recommend').lang('Article');?>
		</li>
		<?php if(isset($hot_news) && $hot_news)
		{
			foreach($hot_news as $k=>$v)
			{?>
		<li  class="listbg_1">
			<a href="<?php echo site_url('/information/show/'.$v->article_uuid);?>" data-ajax="false">
				<div class="article_date">
					<span class="large"><?php echo date('d',$v->create_time);?></span>
					<span class="small"><?php echo date('Y/m',$v->create_time);?></span>
				</div>
				<div class="listbg_1_div">
					<h2><?php echo $v->title;?></h2>
					<p><?php echo $v->summary;?></p>
				</div>
			</a>
		</li>
		<?php
			}
		}?>
	</ul>
	<!--/newest task-->
</section>
<!--/content-->
