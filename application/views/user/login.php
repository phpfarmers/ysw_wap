<div data-role="content">
	<form action="<?php echo site_url('user/login');?>" method="post" name="loginform" id="loginform" data-ajax="false">
		<div data-role="fieldcontain" >
			<label for="fusername"><?php echo lang('Username');?>:</label>
			<input type="email" name="username" id="fusername" value="<?php echo set_value('username'); ?>" placeholder="<?php echo lang('Email');?>" required min="5" max="30">
			<?php echo form_error('username'); ?>

			<label for="fpassword"><?php echo lang('Password');?>:</label>
			<input type="password" name="password" id="fpassword" value="<?php echo set_value('password'); ?>" placeholder="<?php echo lang('Password');?>" required min="6" max="30">
			<?php echo form_error('password'); ?>
		</div>
		<input type="submit" name="loginsubmit" value="<?php echo lang('Sign in');?>" data-inline="true">
		<a href="<?php echo site_url('user/reg');?>" data-role="button" data-inline="true"><?php echo lang('Sign up');?></a>
	</form>
</div>