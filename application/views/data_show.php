<link rel="stylesheet" href="<?php echo static_url('public/css/login.css'); ?>" type="text/css"/>
<script type="text/javascript" src="<?php echo static_url('public/js/tanchu.js');?>"></script>
<style type="text/css">
.smiley{width:380px;height:38px;position:absolute;background:#FFFFFF;border:#eeeeee 1px solid;padding:2px;top:20px;}
</style>
<?php echo smiley_js(); ?>
<div class="main">
        <div class="page1">
           <!--left start-->
            <div class="coop_lf">
            	<div class="new">
                    <div class="new_nav">
					   <div class="new_nav_l">
						   <span><img src="<?php echo static_url('public/images/home.gif');?>"></span> 
						   <span><a href="<?php echo site_url('');?>">首页</a></span> 
						   <span> > </span>
						   <span><a href="<?php echo site_url('data');?>">找资料</a></span>
						   <span> > </span>
						   <span class="new_a"><a href="#" onclick="document.getElementById('new_b').style.display=document.getElementById('new_b').style.display==''?'none':''"><?php echo $info->name;?><img src="<?php echo static_url('public/images/xiala.png');;?>"></a>
							   <ul id="new_b" style="display:none">
									<?php 
									foreach ($data_category as $row)
									{
										echo '<li><a href="'.site_url('data/index/category/'.$row->id).'">'.$row->name.'</a></li>';
									}
									?>
							   </ul>
						   </span> 
						   <span> > </span>
						   <span style=" color:#333"><?php echo $info->title;?></span>
					   </div>
                       <div class="clear"></div>
                    </div>
                    <!--资料详细 start-->
					<div class="new_nr">
                            <h2><?php echo $info->title;?></h2>
                            <div class="zil_ab">
                                <div class="ft zil_a"><?php echo $info->content;?></div>
                                <div class="gt zil_b">

									<?php if(!UUID):?>
									<div class="cooplist_pro_a"><a href="javascript:void(0)" onclick="prompt('登录之后才可以下载此资料！');">下载资料</a></div>
									<?php else:?>
										<?php if($info->download):?>
											<div class="cooplist_pro_a"><a href="javascript:void(0)" onclick="down('<?php echo $info->data_uuid;?>');">下载资料</a></div>
										<?php else:?>
											<div class="cooplist_pro_a zil_sum"><a href="javascript:void(0)" onclick="prompt('下载文件已删除或暂未上传！');">下载资料</a></div>
										<?php endif;?>
									<?php endif;?>
                                    <dl>
                                    	<dt class="zil_sc praise"><a href="javascript:void(0)" onclick="upon('<?php echo $info->data_uuid;?>');">点赞</a></dt>
                                        <dd>点赞：<em id="upon_num"><?php echo $info->upon;?></em></dd>
                                        <div class="clear"></div>
                                    </dl>
                                    <dl>
                                    	<dt class="zil_sc collect"><a href="javascript:void(0)" onclick="collect('<?php echo $info->data_uuid;?>')">收藏</a>
                                        </dt><dd>收藏：<em id="collect_num"><?php echo $info->collect;?></em></dd>
                                        <div class="clear"></div>
                                    </dl>
                                    <div class="clear"></div>
                                    <ul>
                                        <!--<li>下载要求：<span style=" color:#F00"><?php if(USERGRADE == 0){echo '普通会员';}elseif(USERGRADE == 1){echo '中级会员';}elseif(USERGRADE == 2){echo '高级会员';}?></span></li>-->
										<?php if($info->sn != 0){echo '<li>资料编号：<span class="zil_b1">D'.$info->sn.'</span></li>';}?>
										<li>下载次数：<span class="zil_b1" id="down_num"><?php echo $info->hits;?></span>次</li>
                                        <li>下载积分：<span class="zil_b1"><?php echo $info->intergral;?></span>分</li>
										<?php if($info->author){echo '<li>上 传 者：<span style="color:#F00">'.$info->author.'</span></li>';}?>
                                        <li>上传时间：<span><?php echo date('Y-m-d h:i',$info->open_time);?></span></li>
										<li><a href="javascript:void(0);" id="comment" onclick="animate(id)">我要评论</a> (<?php echo $num_c;?>)<span><a class="dialog" href="javascript:void(0);">我要纠错</a></span></li>
                                    </ul>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                            <dl class="new_dl">
								<?php
								if($Previous)
								{
									echo '<dd><a href="'.site_url('/data/show').'/'.$Previous->data_uuid.'" title="'.$Previous->title.'">前一篇 <span>'.$Previous->title.'</span></a></dd>';
								}
								else
								{
									echo '<dd>前一篇 <span>没有了</span></dd>';
								}
								if($Next)
								{
									echo '<dd><a href="'.site_url('/data/show').'/'.$Next->data_uuid.'" title="'.$Next->title.'">后一篇 <span>'.$Next->title.'</span></a></dd>';
								}
								else
								{
									echo '<dd>后一篇 <span>没有了</span></dd>';
								}
								?>
                            </dl>
                            <div class="new_ul">
                                <div class="new_div"><span>相关资讯</span></div>
                                <ul class="new_zx">
									<?php
									if($linked_data)
									{
										foreach($linked_data as $row)
										{
											echo '<li><a href="'.site_url('data/index/category/'.$row->category).'" class="new_ula" target="_blank">['.$row->name.']</a> <a href="'.site_url('data/show/'.$row->data_uuid).'" target="_blank">'.$row->title.'</a></li>';
										}
									}
									else
									{ 
										echo '<p style="margin:5px 0px;">暂无相关资讯！</p>';
									}
									?>
                                </ul>
                            </div>
                    </div>
                    <!--资料详细 end-->
               </div>
               <!--评论部分 start-->
			   <div class="newliat_dlu comment">
                    <h3>我要评论</h3>
                    <div class="newlist_dlu_a">
						<?php if(!UUID){?>
							<!--未登录 start-->
								<div class="new_wei">
									<?php echo form_open('user/login/index/'.uri_string());?>
									<div class="stmenu1">您还未登陆，暂时不能评论或回复，请先 <a href="<?php echo site_url('user/login/index/'.uri_string());?>" class="xialaguang1">登陆</a>
										<ul class="children1">    
										  <li>
											   <label><input type="text" name="mail" placeholder="请输入邮箱/用户名" class="nav_tan" required /> </label>
											   <label><input type="password" name="password" placeholder="请输入密码" class="nav_tan tan_no" required /> </label>
										  </li>  
										  <li>
												<input style="cursor:pointer;" type="submit" value="登陆" class="nav_sub">
												<label><input type="checkbox" name="rembem" > 记住密码</label>
												<a href="<?php echo site_url('user/forget');?>">忘记密码？</a>
										  </li>   
										  <!--<li>
												<p>合作网站账号登陆游商网</p>
												<p><a href="javascript:void(0);" class="nav_dl"></a> <a href="javascript:void(0);" class="nav_dl1"></a></p>
										  </li>-->
									 </ul>   
									</div>
									<div>还未账号？请先 <a href="<?php echo site_url('user/reg');?>">注册</a></div>
									<?php echo form_close();?>
								</div>
							<!--未登录 end-->
						<?php }else{ ?>
							<!--已经登录 start-->
							<?php echo form_open('data/reply');?>
							<div class="newlist_alf"><img src="<?php if(AVATAR){echo static_url('uploadfile/image/user/100_'.AVATAR);}else{echo static_url('public/images/avatar.jpg');} ?>" width="80" height="80"></div>
							<div class="newlist_art">
							<input type="hidden" name="data_uuid" value="<?php echo $info->data_uuid;?>" >
								<textarea cols="80" rows="6" name="content" id="comments"></textarea>
								<dl style="position:relative;">
									<dt><span><a href="JavaScript:void(0);" onclick="smiley(id)" class="biao" id="smiley_0"></a> 表情</span> <span><input type="checkbox" name="weibo"> 同步到微博</span> <span><input type="checkbox" name="weibo"> 同步到QQ空间</span></dt>
									<dd><input style="cursor:pointer;" type="submit" value="发布" name="fabu" class="fabu" /></dd>
									<div class="smiley smiley_0" style="display:none;"><?php echo $smiley_table; ?></div>
								</dl>
							</div>

							<div class="clear"></div>
							<?php echo form_close();?>
							<!--已经登录 end-->
						<?php } ?>                        
                        <!--查看评论 start-->
                        <div class="newlist_pl">
							<div class="ft">共<?php echo $num_p;?>人参加，<?php echo $num_c;?>条评论</div>
							<div class="gt"><a <?php if($act == 'desc'){ echo 'style="color:#ff8a00;"';}?> href="<?php echo site_url('data/show'.'/'.$info->data_uuid.'/desc');?>">最新</a> | <a <?php if($act == 'asc'){ echo 'style="color:#ff8a00;"';}?> href="<?php echo site_url('data/show'.'/'.$info->data_uuid.'/asc');?>">最早</a></div>
							<div class="clear"></div>
                        </div>
 						<?php foreach($comment as $row):?>
						<div class="newlist_dlu_b">
							<div class="newlist_alf"><img src="<?php if($row['user_pic']){echo static_url('uploadfile/image/user/100_'.$row['user_pic']);}else{echo static_url('public/images/cardd.jpg');}?>" width="80" height="80"></div>
							<div class="newlist_art">
								<div class="ft new_us"><span class="new_c"><?php echo $row['nickname'];?></span> <span class="new_v">[<?php if($row['user_grade'] == 0){echo '普通会员';}elseif($row['user_grade'] == 1){echo '中级会员';}elseif($row['user_grade'] == 2){echo '高级会员';}?>]</span>&nbsp;&nbsp;<?php echo $row['province'];?></div> 
								<div class="gt new_hui">
								<?php
								$times = strtotime(date("Y-m-d H:i:s"))- $row['create_time'];
								if($times < 60)
								{
									echo $times.'秒前';
								}
								elseif($times >= 60 && $times < 3600)
								{
									echo floor($times/60).'分钟前';
								}
								elseif($times >= 3600 && $times < 86400)
								{
									echo floor($times/3600).'小时前';
								}
								elseif($times >= 86400 && $times < 2592000)
								{
									echo floor($times/86400).'天前';
								}
								elseif($times >= 2592000 && $times < 31536000)
								{
									echo floor($times/2592000).'月前';
								}
								else
								{
									echo floor($times/31536000).'年前';
								}
								?>
								</div>
								<div class="clear"></div>
								<p><?php echo parse_smileys($row['content'],static_url('public/smileys/'));?></p>
								<div class="new_dc">
									<span><a href="JavaScript:void(0);" id="up_<?php echo $row['comment_uuid'];?>" onclick="num('<?php echo $row['comment_uuid'];?>','up')">顶</a> (<em id="up_num_<?php echo $row['comment_uuid'];?>"><?php echo $row['up'];?></em>)</span>
									<span><a href="JavaScript:void(0);" id="down_<?php echo $row['comment_uuid'];?>" onclick="num('<?php echo $row['comment_uuid'];?>','down')">踩</a> (<em id="down_num_<?php echo $row['comment_uuid'];?>"><?php echo $row['down'];?></em>)</span>
									<?php if(UUID !=''){?>
									<span><a href="JavaScript:void(0);" id="<?php echo $row['comment_uuid'];?>" class="new_huifu add_reply" onclick="add_reply(id)">回复</a></span>
									<?php }else{?>
									<span><a href="JavaScript:void(0);" id="comment" class="new_huifu add_reply" onclick="animate(id)">回复</a></span>
									<?php }?>
								</div>
								<!-- 回复 -->
								<div class="reply" id='reply<?php echo $row['comment_uuid'];?>' style="display:none"></div>
								<!-- 评论 -->
								<?php if(isset($row['childs'])){?>
									<div class="clear"></div>
									<?php foreach($row['childs'] as $rows):?>
									<div class="newlist_sm">
										   <div class="ft newlist_sm_a"><img src="<?php if($rows['user_pic']){echo static_url('uploadfile/image/user/100_'.$rows['user_pic']);}else{echo static_url('public/images/cardd.jpg');}?>" width="60" height="60"></div>
										   <div class="gt newlist_sm_b">
											   <div class="ft new_us"><span class="new_c"><?php echo $rows['nickname'];?></span> <span class="new_v">[<?php if($rows['user_grade'] == 0){echo '普通会员';}elseif($rows['user_grade'] == 1){echo '中级会员';}elseif($rows['user_grade'] == 2){echo '高级会员';}?>]</span>&nbsp;&nbsp;<?php echo $rows['province'];?></div> 
											   <div class="gt new_hui">
												<?php
												$timess = strtotime(date("Y-m-d H:i:s"))- $rows['create_time'];
												if($timess < 60)
												{
													echo $timess.'秒前';
												}
												elseif($timess >= 60 && $timess < 3600)
												{
													echo floor($timess/60).'分钟前';
												}
												elseif($timess >= 3600 && $timess < 86400)
												{
													echo floor($timess/3600).'小时前';
												}
												elseif($timess >= 86400 && $timess < 2592000)
												{
													echo floor($timess/86400).'天前';
												}
												elseif($timess >= 2592000 && $timess < 31536000)
												{
													echo floor($timess/2592000).'月前';
												}
												else
												{
													echo floor($timess/31536000).'年前';
												}
												?>
												</div>
											   <div class="clear"></div>
											   <p><?php echo parse_smileys($rows['content'],static_url('public/smileys/'));?></p>
											   <div class="new_dc">
													<span><a href="JavaScript:void(0);" id="up_<?php echo $rows['comment_uuid'];?>" onclick="num('<?php echo $rows['comment_uuid'];?>','up')">顶</a> (<em id="up_num_<?php echo $rows['comment_uuid'];?>"><?php echo $rows['up'];?></em>)</span>
													<span><a href="JavaScript:void(0);" id="down_<?php echo $rows['comment_uuid'];?>" onclick="num('<?php echo $rows['comment_uuid'];?>','down')">踩</a> (<em id="down_num_<?php echo $rows['comment_uuid'];?>"><?php echo $rows['down'];?></em>)</span>
											   </div>
										   </div>
									</div>
									<div class="clear"></div>
									<?php endforeach; ?>
								<?php } ?>

							</div>
							<div class="clear"></div>
						</div>
						<?php endforeach; ?>
						<style type="text/css">
						.see_s{width:100%;height:35px;line-height:35px;text-align:center;display:block;background:#f4f4f4;margin-top:10px;color:#999;}
						</style>
						<div id="comment_l"></div>
						<?php
						if($comment_n > 6)
						{
							echo '<a class="see_s see" str="6" href="javascript:;">查看更多留言</a>';
						}
						?>
						<script type="text/javascript">
						$(document).ready(function(){
							$('.see').click(function(){
								var num_c = <?php echo $comment_n;?>;
								var data_uuid = '<?php echo $info->data_uuid;?>';
								var act = '<?php echo $act;?>';
								var num = $(this).attr('str');
								if(num_c > num)
								{
									$.get("<?php echo site_url('data/comment')?>" + '/' + data_uuid + '/' + act + '/' + num,function(data){
										if(data.length >0)
										{
											$('#comment_l').append(data);
										}
									});
									if(num_c > num*1+6)
									{
										$('.see').attr('str',num*1+6);
									}
									else
									{
										$('.see').removeAttr('str');
										$('.see').html('没有了');
										$('.see').removeClass('see');
									}
								}
							});
						});
						</script>
						<!--查看评论 end-->
                        <div class="fabu_a"><input style="cursor:pointer;" id="comment" type="button" value="我来说一句" name="fabu_a" class="fabu fabu_as"  onclick="animate(id)"/></div>
                    </div>
               </div>
               <!--评论部分 end-->
            </div>
            <!--left end--> 
			<!--right start-->
			<div class="coop_rt"> 
				<div class="release"><a href="<?php echo site_url('data/add_data');?>"><span class="pub1_tu"></span><p class="rel_pp">上传资料</p></a></div>
				<?php $this->product->_new_product($new,$type);?>
				<?php $this->task->_hot_task($hot);?>
			</div>
			<!--right end-->
            <div class="clear"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	//弹出对话框
	$('.dialog').click(function() {
		var data_uuid = '<?php echo $info->data_uuid;?>';
		$.get("<?php echo site_url('data/load')?>" + '/' + data_uuid,function(data){
			if(data.length >0)
			{
				$('#dialog').html(data);
				showBg('dialog','dialog_content');
			}
		});
	});
});
//表单验证
function check()
{
	if($.trim($('#error').val()) == '')
	{
		$('.dia_start_a').show();
		$('.dia_start_a').html('错误地方不可为空!');
		$('#error').focus();
		return false;
	}
	if($.trim($('#correct').val()) == '')
	{
		$('.dia_start_a').show();
		$('.dia_start_a').html('修改内容不可为空!');
		$('#correct').focus();
		return false;
	}
	if($.trim($('#mobile').val())!=""){
		if(!$('#mobile').val().match(/^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/))
		{
			$('.dia_start_a').show();
			$('.dia_start_a').html('请填写正确的手机号码！');
			$('#mobile').focus();
			return false;
		}
	}
	if($.trim($('#qq').val())!=""){
		if(!$('#qq').val().match(/^[1-9][0-9]{4,}$/))
		{
			$('.dia_start_a').show();
			$('.dia_start_a').html('请输入正确的QQ号！');
			$('#qq').focus();
			return false;
		}
	}
	if($.trim($('#email').val())!=""){
		if(!$('#email').val().match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/))
		{
			$('.dia_start_a').show();
			$('.dia_start_a').html('您输入的邮件格式有误！');
			$('#email').focus();
			return false;
		}
	}
	if($.trim($('#mobile').val()) == '' && $.trim($('#qq').val()) == '' && $.trim($('#email').val()) == '')
	{
		$('.dia_start_a').show();
		$('.dia_start_a').html('手机、邮箱、QQ不可全为空！');
		$('#mobile').focus();
		return false;
	}
	if($.trim($('#error').val()) != '' && $.trim($('#correct').val()) != '' &&  ($.trim($('#mobile').val()) != '' || $.trim($('#qq').val()) != '' || $.trim($('#email').val()) != ''))
	{
		document.getElementById('myform').submit();
	}
}
//点击隐藏错误提示
function error()
{
	$('.dia_start_a').hide();
}
</script>
<script type="text/javascript">
$('.stmenu').hover(function(){
	$(this).find('.children').animate({ opacity:'show', height:'show' },200);
	$(this).find('.xialaguang').addClass('navhover');
}, function() {
	$('.children').stop(true,true).hide();
	$('.xialaguang').removeClass('navhover');
});
</script>
<script type="text/javascript">
$('.stmenu1').hover(function(){
	$(this).find('.children1').animate({ opacity:'show', height:'show' },200);
	$(this).find('.xialaguang1').addClass('navhover1');
}, function() {
	$('.children1').stop(true,true).hide();
	$('.xialaguang1').removeClass('navhover1');
});
</script>

