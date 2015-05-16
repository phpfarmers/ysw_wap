<div class="ui-grid-a ui-content">
	<div class="inline-block width25 floatleft">
		<img src="<?php echo static_url('uploadfile/image/product').'/'.$data->product_icon;?>" width="95%">
	</div>
	<div class="inline-block width75 floatleft text_1">
		<p><?php echo "<b>".lang('Name')."</b>";?>: <?php echo $data->product_name;?></p>		
		<p><?php echo "<b>".lang('Platform')."</b>";?>: <?php echo $platform;?></p>		
		<p><?php echo "<b>".lang('Type')."</b>";?>
			: 
			<?php
			echo $type[$data->radio1].','.$type[$data->radio2];
			if( $strtype = $data->product_type)
			{
				if(strpos($strtype,','))
				{
					$typearr = explode(',',$strtype);
					for( $i =0; $i < count($typearr); $i++)
					{
						if(isset($type[$typearr[$i]])) echo ','.$type[$typearr[$i]];
					}
				}
				else
				{
					if(isset($type[$strtype])) echo ','.$type[$strtype];
				}
			}
			?>
		</p>
		<p><?php echo "<strong>".lang('Single')."</strong>";?>: <?php if($data->single_type){ echo lang('Yes');}else{echo lang('No');}?>
			<?php
			if($data->product_theme)
			{?>
		</p>
		<p><?php echo "<strong>".lang('Theme')."</strong>";?>: <?php echo $data->product_theme;?>
			<?php
			}
			if($data->product_style)
			{?>
		</p>
		<p><?php echo "<strong>".lang('Styles')."</strong>";?>: <?php echo $data->product_style;?>
			<?php
			}?>
		</p>
		<p><?php echo "<strong>".lang('Company')."</strong>";?>: <?php echo $data->company_name;?></p>
	</div>
</div>
<div class="ui-content">
	<div class="collapsible">
	  <a onclick="$('#ajax_task_product').fadeToggle()" class="ui-btn ui-mini"><?php echo "<strong>".lang('Info')."</strong>";?>:</a>
	  <div class="ui-collapsible-content ui-collapsible-content-collapsed" id="ajax_task_product">
		<?php echo $data->product_info;?>
	  </div>
	</div>
</div>