        <div class="user_right">
			<div class="user_right_title"><h2>账户资料</h2></div>
			<div class="user_right_content">
				<?php echo form_open('user/account');?>
				<div class="user_form_line"><span class="width_100">账号：</span><span><?php echo USERNAME;?></span>
				<?php if($email_checked == 1){ ?>
				<span style="font:normal normal normal 12px/35px 宋体;color:#ff0000;">（邮箱已验证）</span>
				<?php }else{ ?>
				<span class="you"><a href="<?php echo site_url('user/account/verify_email');?>">邮箱验证</a></span><span style="font:normal normal normal 12px/35px 宋体;color:#999999;">点击将发送验证邮件，请在邮箱中查收</span>
				<?php } ?>
				</div>
				<div class="user_form_line"><span class="width_100">昵称：</span><span><input name="nickname" type="text" value="<?php echo $nickname;?>" class="user_input"/></span><div class="error_from"><?php echo form_error('nickname'); ?></div></div>
				<div class="clear"></div>

				<div style="padding-left:110px;font:normal normal normal 16px/37px 微软雅黑;margin-bottom:15px;"><span>想要修改密码吗？</span><a href="javascript:void(0)" sid="content" id="toggle" class="verify_email">修改密码</a></div>
				<div class="content" style="display: none;">
				<div class="user_form_line"><span class="width_100">原始密码：</span><span><input name="oldpassword" type="password" value="" class="user_input"/></span><div class="error"><?php echo form_error('oldpassword'); ?></div></div>
				<div class="user_form_line"><span class="width_100">新密码：</span><span><input name="password" type="password" value="" class="user_input"/></span><div class="error"><?php echo form_error('password'); ?></div></div>
				<div class="user_form_line"><span class="width_100">重复密码：</span><span><input name="passconf" type="password" value="" class="user_input"/></span><div class="error"><?php echo form_error('passconf'); ?></div></div>
				</div>

				<!--<div class="user_form_line"><span class="width_100">头像：</span><span></span></div>-->


				<div class="user_form_title"><h2>个人资料</h2></div>
				<input name="uuid" type="hidden" value="<?php echo $uuid; ?>"/>
				<div class="user_form_line"><span class="width_100"><em>*</em>姓名：</span><span><input name="realname" type="text" value="<?php if(set_value('realname')){echo set_value('realname');}else echo $realname; ?>" class="user_input" required/></span><div class="error_from"><?php echo form_error('realname'); ?></div></div>
				<div class="user_form_line"><span class="width_100"><em>*</em>性别：</span><span><label><input type="radio" name="sex" value="1" id="sex" <?php if($sex == 1 || '1' === set_value('sex') || '' === set_value('realname')){?> checked="checked" <?php }?>/>男 </label><label><input type="radio" name="sex" value="-1" id="sex" <?php if($sex == -1 || '-1' === set_value('sex')){?> checked="checked" <?php }?>/>女 </label></span><div class="error_from"><?php echo form_error('sex'); ?></div></div>
				<div class="user_form_line"><span class="width_100">身份证号：</span><span><input name="identity" type="text" value="<?php if(set_value('identity')){echo set_value('identity');}else echo $identity; ?>" class="user_input"/></span><?php echo form_error('identity'); ?></div>
				<div class="user_form_line"><span class="width_100"><em>*</em>手机：</span><span><input name="mobile" type="text" value="<?php if(set_value('mobile')){echo set_value('mobile');}else echo $mobile; ?>" class="user_input" required/></span><div class="error_from"><?php echo form_error('mobile'); ?></div></div>

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
				<div class="user_form_line"><span class="width_100">所在地：</span><span>
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
				</span></div>
				<div class="user_form_line"><span class="width_100">QQ：</span><span><input name="qq" type="text" value="<?php if(set_value('qq')){echo set_value('qq');}else echo $qq; ?>" class="user_input"/></span><?php echo form_error('qq'); ?></div>
				<div class="user_form_line"><span class="width_100">微信：</span><span><input name="weixin" type="text" value="<?php if(set_value('weixin')){echo set_value('weixin');}else echo $weixin; ?>" class="user_input"/></span><?php echo form_error('weixin'); ?></div>
				<div class="user_form_line"><span class="width_100">微博：</span><span><input name="weibo" type="text" value="<?php if(set_value('weibo')){echo set_value('weibo');}else echo $weibo; ?>" class="user_input"/></span><?php echo form_error('weibo'); ?></div>
				<div class="user_form_line prv "><input name="" type="submit" value="保存个人资料" class="user_submit"/></div>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</div>