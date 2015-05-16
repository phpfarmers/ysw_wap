<!DOCTYPE html>
<html class="ui-mobile">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $web_title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo static_url('m/a/a.css');?>" rel="stylesheet" />
    <link href="<?php echo static_url('m/a/jquery.mobile.icons.min.css');?>" rel="stylesheet" />
    <link href="<?php echo static_url('m/a/jquery.mobile.structure-1.4.5.min.css');?>" rel="stylesheet" />
    <link href="<?php echo static_url('m/wap.css');?>" rel="stylesheet" />
	<link href="<?php echo static_url('public/images/i16.png');?>" sizes="16*16" type="images/png" rel="icon" />
</head>
<body id="ui-page-top">
	<div data-role="page" class="jqm-demos" data-quicklinks="true" id="pageone">
		<header data-role="header" class="jqm-header" id="webheader" data-position="fixed">
			<h2>
				<?php if(isset($headerh2)) echo $headerh2;?>				
			</h2>
			<a href="#" class="jqm-navmenu-link ui-btn-left ui-btn ui-btn-icon-notext ui-icon-bars ui-nodisc-icon ui-alt-icon"><?php echo lang('Menu');?></a>
			<span class="ui-btn-right headerspan">
				<a href="#" class="jqm-search-link ui-btn ui-btn-icon-notext ui-icon-search ui-nodisc-icon ui-alt-icon"><?php echo lang('Search');?></a>
				<a href="#" class="jqm-user-link ui-btn ui-btn-icon-notext ui-icon-user ui-nodisc-icon ui-alt-icon"><?php echo lang('User');?></a>
			</span>
		</header>
		<!--/header-->
		<section data-role="panel" class="jqm-navmenu-panel" data-position="left" data-display="overlay" data-theme="a">
			<ul class="jqm-list ui-alt-icon ui-nodisc-icon">
				<li data-filtertext="<?php echo lang('Home');?>" data-icon="home"><a href="<?php echo site_url();?>"><?php echo lang('Home');?></a></li>
				<!--<li data-filtertext="<?php echo lang('Entrepreneurs');?>"><a href="pioneer" data-ajax="false"><?php echo lang('Entrepreneurs');?></a></li>
				<li data-filtertext="<?php echo lang('Invest');?>"><a href="invest" data-ajax="false"><?php echo lang('Invest');?></a></li>-->
				<li data-filtertext="<?php echo lang('Cooperation');?>"><a href="<?php echo site_url('cooperation');?>" data-ajax="false"><?php echo lang('Cooperation');?></a></li>
				<li data-filtertext="<?php echo lang('Information');?>"><a href="<?php echo site_url('information');?>" data-ajax="false"><?php echo lang('Information');?></a></li>
				<!--<li data-filtertext="<?php echo lang('Talent');?>"><a href="talent" data-ajax="false"><?php echo lang('Talent');?></a></li>
				<li data-filtertext="<?php echo lang('Data');?>"><a href="data" data-ajax="false"><?php echo lang('Data');?></a></li>
				<li data-filtertext="<?php echo lang('Trust');?>"><a href="trust" data-ajax="false"><?php echo lang('Trust');?></a></li>-->
				<li data-filtertext="<?php echo lang('About us');?>"><a href="<?php echo site_url('single/show/6');?>" data-ajax="false"><?php echo lang('About us');?></a></li>
			</ul>
		</section>
		<!-- /panel nav left -->
		<section data-role="panel" class="jqm-search-panel" data-position="right" data-display="overlay" data-theme="a">
			<form method="post" action="<?php echo site_url('/search');?>" id="searchform" data-ajax="false">
				<input type="text" name="keywords" id="keywords" placeholder="<?php echo lang('Search');?>" data-mini="true">
				<select name="modul" id="modul" data-mini="true">
					<option value="cooperation"><?php echo lang('Cooperation');?></option>
					<!--<option value="invest"><?php echo lang('Invest');?></option>
					<option value="trust"><?php echo lang('Trust');?></option>
					<option value="products"><?php echo lang('Product');?></option>
					<option value="company"><?php echo lang('Company');?></option>
					<option value="data"><?php echo lang('Data');?></option>-->
					<option value="information"><?php echo lang('Information');?></option>
				</select>
				<input type="submit" data-inline="true" value="<?php echo lang('Search');?>" data-mini="true">
			</form>
		</section>
		<!-- /panel search right-->
		<section data-role="panel" class="jqm-user-panel" data-position="right" data-display="overlay" data-theme="a">
			<?php
			if(!$this->session->userdata('uuid'))
			{
			?>
				<form method="post" action="<?php echo site_url('/user/login');?>" data-ajax="false" id="userform">
					<div data-role="fieldcontain">
						<label for="fusername"><?php echo lang('Username');?>：</label>
						<input type="email" name="username" id="fusername" placeholder="<?php echo lang('Email');?>" required min="5" max="30" data-mini="true">
						<label for="fpassword"><?php echo lang('Password');?>：</label>
						<input type="password" name="password" id="fpassword" placeholder="<?php echo lang('Password');?>" required min="6" max="32" data-mini="true">
					</div>
					<input type="submit" data-inline="true" value="<?php echo lang('Sign in');?>" data-mini="true">
					<a href="<?php echo site_url('/user/reg');?>" data-role="button" data-inline="true" data-mini="true"><?php echo lang("Sign up");?></a>
				</form>
			<?php
			}
			else
			{?>
				<p>
					<?php echo $this->session->userdata('nickname');?> <a href="<?php echo site_url('user/logout');?>" data-role="button" data-inline="true"><?php echo lang('Sign out');?></a>

				</p>
			<?php
			}?>
		</section>
		<!-- /panel user right-->