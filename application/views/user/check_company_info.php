<!--研发公司团队图片 start-->
<input name="company_uuid" type="hidden" value="<?php echo $company_uuid;?>" class="user_input rd_ke"/>
<div class="user_form_line">
		<span class="with_180">研发公司/团队的图片：</span>
		<span><img id="viewimg" width="80px" src="<?php if($company_pic){echo static_url('uploadfile/image/company/'.$company_pic);}else{echo static_url('public/images/huitx.jpg');}?>"></span>
		<span style="text-align:left; font-size:14px; color:#999; line-height:55px;"> <input name="company_pic" type="file" id="company_pic" size="40" onchange="javascript:setImagePreview('company_pic','viewimg','80px','80px');"  <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 
		<p>仅支持JPG/GIF/PNG格式，文件大小3M，建议180*180px。</p>
		</span>
</div>
<!--研发公司团队图片 end-->
<!--style start-->
<div class="user_form_line show">
	   <span class="with_180"><em>*</em>研发公司/团队类型：</span>
	   <span style="width:720px;">
		<?php
		$types = explode(',',$company_type);
		foreach($company_types as $row)
		{
			if(isset($row['childs']))
			{
				echo '<label class="show_s" style="padding-left:5px;" id="show_'.$row['id'].'"><input name="company_type[]" value="'.$row['id'].'" type="checkbox" disabled="disabled"/> '.$row['name'].' </label>';
				echo '<div class="show_'.$row['id'].'" style="width:700px;float:left;background:#f1f1f1;display:none;padding:0px 10px;">';
				foreach($row['childs'] as $rows)
				{
					if(in_array($rows['id'],$types))
					{
						if($company_uuid != '')
						{
							echo '<label><input name="company_type[]" value="'.$rows['id'].'" type="checkbox" checked="checked" disabled="disabled"/> '.$rows['name'].' </label>';
						}
						else
						{
							echo '<label><input name="company_type[]" value="'.$rows['id'].'" type="checkbox" checked="checked"/> '.$rows['name'].' </label>';
						}
					}
					else
					{
						if($company_uuid != '')
						{
							echo '<label><input name="company_type[]" value="'.$rows['id'].'" type="checkbox" disabled="disabled"/> '.$rows['name'].' </label>';
						}
						else
						{
							echo '<label><input name="company_type[]" value="'.$rows['id'].'" type="checkbox"/> '.$rows['name'].' </label>';
						}
					}
				}
				echo '</div>';
			}
			else
			{
				if(in_array($row['id'],$types))
				{
					if($company_uuid != '')
					{
						echo '<label style="padding-left:5px;"><input name="company_type[]" value="'.$row['id'].'" type="checkbox" checked="checked" disabled="disabled"/> '.$row['name'].' </label>';
					}
					else
					{
						echo '<label style="padding-left:5px;"><input name="company_type[]" value="'.$row['id'].'" type="checkbox" checked="checked"/> '.$row['name'].' </label>';
					}
				}
				else
				{
					if($company_uuid != '')
					{
						echo '<label style="padding-left:5px;"><input name="company_type[]" value="'.$row['id'].'" type="checkbox" disabled="disabled"/> '.$row['name'].' </label>';
					}
					else
					{
						if($row['name'] == '研发商')
						{
							echo '<label style="padding-left:5px;"><input name="company_type[]" value="'.$row['id'].'" type="checkbox" checked="checked"/> '.$row['name'].' </label>';
						}
						else
						{
							echo '<label style="padding-left:5px;"><input name="company_type[]" value="'.$row['id'].'" type="checkbox"/> '.$row['name'].' </label>';
						}
						
					}
				}
			}
		}
		?>
	   </span>
