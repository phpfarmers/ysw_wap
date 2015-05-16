<div class="main">
	<div class="page">
    	<div class="user_left">
            <a href="<?php echo site_url('user/avatar');?>" title="修改头像"><img class="avatar" src="<?php if(AVATAR){echo static_url('uploadfile/image/user/').'/180_'.AVATAR;}else{echo static_url('public/images/avatar.jpg');} ?>"  alt="修改头像" /></a>
            <div class="user_menu">
                <dl>
                    <dd>个人账户</dd>
                </dl>
                <ul>
                	<li><a href="<?php echo site_url('user/account'); ?>" id="account">账户资料</a></li>
                    <li><a href="<?php echo site_url('user/card'); ?>" id="card">个人名片</a></li>
                    <li><a href="<?php echo site_url('user/company'); ?>" id="company">我的公司</a></li>
					<li><a href="<?php echo site_url('user/letter'); ?>" id="company">我的站内信</a></li>
                </ul>
                <dl>
                    <dd>产品&合作</dd>
                </dl>
                <ul>
                	<li><a href="<?php echo site_url('user/cooperation'); ?>" id="cooperation">我发布的合作</a></li>
                    <li><a href="<?php echo site_url('user/products'); ?>" id="products">我提交的产品</a></li>
                    <li><a href="<?php echo site_url('user/concern_cooperation'); ?>" id="concern_cooperation">我收藏的合作</a></li>
                    <li><a href="<?php echo site_url('user/concern_product'); ?>" id="concern_product">我收藏的产品</a></li>
                </ul>
                <dl>
                    <dd>资料</dd>
                </dl>
                <ul>
                	<li><a href="<?php echo site_url('user/contribute'); ?>" id="contribute">我上传的资料</a></li>
                    <li><a href="<?php echo site_url('user/favorites'); ?>" id="favorites">我收藏的资料</a></li>
                </ul>
                <!--<dl>
                    <dd>招聘</dd>
                </dl>
                <ul>
                	<li><a href="<?php echo site_url('user/resume'); ?>" id="resume">我的简历</a></li>
                    <li><a href="<?php echo site_url('user/candidate'); ?>" id="candidate">我投递的简历</a></li>
                    <li><a href="<?php echo site_url('user/recruitment'); ?>" id="recruitment">我发布的招聘</a></li>
                </ul>-->
            </div>
        </div>