<script type="text/javascript">
//资料下载
function down(data_uuid)
{
	//var url = '<?php echo static_url("uploadfile/file");?>'+'/'+'<?php echo $info->download;?>';
	$.get("<?php echo site_url('data/down')?>" + '/' + data_uuid,function(data){
		if(data.length >0)
		{
			$('#down_num').html(data);
			window.location.href = '<?php echo site_url('data/download');?>' + '/' + data_uuid;
			//window.open(url);
		}
		else
		{
			alert('您现有的积分小于本次下载所需积分！');
		}
	}); 
}

//提示
function prompt(str)
{
	if(str == 'up')
	{
		alert('不可重复顶！');return;
	}
	else if(str == 'down')
	{
		alert('不可重复踩！');return;
	}
	else
	{
		alert(str);return;
	}
}

//赞
function upon(data_uuid)
{
	var uuid = '<?php echo UUID;?>';
	var upon = <?php echo $info->upon;?>;
	if($.trim(uuid).length != 0)
	{
		$.get("<?php echo site_url('data/upon')?>" + '/' + data_uuid +'/'+upon,function(data){
			if(data == 'true')
			{
				$('.praise').addClass('zil_currer');
				$('.praise a').removeAttr('onclick');
				$('#upon_num').html(upon+1);
				alert('点赞已成功');
			}
			else
			{
				alert('不可重复点赞');
			}
		});
	}
	else
	{
		alert('登录之后才可点赞！');
	}
}