</div>
<script type="text/javascript">
$(document).ready(function (){
	// 默认显示、隐藏
	var id = $('.show_s').attr('id');
	var num = $("."+id+" input[name='company_type[]']:checked").length;
	if(num > 0)
	{
		$('#'+id).find('input').prop('checked','checked');
		$('.'+id).show();
	}
	else
	{
		$('#'+id).find('input').removeAttr('checked');
		$('.'+id).hide();
	}

	// 判断已选择数量控制显示、隐藏
	$('.'+id+' label').click(function(){
		var num = $("."+id+" input[name='company_type[]']:checked").length;
		if(num > 0)
		{
			$('#'+id).find('input').prop('checked','checked');
			$('.'+id).show();
		}
		else
		{
			$('#'+id).find('input').removeAttr('checked');
			//$('.'+id).hide();
		}
	});

	// 移除显示、隐藏
	$('.'+id).hover(function(){
		$(this).show();
	},function(){
		var num = $("."+id+" input[name='company_type[]']:checked").length;
		if(num > 0)
		{
			$(this).show();
		}
		else
		{
			$(this).hide();
		}
	});

	// 鼠标移动二级类型显示、隐藏
	$('.show_s').hover(function(){
		$('.'+id).show();
	},function(){
		var num = $("."+id+" input[name='company_type[]']:checked").length;
		if(num > 0)
		{
			$('.'+id).show();
		}
		else
		{
			$('.'+id).hide();
		}
	});

})
</script>
<!--style end-->
<!--团队规模 start-->
<div class="user_form_line">
	   <span class="with_180"><em>*</em>研发公司/团队规模：</span>
	   <span>
		   <div style=" width:600px;">
				<label><input name="company_size" type="radio" value="0" <?php if($company_size == 0 ){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 1-10人 </label>
				<label><input name="company_size" type="radio" value="1" <?php if($company_size == 1 ){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 11-20人 </label>
				<label><input name="company_size" type="radio" value="2" <?php if($company_size == 2 ){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 21-50人 </label>
				<label><input name="company_size" type="radio" value="3" <?php if($company_size == 3 ){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 50-100人 </label> 
				<label><input name="company_size" type="radio" value="4" <?php if($company_size == 4 ){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 101-200人 </label>
				<label><input name="company_size" type="radio" value="5" <?php if($company_size == 5 ){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 200-500人 </label>
				<label><input name="company_size" type="radio" value="6" <?php if($company_size == 6 ){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 500人以上 </label>
			</div>
		</span>
</div>
<!--团队规模 end-->
<script  language="JavaScript">
<?php if(isset($province)):?>
	var province = <?php echo (int)$province?>;
<?php else:?>
	var province = 0;
<?php endif?>

<?php if(isset($city)):?>
	var city = <?php echo (int)$city?>;
<?php else:?>
	var city = 0;
<?php endif?>
$(document).ready(function() {
	var change_city = function(){
	$.ajax({
		url: '<?php echo site_url('region/index/parent')?>'+'/'+$('#province').val(),
		type: 'GET',
		dataType: 'html',
		success: function(data){
			city_json = eval('('+data+')');
			var city = document.getElementById('city');
			city.options.length = 0;
				for(var i=0; i<city_json.length; i++){
				var len = city.length;
				city.options[len] = new Option(city_json[i].name, city_json[i].id); 
					if (city.options[len].value == city){
						city.options[len].selected = true;
					}
				}
			}
		});
	}
	$('#province').change(function(){
		change_city();
	});
});
</script>
<div class="user_form_line">
	   <span class="with_180"><em>*</em>研发公司/团队地址：</span>
	   <span>
			<select name="province" id="province" class="user_select" <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>>
				<?php foreach($provinces as $row):?>
				<option value="<?php echo $row['id'];?>" <?php if($row['id']==$province){echo 'selected';}?> ><?php echo $row['name']; ?></option>
				<?php endforeach; ?>
			</select>
			<select name="city" id="city" class="user_select" <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>>
				<?php foreach($citys as $rows): ?>
				<option value="<?php echo $rows['id']; ?>" <?php if($rows['id'] == $city){echo 'selected';}?> ><?php echo $rows['name']; ?></option>
				<?php endforeach; ?>
			</select>
	  </span>
</div>
<div class="user_form_line">
		<span class="with_180">研发公司/团队介绍：</span> 
		<span><textarea name="company_desc" rows="7" cols="50" class="suggtext com_text" <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>><?php echo $company_desc;?></textarea></span> 
</div>
<!--选填部分--详细资料 start-->
<div class="user_form_line com_xxi">
			  <div><input type="button" onclick="document.getElementById('com_zliao').style.display=document.getElementById('com_zliao').style.display==''?'none':''" value="添加更多详细资料" class="addzil"><img src="<?php echo static_url('public/images/jiantou1.png');?>" /> 
			  </div> 

			  <div id="com_zliao" style="display:none">
				   <div class="user_form_line">
						 <span class="with_180">公司/团队的详细地址：</span>
						 <span><input name="company_address" type="text" value="<?php echo $company_address;?>" class="user_input rd_ke" <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/></span>
				   </div> 
				   <div class="user_form_line">
						 <span class="with_180">公司/团队的官网/微博：</span>
						 <span><input name="company_web" type="text" value="<?php echo $company_web;?>" class="user_input rd_ke" <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/></span>
				   </div>
				   <div class="user_form_line">
						 <span class="with_180">公司/团队联系电话：</span>
						 <span><input name="company_phone" type="text" value="<?php echo $company_phone;?>" class="user_input rd_ke" <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/></span>
				   </div>
				   <div class="user_form_line">
						 <span class="with_180">公司/团队联系邮箱：</span>
						 <span><input name="company_email" type="text" value="<?php echo $company_email;?>" class="user_input rd_ke" <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/></span>
				   </div>
				   <div class="clear"></div>
			  </div>
  </div>
 <!--选填部分--详细资料 end-->  