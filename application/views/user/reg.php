<div data-role="content">
	<form action="<?php echo site_url('user/reg');?>" method="post" name="regform" id="regform">
		<div data-role="fieldcontain">
			<label for="fusername"><?php echo lang('Username');?>:</label>
			<input type="email" name="username" id="fusername" value="<?php echo set_value('username'); ?>" placeholder="<?php echo lang('Email');?>" required min="5" max="30">
			<?php echo form_error('username'); ?>

			<label for="fnickname"><?php echo lang('Nickname');?>:</label>
			<input type="text" name="nickname" id="fnickname" value="<?php echo set_value('nickname'); ?>" placeholder="<?php echo lang('Nickname');?>" required min="2" max="30">
			<?php echo form_error('nickname'); ?>

			<label for="fpassword"><?php echo lang('Password');?>:</label>
			<input type="password" name="password" id="fpassword" value="<?php echo set_value('password'); ?>" placeholder="<?php echo lang('Password');?>" required min="6" max="30">
			<?php echo form_error('password'); ?>

			<label for="fpassconf"><?php echo lang('Passconf');?>:</label>
			<input type="password" name="passconf" id="fpassconf" value="<?php echo set_value('passconf'); ?>" placeholder="<?php echo lang('Passconf');?>" required min="6" max="30">
			<?php echo form_error('passconf'); ?>

			<label for="fagree"><?php echo lang('Agree');?>:</label>
			<select name="agree" id="fagree" data-role="slider">
				<option value="1"><?php echo lang('Yes');?></option>
				<option value="0"><?php echo lang('No');?></option>
			</select>
			<a href="#" data-role="button" data-inline="true" data-mini="true" data-shadow="false" id="reglaw"><?php echo lang('Reglaw');?></a>
			<?php echo form_error('agree'); ?>
		</div>
		<input type="submit" name="regsubmit" value="<?php echo lang('Sign up');?>" data-inline="true">
		<a href="<?php echo site_url('user/login');?>" data-role="button" data-inline="true"><?php echo lang('Sign in');?></a>
	</form>
</div>