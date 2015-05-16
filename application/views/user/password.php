<div class="main">
	<div class="page">
		<div class="login">
			<div class="login_left">
				<?php echo form_open('user/password/email/'.$mail.'/'.$forget_time);?>
				<div class="form_title">找回密码</div>
				<div class="form_line"><span class="width_100">密码</span><span><input name="password" type="password" value="<?php echo set_value('password'); ?>" class="login_input"/></span><div class="error"><?php echo form_error('password'); ?></div></div>
				<div class="form_line"><span class="width_100">重复密码</span><span><input name="passconf" type="password" value="<?php echo set_value('passconf'); ?>" class="login_input"/></span><div class="error"><?php echo form_error('passconf'); ?></div></div>
				<div class="form_line padding-left_100"><input name="" type="submit" value="重置密码" class="login_submit"/></div>
				<?php echo form_close(); ?>
			</div>
			<div class="login_right"><h2>已经注册过？<a href="<?php echo site_url('user/login'); ?>"><span>登录</span></a></h2><p>合作网站账号登陆游商网</p><a href="<?php echo site_url('');?>"><img src="<?php echo static_url('public/images/weibo.jpg'); ?>"></a><br><a href="<?php echo site_url('');?>"><img src="<?php echo static_url('public/images/t_weibo.jpg'); ?>"></a></div>
		</div>
	</div>
</div>