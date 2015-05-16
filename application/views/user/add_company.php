        <div class="user_right">
			<div class="user_right_title"><h2>我的公司</h2></div>
			<div class="user_right_content">
			<script type="text/javascript">
				function lookup(str)
				{
					if(str.trim().length != 0)
					{ // 文本框输入内容为空时
						$.post('<?php echo site_url('user/check/check_company'); ?>' + '/' + str, function(data){
							if(data.length > 0) { // 返回值不为空时
								$('.error').show();
								$('.error').html('此公司名称已存在,不可重复添加！');
								$('.user_submit').attr('type','button');
								$('.user_submit').css({"background":"#666666"});
							}
							else
							{
								$('.error').html('');
								$('.user_submit').attr('type','submit');
								$('.user_submit').css({"background":"#ff8a00"});
							}
						});
					}
				}
			</script>
				<?php echo form_open_multipart('user/company/add_company');?>
				<div style="color:red;"><?php echo validation_errors();?></div>
				<div class="user_form_addgs">
                		<div style=" text-align:right; margin-bottom:10px;">注意<span style=" color:#F00">*</span>为必填项</div>
                        <div class="user_form_line"><span class="add"><em>*</em>公司/团队的名字：</span><span><input name="company_name" type="text" value="<?php echo $company_name;?>" class="user_input" id="str" onkeyup="lookup(this.value);"/></span><div class="error"><?php echo form_error('company_name'); ?></div></div>

						<div class="user_form_line">
								<span class="add">公司/团队的图片：</span>
								<span><img id="viewimg" width="80px" src="<?php echo static_url('public/images/huitx.jpg');?>"></span>
								<span style=" text-align:left; font-size:14px; color:#999; line-height:55px;">
									<input type="file" name="company_pic" id="company_pic" onchange="javascript:setImagePreview('company_pic','viewimg','80px','80px','<?echo static_url('public/images/huitx.jpg')?>');">					
								<p>仅支持JPG/GIF/PNG格式，文件大小不超过200K，建议尺寸180*180px。</p>
								</span>
						</div>

				        <div class="user_form_line show"><span class="add">公司/团队类型：</span><span style="text-align:left;width:560px;">
						<?php
						foreach($company_type as $row)
						{
							if(isset($row['childs']))
							{
								echo '<label class="show_s" id="show_'.$row['id'].'"><input name="company_type[]" type="checkbox" value="'.$row['id'].'" class="addduo" disabled="disabled"/> '.$row['name'].'</label>';
								echo '<div class="show_s show_'.$row['id'].'" style="width:540px;float:left;background:#f1f1f1;display:none;">';
								foreach($row['childs'] as $rows)
								{
									echo '<label><input name="company_type[]" type="checkbox" value="'.$rows['id'].'" class="addduo"/> '.$rows['name'].'</label>';
								}
								echo '</div>';
							}
							else
							{
								echo '<label><input name="company_type[]" type="checkbox" value="'.$row['id'].'" class="addduo"/> '.$row['name'].'</label>';
							}
						}
						?>
						</span></div>
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
						
				        <div class="user_form_line"><span class="add"> 公司/团队规模：</span><span class="Scale">
						<label><input type="radio" name="company_size" value="0"/> 1~10人</label>
						<label><input type="radio" name="company_size" value="1"/> 11~20人</label>
						<label><input type="radio" name="company_size" value="2"/> 20~50人</label>
						<label><input type="radio" name="company_size" value="3"/> 50~100人</label>
						<label><input type="radio" name="company_size" value="4"/> 101~200人</label>
						<label><input type="radio" name="company_size" value="5"/> 200~500人</label>
						<label><input type="radio" name="company_size" value="6"/> 500人以上
                        </span>
                        </div>
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
                        <div class="user_form_line"><span class="add"><em>*</em>公司/团队地址：</span>
                          <span>
								<select name="province" id="province" class="user_select">
									<?php foreach($provinces as $row):?>
									<option value="<?php echo $row['id'];?>" <?php if($row['id']==$province){echo 'selected';}?> ><?php echo $row['name']; ?></option>
									<?php endforeach; ?>
								</select>
								<select name="city" id="city" class="user_select">
									<?php foreach($citys as $rows): ?>
									<option value="<?php echo $rows['id']; ?>" <?php if($rows['id'] == $city){echo 'selected';}?> ><?php echo $rows['name']; ?></option>
									<?php endforeach; ?>
								</select>
                           </span>
                        </div> 
                        <div class="user_form_line"><span class="add">团队介绍：</span> <span><textarea rows="7" cols="65" class="intr" name="company_desc"><?php echo set_value('company_desc'); ?></textarea></span> </div> 
                		<div style="width:600px; margin-left:170px; padding-top:10px;"><input type="button" onclick="document.getElementById('addxx').style.display=document.getElementById('addxx').style.display==''?'none':''" value="添加更多详细资料" class="addzil"><img src="<?php echo static_url('public/images/jiantou.jpg');?>" /> </div>  
                        <div id="addxx" style="display:none">
                               <div class="user_form_line2"><span class="addketian">公司/团队的详细地址：</span><span><input name="company_address" type="text" value="<?php echo set_value('company_address'); ?>" class="user_input"/></span></div> 
                               <div class="user_form_line2"><span class="addketian">公司/团队的官网/微博：</span><span><input name="company_web" type="text" value="<?php echo set_value('company_web'); ?>" class="user_input"/></span></div>
                               <div class="user_form_line2"><span class="addketian">公司/团队联系电话：</span><span><input name="company_phone" type="text" value="<?php echo set_value('company_phone'); ?>" class="user_input"/></span></div>
                               <div class="user_form_line2"><span class="addketian">公司/团队联系邮箱：</span><span><input name="company_email" type="text" value="<?php echo set_value('company_email'); ?>" class="user_input"/></span></div>
                               <div class="clear"></div>
                        </div>
                </div>
                <div class="clear"></div>				
				<div class="user_form_line prv"><input name="" type="submit" value="确认添加" class="user_submit"/></div>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo static_url('public/webuploader/webuploader.nolog.js');?>"></script>
<script type="text/javascript" src="<?php echo static_url('public/webuploader/diyUpload.js');?>"></script>
<script type="text/javascript">
/*
* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
* 其他参数同WebUploader
*/
$(document).ready(function () {
	$('#filePicker').diyUpload({
		url:"<?php echo site_url('/user/upload/img');?>",
		success:function( data ) {
			console.info( data );
		},
		error:function( err ) {
			console.info( err );	
		}
	});
});
</script>