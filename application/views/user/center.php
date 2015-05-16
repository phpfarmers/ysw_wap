        <div class="user_right">
			<div class="user_right_title"><h2>个人中心</h2></div>
			<div class="user_right_content">
            	<div class="cent">
                    <ul>
                        <li>
                            <p>评论数</p>
                            <h3><?php echo $comment_num;?></h3>
                        </li>
                        <li>
                            <p>发布合作数 </p>
                            <h3><?php echo $task_num;?></h3>
                        </li>
                        <li>
                            <p>提交产品数 </p>
                            <h3><?php echo $product_num;?></h3>
                        </li>
                        <li>
                            <p>关注合作数 </p>
                            <h3><?php echo $task_collection;?></h3>
                        </li>
                        <li>
                            <p>关注产品数</p>
                            <h3><?php echo $product_collection;?></h3>
                        </li>
						<li>
                            <p>资料下载数</p>
                            <h3>3</h3>
                        </li>
                        <li>
                            <p>资料上传数</p>
                            <h3><?php echo $data_upload;?></h3>
                        </li>
                        <li>
                            <p>资料收藏</p>
                            <h3><?php echo $data_favorites;?></h3>
                        </li>
                        <div class="clear"></div>
                    </ul>
                </div>
                <div class="center_a"><?php echo good_time();?>好！ <span><?php echo $user_info->nickname;?></span></div>
                <div class="center_b">
                	<span>资料完善程度：</span>
                    <span>星星等级</span>
                    <span><a href="<?php echo site_url('user/account');?>">修改资料</a></span>
                </div>
                <div class="center_d">
                	<ul>
                    	<li><span>真实姓名：</span><?php if($user_info->realname){echo $user_info->realname;}else{echo ' - ';}?></li>
                        <li><span>性别：</span><?php if($user_info->sex == 1){echo '男';}elseif($user_info->sex == -1){echo '女';}else{echo ' - ';}?></li>
                        <li><span>年龄： </span><?php if($user_info->age == 1){echo '小于25';}elseif($user_info->age == 2){echo '25到30';}elseif($user_info->age == 3){echo '30到30';}elseif($user_info->age == 4){echo '大于40';}else{echo ' - ';}?></li>
                        <li><span>手机： </span><?php if($user_info->mobile){echo $user_info->mobile;}else{echo ' - ';}?></li>
                        <li><span>Q Q： </span><?php if($user_info->qq){echo $user_info->qq;}else{echo ' - ';}?></li>
                        <li><span>职位：</span><?php if($user_info->employee_position){echo $user_info->employee_position;}else{echo ' - ';}?></li>
                        <li><span>微信： </span><?php if($user_info->weixin){echo $user_info->weixin;}else{echo ' - ';}?></li>
                        <li><span>微博： </span><?php if($user_info->weibo){echo $user_info->weibo;}else{echo ' - ';}?></li>
                    </ul>
                    <div class="clear"></div>
                    <ul class="center_cul">
						<li><span>邮箱：</span><?php if($user_info->email){echo $user_info->email;}else{echo '<a href="'.site_url().'">立即绑定</a>';}?></li>
                    	<li><span>在职公司：</span><?php if($user_info->company_name){echo $user_info->company_name;}else{echo ' - ';}?></li>
                        <li><span>公司所在地：</span><?php if($user_info->company_address){echo $user_info->company_address;}else{echo ' - ';}?></li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="center_a">登陆信息</div>
                <div class="center_d">
                	<ul>
                    	<li><span>会员ID：</span><?php if($user_info->username){echo $user_info->username;}else{echo ' - ';}?></li>
                        <li><span>积分：</span> <?php echo $user_info->intergral;?> </li>
                        <li><span>会员等级：</span><?php if($user_info->user_grade == 0){echo '普通会员';}elseif($user_info->user_grade == 1){echo '中级会员';}elseif($user_info->user_grade == 2){echo '高级会员';}else{echo ' - ';}?></li>
                        <li><span>活跃度： </span> - </li>
                        <li><span>在线时间： </span> 12小时 </li>
                        <li><span>贡献值： </span> - </li>
                        <li><span>注册时间：</span><?php echo date('Y-m-d h:i:s',$user_info->create_time);?></li>
                        <li><span>注册 IP： </span><?php echo $user_info->reg_ip;?></li>
                    </ul>
                    <div class="clear"></div>
                    <ul class="center_dul">
                    	<li><span>上次登录时间：</span><?php if($login_num>1){echo date('Y-m-d h:i:s',$last_login->create_time);}else{echo ' - ';}?></li>
                        <li><span>上次登录 IP：</span><?php if($login_num>1){echo $last_login->create_ip;}else{echo ' - ';}?></li>
                        <div class="clear"></div>
                    </ul>
                </div>
                <!--<div class="center_e">
                	<dl>
                    	<dt>尤小乐的简历 <a href="#"><img src="<?php echo static_url('public/images/shuaxin.gif');?>"> 刷新</a> <a href="#"><img src="<?php echo static_url('public/images/xiugai.gif');?>"> 修改</a></dt>
                     	<dd><img src="<?php echo static_url('public/images/kan.gif');?>"> 135</dd>
                    </dl>
                    <div class="clear"></div>
                    <dl>
                    	<dt>完整度: <strong>星星等级</strong></dt>
                     	<dd><span>3025</span> 次被搜索</dd>
                    </dl>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <div class="center_f">最近搜索： <a href="#"> 游戏策划 上海 </a>| <a href="#">场景制作 北京 </a></div>
                <dl class="center_g">
                	<dt><input type="submit" name="center_cx" value="重新发布" /></dt>
                    <dd>共有<span>12</span>份简历尚未查阅</dd>
                    <dd>发布中的职位<span>12</span>个</dd>
                    <div class="clear"></div>
                </dl>-->
			</div>
		</div>
	</div>
</div>