<div class="main">
<style type="text/css">
/********** 自动匹配弹出框样式 start **********/
.autobox{font:normal normal normal 14px/30px 微软雅黑;background:#FFFFFF;border:#CCCCCC 1px solid;position:absolute;top:38px;left:0px;width:720px;z-index:811213;z-index:10;}
.autolist{width:100%;margin:0px;padding:0px;}
.autolist ul{margin:0px;padding:0px;list-style:none;}
.autolist ul li{margin:0px;padding:0px 10px;cursor:pointer;text-align:left;}
.autolist ul li:hover{background-color:#659CD8;color:#FFFFFF;}
/********** 自动匹配弹出框样式 start **********/
</style>
	<div class="append">
      <h1>添加产品</h1>
      <div class="app_nav2"> </div>
      <div class="app_con">
      		<h2>注<span style=" color:#F00;">*</span>为必填项</h2>
			<script type="text/javascript">
				function lookup(str) {
					if($.trim(str).length != 0) { // 文本框输入内容不为空时
						$.post('<?php echo site_url('user/check/Check_company_list'); ?>' + '/' + str, function(data){
							if(data.length >0) { // 返回值不为空时
								$('#auto').show();
								$('#autolist').html(data);
							}
							else
							{ // 返回值为空时
								$('#auto').hide();
								$.post('<?php echo site_url('user/check/Check_company_info'); ?>' + '/', function(data){
									if(data.length >0) {
										$('#company_info').html(data);
									}
								});
							}
						});
					}else{
						$('#auto').hide();
						$.post('<?php echo site_url('user/check/Check_company_info'); ?>' + '/', function(data){
							if(data.length >0) {
								$('#company_info').html(data);
							}
						});
					}
				}

				function fill(value,id) {
					//alert(value.replace('未审核'));
					$('#str').val(value);
					setTimeout("$('#auto').hide();", 200);
					
					$.post('<?php echo site_url('user/check/Check_company_info'); ?>' + '/' + id, function(data){
						if(data.length >0) {
							$('#company_info').html(data);
						}
					});
				}

				//鼠标失去焦点操作
				function hove()
				{
					if('block' == $('#auto').css('display'))
					{
						var str = $('#str').val();
						$('#autolist li').each(function(){
							arr=$(this).html().split(' (未审核)');
							if(str == arr[0])
							{
								var aa = $(this).attr('onclick');
								eval(aa);
								return true;
							}
						});
					}
				}

				function move(value)
				{					
					if('block' == $('#auto').css('display'))
					{
						fill();
						$('#str').val(value);
					}
				}
			</script>
			<?php echo form_open_multipart('user/check_company/index/'.$product_uuid.'/'.$company_uuid);?>
			<div style="color:red;"><?php echo validation_errors();?></div>
            <div class="user_form_line">
            		<span class="with_180"><em>*</em>研发公司/团队的名字：</span>
					<?php
					echo '<span style="position:relative;"><input name="company_name" original-title="" placeholder="请输入公司/团队名称，并在下拉菜单中选择" type="text" class="user_input add_input hcolor"';
					if($company_uuid !='')
					{
						echo 'value="'.$linked_company['company_name'].'"';
					}
					else
					{
						echo 'value=""';
					}
					echo 'id="str" onkeyup="lookup(this.value);" onmouseout="hove()" onblur="move(value)"/>';
					?>
					<div class="autobox" id="auto" style="display:none;">
						<div class="autolist" id="autolist">
						</div>
					</div>
					</span>
            </div>
			
			<div id="company_info">
			<input name="company_uuid" type="hidden" value="<?php echo $linked_company['company_uuid'];?>" class="user_input rd_ke"/>
            <!--研发公司团队图片 start-->
			<div class="user_form_line">
            		<span class="with_180">研发公司/团队的图片：</span>
                    <span><img id="viewimg" width="80px" src="<?php if($linked_company['company_pic']){echo static_url('uploadfile/image/company/'.$linked_company['company_pic']);}else{echo static_url('public/images/huitx.jpg');}?>"></span>
                    <span style="text-align:left; font-size:14px; color:#999; line-height:55px;"> <input name="company_pic" type="file" id="company_pic" size="40" onchange="javascript:setImagePreview('company_pic','viewimg','80px','80px',<?php echo static_url('public/images/huitx.jpg');?>);" <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 
	
                    <p>仅支持JPG/GIF/PNG格式，文件大小3M，建议180*180px。</p>
                    </span>
            </div>
            <!--研发公司团队图片 end-->
            <!--style start-->
			<div class="user_form_line show">
                   <span class="with_180"><em>*</em>研发公司/团队类型：</span>
                   <span style="width:720px;">
					<?php
					$types = explode(',',$linked_company['company_type']);
					foreach($company_type as $row)
					{
						if(isset($row['childs']))
						{
							echo '<label class="show_s" style="padding-left:5px;" id="show_'.$row['id'].'"><input name="company_type[]" value="'.$row['id'].'" type="checkbox" disabled="disabled" /> '.$row['name'].'</label>';
							echo '<div class="show_'.$row['id'].'" style="width:700px;float:left;background:#f1f1f1;display:none;padding:0px 10px;">';
							foreach($row['childs'] as $rows)
							{
								if(in_array($rows['id'],$types))
								{
									if($company_uuid != '')
									{
										echo '<label><input name="company_type[]" value="'.$rows['id'].'" type="checkbox" checked="checked" disabled="disabled"/> '.$rows['name'].'</label>';
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
									echo '<label style="padding-left:5px;"><input name="company_type[]" value="'.$row['id'].'" type="checkbox" checked="checked" disabled="disabled"/> '.$row['name'].'</label>';
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
									echo '<label style="padding-left:5px;"><input name="company_type[]" value="'.$row['id'].'" type="checkbox" disabled="disabled"/> '.$row['name'].'</label>';
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
                   			<label><input name="company_size" type="radio" value="0" <?php if($linked_company['company_size'] == 0){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 1-10人 </label>
                            <label><input name="company_size" type="radio" value="1" <?php if($linked_company['company_size'] == 1){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 11-20人 </label>
                            <label><input name="company_size" type="radio" value="2" <?php if($linked_company['company_size'] == 2){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 21-50人 </label>
                            <label><input name="company_size" type="radio" value="3" <?php if($linked_company['company_size'] == 3){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 50-100人 </label> 
                            <label><input name="company_size" type="radio" value="4" <?php if($linked_company['company_size'] == 4){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 101-200人 </label>
                            <label><input name="company_size" type="radio" value="5" <?php if($linked_company['company_size'] == 5){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 200-500人 </label>
                            <label><input name="company_size" type="radio" value="6" <?php if($linked_company['company_size'] == 6){echo 'checked="checked"';}?> <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/> 500人以上 </label>
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
                    <span><textarea name="company_desc" rows="7" cols="50" class="suggtext com_text" <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>><?php echo $linked_company['company_desc']?></textarea></span> 
            </div>
			<!--选填部分--详细资料 start-->
            <div class="user_form_line com_xxi">
                          <div class="pointer" onclick="document.getElementById('com_zliao').style.display=document.getElementById('com_zliao').style.display==''?'none':''"><input type="button" value="添加更多详细资料" class="addzil pointer"><img src="<?php echo static_url('public/images/jiantou1.png');?>" /> 
                          </div> 
                           
                          <div id="com_zliao" style="display:none">
                               <div class="user_form_line">
                               		 <span class="with_180">公司/团队的详细地址：</span>
                                     <span><input name="company_address" type="text" value="<?php echo $linked_company['company_address'];?>" class="user_input rd_ke" <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/></span>
                               </div> 
                               <div class="user_form_line">
                                     <span class="with_180">公司/团队的官网/微博：</span>
                                     <span><input name="company_web" type="text" value="<?php echo $linked_company['company_web'];?>" class="user_input rd_ke" <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/></span>
                               </div>
                               <div class="user_form_line">
                                     <span class="with_180">公司/团队联系电话：</span>
                                     <span><input name="company_phone" type="text" value="<?php echo $linked_company['company_phone'];?>" class="user_input rd_ke" <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/></span>
                               </div>
                               <div class="user_form_line">
                                     <span class="with_180">公司/团队联系邮箱：</span>
                                     <span><input name="company_email" type="text" value="<?php echo $linked_company['company_email'];?>" class="user_input rd_ke" <?php if($company_uuid != ''){echo 'disabled="disabled"';}?>/></span>
                               </div>
                               <div class="clear"></div>
                          </div>
              </div>
             <!--选填部分--详细资料 end--> 
			 </div>
             <!--选填部分--添加游戏制作人 start--> 
                <!--<div class="user_form_line com_xxi">
						  <input name="producer_uuid" type="hidden" value="<?php echo $linked_company['producer_uuid'];?>"/>
                          <div class="pointer" onclick="document.getElementById('com_zzr').style.display=document.getElementById('com_zzr').style.display==''?'none':''"><input type="button"  value="添加新的游戏制作人" class="addzil pointer"><img src="<?php echo static_url('public/images/jiantou1.png');?>" class="pointer" /> 
                          </div> 
                           
                          <div id="com_zzr" style="display:none">
                               <div class="user_form_line">
                               		 <span class="with_180">制作人姓名：</span>
                                     <span><input name="producer_name" type="text" value="<?php echo $linked_company['producer_name'];?>" class="user_input rd_ke"/></span>
                               </div> 
                               <div class="user_form_line">
                                     <span class="with_180">制作人照片：</span>
                                     <span><img id="previewimg" width="80px" src="<?php if($linked_company['producer_pic']){echo static_url('uploadfile/image/company/'.$linked_company['producer_pic']);}else{echo static_url('public/images/huitx.jpg');}?>"></span>
                                     <span style=" text-align:left; font-size:14px; color:#999; line-height:55px;"> <input name="producer_pic" type="file" id="producer_pic" size="40" onchange="javascript:setImagePreview('producer_pic','previewimg','80px','80px');" /> 
                                     <p>仅支持JPG/GIF/PNG格式，文件大小3M，建议180*180px。</p>
                                     </span>
                               </div>
                               <div class="user_form_line">
                                     <span class="with_180">制作人代表作：</span>
                                     <span><input name="producer_product" type="text" value="<?php echo $linked_company['producer_product'];?>" class="user_input rd_ke"/></span>
                               </div>
                               <div class="user_form_line">
                                     <span class="with_180">制作人简介：</span>
                                     <span><textarea name="producer_info" rows="7" cols="20" class="suggtext com_tarea"><?php echo $linked_company['producer_info'];?></textarea></span> 
                               </div>
                               <div class="clear"></div>
                          </div>
                </div>  -->   
                        
             <!--选填部分--添加游戏制作人 end-->          
              <!--选填部分--添加新的游戏合作代理商 start--> 
               <!-- <div class="user_form_line com_xxi">
						  <input name="agent_uuid" type="hidden" value="<?php echo $linked_company['agent_uuid'];?>"/>
                          <div class="pointer" onclick="document.getElementById('com_dls').style.display=document.getElementById('com_dls').style.display==''?'none':''"><input type="button" value="添加新的游戏合作代理商" class="addzil pointer"><img src="<?php echo static_url('public/images/jiantou1.png');?>" class="pointer" /> 
                          </div> 
                           
                          <div id="com_dls" style="display:none">
                               <div class="user_form_line">
                               		 <span class="with_180">代理公司名：</span>
                                     <span><input name="agent_name" type="text" value="<?php echo $linked_company['agent_name'];?>" class="user_input rd_ke"/></span>
                               </div> 
                               <div class="user_form_line">
                                     <span class="with_180">代理区域：</span>
                                     <span><?php $area = explode(',',$linked_company['agent_area']);?>
                                        <div style="width:460px;">
                                     	    <label><input name="agent_area[]" type="checkbox" value="国内" <?php if(in_array('国内',$area)){echo 'checked="checked"';} ?>/> 国内 </label>
                                            <label><input name="agent_area[]" type="checkbox" value="北美" <?php if(in_array('北美',$area)){echo 'checked="checked"';} ?>/> 北美 </label>
                                            <label><input name="agent_area[]" type="checkbox" value="南美" <?php if(in_array('南美',$area)){echo 'checked="checked"';} ?>/> 南美 </label>
                                            <label><input name="agent_area[]" type="checkbox" value="东南亚" <?php if(in_array('东南亚',$area)){echo 'checked="checked"';} ?>/> 东南亚 </label>
                                            <label><input name="agent_area[]" type="checkbox" value="日韩" <?php if(in_array('日韩',$area)){echo 'checked="checked"';} ?>/> 日韩 </label>
                                            <label><input name="agent_area[]" type="checkbox" value="西亚" <?php if(in_array('西亚',$area)){echo 'checked="checked"';} ?>/> 西亚 </label>
                                            <label><input name="agent_area[]" type="checkbox" value="非洲" <?php if(in_array('非洲',$area)){echo 'checked="checked"';} ?>/> 非洲 </label>
                                            <label><input name="agent_area[]" type="checkbox" value="欧洲" <?php if(in_array('欧洲',$area)){echo 'checked="checked"';} ?>/> 欧洲 </label>
                                            <label><input name="agent_area[]" type="checkbox" value="其他" <?php if(in_array('其他',$area)){echo 'checked="checked"';} ?>/> 其他 </label>
                                        </div>
                                     </span>
                               </div>
                               <div class="user_form_line">
                                     <span class="with_180">代理平台：</span>
                                     <span style="width:460px;">
									 <?php $platform = explode(',',$linked_company['product_platform']);?>
									 <?php $agent = explode(',',$linked_company['agent_platform']);?>
									<?php 
									foreach ($platform_list as $row){ 
										if(in_array($row->id,$platform))
										{
											if(in_array($row->id,$agent))
											{
												echo '<label><input id="agent_platform" type="checkbox" value="'.$row->id.'" name="agent_platform[]" checked="checked"/> '.$row->platform_name.'</label>';
											}
											else
											{
												echo '<label><input id="agent_platform" type="checkbox" value="'.$row->id.'" name="agent_platform[]"/> '.$row->platform_name.'</label>';
											}
										}
									}
									?></span>
                               </div>
                               <div class="clear"></div>
                          </div>
                </div>    --> 
                        
             <!--选填部分--添加游戏制作人 end-->             
             <div class="user_form_line prv2"><input name="" type="submit" value="确认添加" class="user_submit"/></div>
			 <?php echo form_close();?>
      </div>
        
	</div>
</div>