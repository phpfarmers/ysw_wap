<div class="main">
	<div class="page">
		<div class="login">
			<div class="login_left">
				<?php echo form_open('user/forget');?>
				<div class="form_title">忘记密码</div>
				<div class="form_line"><span class="width_100">账号</span><span><input name="mail" type="text" value="<?php echo set_value('mail'); ?>" class="login_input"/></span><div class="error"><?php echo form_error('mail'); ?></div></div>
				<div class="form_line padding-left_100"><input name="" type="submit" value="找回密码" class="login_submit"/></div>
				<?php echo form_close();?>
			</div>
			<div class="login_right"><h2>已经注册过？<a href="<?php echo site_url('user/login');?>"><span>登录</span></a></h2><p>合作网站账号登陆游商网</p><a href="<?php echo site_url('');?>"><img src="<?php echo static_url('public/images/weibo.jpg'); ?>"></a><br><a href="<?php echo site_url('');?>"><img src="<?php echo static_url('public/images/t_weibo.jpg'); ?>"></a></div>
		</div>
	</div>
</div>