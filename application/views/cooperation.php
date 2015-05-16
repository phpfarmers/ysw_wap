<section role="main" class="ui-content paddingtop0 paddingleft0 paddingright0">
	<nav data-role="navbar" id="task_header_nav "  class="fixd_1">
		<ul id="tab">
			<li><a <?php echo $orderby_link['new'];?>><?php echo lang('Time');?></a></li>
			<li><a <?php echo $orderby_link['intents'];?>><?php echo lang('Intention');?></a></li>
			<li><a <?php echo $orderby_link['amount'];?>><?php echo lang('Price');?></a></li>
			<li><a href="#" class="jqm-filter-link"><?php echo lang('More');?></a></li>
		</ul>
	</nav>
	<div class="bgf4f4f4 pt50 height1"></div>
	<ul data-role="listview" data-inset="true" data-icon='' id="listview_on_icon">
		<?php
		if($data)
		{
			foreach($data as $k=>$v)
			{
		?>
		<li class="list_text">
			<a href="<?php echo site_url('/cooperation/show/'.$v->task_uuid);?>" data-ajax="false">   
				<h2><?php echo highlight_phrase($v->title,$keywords,'<span class="webcolor">', '</span>');?></h2>
				<p class="color999"><?php echo $v->views.lang('Person').lang('Views');?> | <?php echo "<span class='webcolor'>".$v->intents."</span>".lang('Person').lang('Have').lang('Intention');?></p>
				<p class="ui-li-aside color999">
					<br />
					<?php if(isset($target_name[$v->task_target_id]) && $target_name[$v->task_target_id]) echo $target_name[$v->task_target_id];?>
					<br />
					<span class="webcolor">￥<?php echo $v->amount;?></span>
				</p>
			</a>
		</li>
		<?php
			}
		}?>
	</ul>
	<?php echo $this->pagination->create_links();?>
</section>
<!--./content-->

<section data-role="panel" class="jqm-filter-panel" data-position="right" data-display="overlay" data-theme="a" id="Folding_menu">
	<form method="post" action="<?php echo site_url('/cooperation/index');?>" id="taskform" name="taskform">
		<fieldset data-role="controlgroup" id="taskall" data-iconpos="right" data-mini="true">	
			<label for="all" id="labelall"><?php echo lang('All');?></label>
			<input type="checkbox" name="all" id="all" value="1" data-mini="true">
		</fieldset>
		<div data-role="collapsible" data-iconpos="right" data-collapsed="true" data-collapsed-icon="arrow-u" data-expanded-icon="arrow-d" data-inset="false" data-mini="true" data-theme="a">
			<h4><?php echo lang('Platform');?></h4>	
			<fieldset data-role="controlgroup" id="platform">
			<?php if(isset($platform_list[0]) && $platform_list[0])
			{
				foreach($platform_list[0] as $k=>$v)
				{?>
				<label for="platform<?php echo $k;?>"><?php echo $v;?></label>
				<input type="radio" name="platform" id="platform<?php echo $k;?>" value="<?php echo $k;?>" data-mini="true">
					<?php
					if(isset($platform_list[$k]) && $platform_list[$k])
					{?>
						<div class="innerdiv radios hidden show_platform<?php echo $k;?>" id="show_platform<?php echo $k;?>">
						<?php
						foreach($platform_list[$k] as $key=>$val)
						{?>
								<span rel="<?php echo $key;?>" class="pointer">
									<?php echo $val;?>
								</span>
						<?php
						}?>
						</div>
			<?php	
					}
				}
			}?>
			</fieldset>
		</div>
		<div data-role="collapsible" data-iconpos="right" data-collapsed="true" data-collapsed-icon="arrow-u" data-expanded-icon="arrow-d" data-inset="false" data-mini="true" data-theme="a">
			<h4><?php echo lang('Cooperation');?></h4>
			<fieldset data-role="controlgroup" id="target">
			<?php if(isset($target_list[0]) && $target_list[0])
			{
				foreach($target_list[0] as $k=>$v)
				{?>
				<label for="target<?php echo $k;?>"><?php echo $v->name;?></label>
				<input type="radio" name="target" id="target<?php echo $k;?>" value="<?php echo $k;?>" data-mini="true">
					<?php
					if(isset($target_list[$k]) && $target_list[$k])
					{?>
						<div class="innerdiv radios hidden show_target<?php echo $k;?>" id="show_target<?php echo $k;?>">
						<?php
						foreach($target_list[$k] as $key=>$val)
						{?>
								<span rel="<?php echo $key;?>" class="pointer">
									<?php echo $val->name;?>
								</span>
						<?php
						}?>
						</div>
			<?php	
					}
				}
			}?>
			</fieldset>
		</div>
		<div data-role="collapsible" data-iconpos="right" data-collapsed="true" data-collapsed-icon="arrow-u" data-expanded-icon="arrow-d" data-inset="false" data-mini="true" data-theme="a">
			<h4><?php echo lang('Progect');?></h4>
			<ul data-role="listview">
				<li>
					<?php
					if(isset($type_list['radio1']) && $type_list['radio1'])
					{
						foreach($type_list['radio1'] as $k=>$v)
						{
					?>
							<span class="pointer radio1" rel="<?php echo $v['id'];?>">
								<?php echo $v['name'];?>
							</span>
					<?php
						}
					}?>
				</li>
				<li>
					<?php
					if(isset($type_list['radio2']) && $type_list['radio2'])
					{
						foreach($type_list['radio2'] as $k=>$v)
						{
					?>
							<span class="pointer radio2" rel="<?php echo $v['id'];?>">
								<?php echo $v['name'];?>
							</span>
					<?php
						}
					}?>
				</li>
				<li>	
					<fieldset data-role="controlgroup" data-mini="true">
						<?php
						if(isset($type_list['typename']) && $type_list['typename'])
						{
							foreach($type_list['typename'] as $k=>$v)
							{
						?>
								<label for="ftype_<?php echo $v['id'];?>"><?php echo $v['name'];?></label>
								<input name="type[]" id="ftype_<?php echo $v['id'];?>" type="checkbox" value="<?php echo $v['id'];?>" data-inline="true">
						<?php
							}
						}?>
					</fieldset>
				</li>
			</ul>
		</div>
		<input type="submit" data-inline="true" data-mini="true" value="提交" id="btn_1">
	</form>
</section>
<!-- ./panel filter right-->
