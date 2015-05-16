<div role="main" class="ui-content  pd0">
	<div data-role="controlgroup" data-inset="true" data-type="horizontal" id="article_cat_list">
		<?php
		if(isset($category) && $category)
		{
			foreach($category as $k=>$v)
			{?>
				<a href="<?php echo $category_link.'/category/'.$v->id;?>" data-ajax="true" data-role="button"><?php echo $v->name;?></a>
		<?php
			}
		}?>
	</div>
</div>
<div class="bgf4f4f4 height1"></div>
	<?php
	if(isset($data['data']) && $data['data'])
	{?>
		<div class="ui-body-d ui-content paddingleft0 paddingright0 paddingtop0">
			<ul data-role="listview" data-inset="true" data-icon='' id="listview_on_icon">
				<?php
					foreach($data['data'] as $key=>$val)
					{?>
						<li  class="listbg_1">
							<a href="<?php echo site_url('/information/show/'.$val->article_uuid);?>" data-ajax="true">
								<div class="article_date">
									<span class="large"><?php echo date('d',$val->create_time);?></span>
									<span class="small"><?php echo date('Y/m',$val->create_time);?></span>
								</div>
								<div class="listbg_1_div">
									<h2><?php echo highlight_phrase($val->title,$keywords,'<span class="webcolor">', '</span>');?></h2>
									<p><?php echo highlight_phrase($val->summary,$keywords,'<span class="webcolor">', '</span>');?></p>
								</div>
							</a>
						</li>

				<?php
					}
				?>
			</ul>
			<?php echo $this->pagination->create_links();?>
		</div>
	<?php 
	}?>