//收藏
function collect(data_uuid)
{
	var uuid ='<?php echo UUID;?>';
	var collect = <?php echo $info->collect;?>;
	if($.trim(uuid).length != 0)
	{
		$.get("<?php echo site_url('data/collect')?>" + '/' + data_uuid +'/'+collect,function(data){
			if(data == 'true')
			{
				$('.collect').addClass('zil_currer');
				$('.collect a').removeAttr('onclick');
				$('#collect_num').html(collect+1);
				alert('收藏已成功');
			}
			else
			{
				alert('不可重复收藏');
			}
		});
	}
	else
	{
		alert('登录之后才可收藏！');
	}
}

//跳转到指定位置
function animate(id)
{
	var top = $('.'+id).offset().top;
	$('html,body').animate({
	scrollTop:top
	},500);
}

//表情
function smiley(id)
{
	var test = $('.'+id).css('display');
	if(test == 'none')
	{
		$('.'+id).show();
	}
	else
	{
		$('.'+id).hide();
	}

	$('.'+id).hover(function(){
		$('.'+id).show();
	}, function() {
		$('.'+id).hide();
	});
}

//顶/踩
function num(comment_uuid,act) {
	$.get("<?php echo site_url('data/num_c/') . '/' ?>" + comment_uuid + '/' + act,function(data){
		if(data.length >0)
		{
			$('#'+act+'_'+comment_uuid).attr('onclick','prompt("'+act+'")'); 
			$('#'+act+'_num_'+comment_uuid).html(data);
		}
	});
}

//添加回复框
function add_reply(id)
{
var data_uuid = '<?php echo $info->data_uuid;?>';
$.get("<?php echo site_url('data/add_reply/') . '/' ?>" + id + '/' + data_uuid,function(data){
	if(data.length >0)
	{ 
		$('.reply').hide();
		$('.reply').html('');
		$('.add_reply').attr('onclick','add_reply(id)');

		$('#reply'+id).show();
		$('#reply'+id).html(data);
		$('#'+id).attr('onclick','remove_reply(id)');
	}
});
}
//移除回复框
function remove_reply(id)
{
$('#reply'+id).hide();
$('#reply'+id).html('');
$('#'+id).attr('onclick','add_reply(id)');
}

//分享
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
</script>