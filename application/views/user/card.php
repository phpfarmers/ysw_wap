        <div class="user_right">
			<div class="user_right_title"><h2>我的名片</h2></div>
			<div class="user_right_content">
					<div class="card">
					   <div class="card_left">
							<ul>
							  <li><img src="<?php if(isset($card->user_pic) && $card->user_pic){echo static_url('uploadfile/image/user/').'/180_'.$card->user_pic;}else{echo static_url('public/images/card.jpg');}?>"></li>
							  <li><a href="<?php echo site_url('user/avatar');?>">修改头像</a></li>
							</ul>
					   </div>
					   <div class="show">
						   <?php if($my_card > 0):?>
						   <div class="card_right card_rt1">
								<dl>
									<?php
									//用户名或昵称
									if($card_show->name== 0)
									{
										if($card_show->first_name== 0)
										{
											if(isset($card->realname) && $card->realname)
											{
												echo '<dt>'.$card->realname;
											}
											else
											{
												echo '<dt>姓名';
											}
										}
										else
										{
											echo '<dt>';
											if(isset($card->realname) && $card->realname)
											{
												if(iconv_strlen($card->realname,"UTF-8")<=3)
												{
													$j = iconv_strlen($card->realname,"UTF-8")-1;
													echo cut_str($card->realname,1,'');
													echo '<strong>';
													for($i=0;$i < $j;$i++)
													{
														echo '*';
													}
													echo '</strong>';
												}
												else
												{
													$j = iconv_strlen($card->realname,"UTF-8")-2;
													echo cut_str($card->realname,2,'');
													echo '<strong>';
													for($i=0;$i < $j;$i++)
													{
														echo '*';
													}
													echo '</strong>';
												}
											}
											else
											{
												echo '姓<strong>*</strong>';
											}
										}
									}
									else
									{
										if(isset($card->nickname) && $card->nickname)
										{
											echo '<dt>'.$card->nickname;
										}
										else
										{
											echo '<dt>昵称';
										}
									}
									//职位
									if($card_show->job==1)
									{
										if(isset($card->employee_position) && $card->employee_position)
										{
											echo '<span> / '.$card->employee_position.'</span>';
										}
										else
										{
											echo '<span> / 职位 </span>';
										}
									}
									//公司
									if($card_show->company==1)
									{
										if(isset($card->company_name) && $card->company_name)
										{
											echo '<dd>公司：'.$card->company_name.'</dd>';
										}
										else
										{
											echo '<dd>公司：- </dd>';
										}
									}
									//判断名片显示信息条数
									$n = 0;
									if($card_show->company==1)
									{
										$n++;
									}
									if($card_show->email==1)
									{
										$n++;
									}
									if($card_show->mobile==1)
									{
										$n++;
									}
									if($card_show->qq==1)
									{
										$n++;
									}
									if($card_show->weixin==1)
									{
										$n++;
									}
									//手机
									if($card_show->mobile==1)
									{
										if(isset($card->mobile) && $card->mobile)
										{
											if($n > 3)
											{
												echo '<dd class="card_rt2">手机：'.$card->mobile.'</dd>';
											}
											else
											{
												echo '<dd>手机：'.$card->mobile.'</dd>';
											}
										}
										else
										{
											if($n > 3)
											{
												echo '<dd class="card_rt2">手机：- </dd>';
											}
											else
											{
												echo '<dd>手机：- </dd>';
											}
										}
									}
									//QQ
									if($card_show->qq==1)
									{
										if(isset($card->qq) && $card->qq)
										{
											if($n > 3)
											{
												echo '<dd class="card_rt2">Q Q：'.$card->qq.'</dd>';
											}
											else
											{
												echo '<dd>Q Q：'.$card->qq.'</dd>';
											}
										}
										else
										{
											if($n > 3)
											{
												echo '<dd class="card_rt2">Q Q：- </dd>';
											}
											else
											{
												echo '<dd>Q Q：- </dd>';
											}
										}
									}
									echo '<div class="clear"></div> ';
									//邮箱
									if($card_show->email==1)
									{
										if(isset($card->email) && $card->email)
										{
											echo '<dd>邮箱：'.$card->email.'</dd>';
										}
										else
										{
											echo '<dd>邮箱：- </dd>';
										}
									}
									//微信
									if($card_show->weixin==1)
									{
										if(isset($card->weixin) && $card->weixin)
										{
											echo '<dd>微信：'.$card->weixin.'</dd>';
										}
										else
										{
											echo '<dd>微信：- </dd>';
										}
									}
									?>
								</dl>
						   </div>
						   <?php else:?>
						   <div class="card_right">
								<dl>
									<dt>姓名或昵称 <span> / 职位</span></dt>
									<dd>公司：- </dd>
									<dd>手机：- </dd>
									<dd>Q Q：- </dd>
									<dd>邮箱：- </a></dd>
								</dl>
						   </div>
						   <?php endif;?>
					   </div>		
					   <div class="clear"></div>
					   <?php
					   if($my_card > 0)
					   {
						   if($card_show->background=='0')
						   {
							   echo '<div class="card_dw" id="card_dw1"></div>';
						   }
						   else
						   {
							   echo '<div class="card_dw" id="card_dw"><img src="'.static_url('uploadfile/image/card').'/'.$card_show->bg_url.'"></div>';
						   }
						   if($card_show->border=='0')
						   {
							   echo '<div class="card_bk" id="card_bk1"></div>';
						   }
						   else
						   {
							   echo '<div class="card_bk" id="card_bk"><img src="'.static_url('uploadfile/image/card').'/'.$card_show->border_url.'"></div>';
						   }
					   }
					   else
					   {
						   echo '<div class="card_dw" id="card_dw1"></div>';
						   echo '<div class="card_bk" id="card_bk1"></div>';
					   }
					   ?>
					   <!--<div id="card_dw"><img src="<?php echo static_url('public/images/diwen.png');?>"></div>
					   <div id="card_bk"><img src="<?php echo static_url('public/images/bainkuang.png');?>"></div>-->	
				</div>
                <div class="card_xuan">
                	<h3>选择名片显示内容</h3>
                    <div class="card_dx">
                    	<label class="group_1 group_3 <?php if($my_card > 0){if($card_show->name== 0){echo 'ahover group_1_h';}}?>">姓名 <input type="checkbox" style="display:none;" value="姓名" class="check" id="realname" <?php if($my_card > 0){if($card_show->name== 0){echo 'checked="checked"';}}?>></label>
                        <label class="group_3 <?php if($my_card > 0){if($card_show->first_name== 1){echo 'ahover';}}?>">只显示姓 <input id="first_name" type="checkbox" style="display:none;" value="只显示姓" class="check" <?php if($my_card > 0){if($card_show->first_name== 1){echo 'checked="checked"';}}?>></label>
                        <label class="group_1 <?php if($my_card > 0){if($card_show->name== 1){echo 'ahover group_1_h';}}?>">昵称 <input type="checkbox" style="display:none;" value="昵称" class="check" id="nickname" <?php if($my_card > 0){if($card_show->name== 1){echo 'checked="checked"';}}?>></label>
                        <label class="<?php if($my_card > 0){if($card_show->job== 1){echo 'ahover';}}?>">职位 <input type="checkbox" style="display:none;" value="职位" class="check" id="job" <?php if($my_card > 0){if($card_show->job== 1){echo 'checked="checked"';}}?>></label>
                        <label class="<?php if($my_card > 0){if($card_show->company== 1){echo 'ahover';}}?>">公司 <input type="checkbox" style="display:none;" value="公司" class="check" id="company" <?php if($my_card > 0){if($card_show->company== 1){echo 'checked="checked"';}}?>></label>
                        <label class="group_2 <?php if($my_card > 0){if($card_show->email== 1){echo 'ahover group_2_h';}}?>">邮箱 <input type="checkbox" style="display:none;" value="邮箱" class="check" id="email" <?php if($my_card > 0){if($card_show->email== 1){echo 'checked="checked"';}}?>></label>
                        <label class="group_2 <?php if($my_card > 0){if($card_show->mobile== 1){echo 'ahover group_2_h';}}?>">手机 <input type="checkbox" style="display:none;" value="手机" class="check" id="mobile" <?php if($my_card > 0){if($card_show->mobile== 1){echo 'checked="checked"';}}?>></label>
                        <label class="group_2 <?php if($my_card > 0){if($card_show->qq== 1){echo 'ahover group_2_h';}}?>"> Q Q <input type="checkbox" style="display:none;" value="QQ" class="check" id="qq" <?php if($my_card > 0){if($card_show->qq== 1){echo 'checked="checked"';}}?>></label>
                        <label class="group_2 <?php if($my_card > 0){if($card_show->weixin== 1){echo 'ahover group_2_h';}}?>">微信 <input type="checkbox" style="display:none;" value="微信" class="check" id="weixin" <?php if($my_card > 0){if($card_show->weixin== 1){echo 'checked="checked"';}}?>></label>
                    </div>
                </div>
                <div class="clear"></div>
				<!--<style type="text/css">
				.other_title{width:728px;margin:20px 0px 0px 0px; padding:0px 5px;height:22px;font:normal normal bold 16px/22px 微软雅黑;float:left;color:#444444;}
				.card_other{width:738px;margin:10px 0px;padding-bottom:10px;float:left;}
				.card_other label{float:left;cursor:pointer;background:none;}
				.card_other label img{width:101px;height:44px;padding:3px;margin:5px;border:#eeeeee 2px solid;}
				.card_other label input{display:none;}
				</style>
				<div class="other_title">选择边框</div>
				<div class="card_other">
					<?php
					if($card_border!= '')
					{
						foreach ($card_border as $row)
						{
							if($card_show!= '')
							{
								if($card_show->border == $row->id)
								{
									echo '<label id="'.$row->id.'" class="group_4 group_4_h ahover"><img src="'.static_url('uploadfile/image/card/'.$row->url).'" style="border:#ff8a00 2px solid;"><input id="background" type="checkbox" class="check" checked="checked"></label>';
								}
								else
								{
									echo '<label id="'.$row->id.'" class="group_4"><img src="'.static_url('uploadfile/image/card/'.$row->url).'"><input id="background" type="checkbox" class="check"></label>';
								}
							}
							else
							{
								echo '<label id="'.$row->id.'" class="group_4"><img src="'.static_url('uploadfile/image/card/'.$row->url).'"><input id="background" type="checkbox" class="check"></label>';
							}
						}
					}
					?>
				</div>
				<div class="other_title">选择底纹</div>
				<div class="card_other">
					<?php
					if($card_bg!= '')
					{
						foreach ($card_bg as $row)
						{
							if($card_show!= '')
							{
								if($card_show->background == $row->id)
								{
									echo '<label id="'.$row->id.'" class="group_5 group_5_h ahover"><img src="'.static_url('uploadfile/image/card/'.$row->url).'" style="border:#ff8a00 2px solid;"><input id="background" type="checkbox" class="check" checked="checked"></label>';
								}
								else
								{
									echo '<label id="'.$row->id.'" class="group_5"><img src="'.static_url('uploadfile/image/card/'.$row->url).'"><input id="background" type="checkbox" class="check"></label>';
								}
							}
							else
							{
								echo '<label id="'.$row->id.'" class="group_5"><img src="'.static_url('uploadfile/image/card/'.$row->url).'"><input id="background" type="checkbox" class="check"></label>';
							}
						}
					}
					?>
				</div>
                <div class="clear"></div>-->	
				<div class="user_form_line prv"><input type="button" value="保存资料" class="user_submit"/></div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	//var url = '<?php echo static_url("public/images");?>/';
	$('.check').click(function(){
		if($(this).parent().hasClass('ahover'))
		{
			$(this).parent().removeClass('ahover');
			if($(this).parent().hasClass('group_1'))
			{
				$(this).parent().removeClass('group_1_h');
				$(this).removeAttr('checked');
			}
			if($(this).parent().hasClass('group_2'))
			{
				$(this).parent().removeClass('group_2_h');
			}
			if($(this).attr('id')=='realname')
			{
				$('#nickname').parent().addClass('ahover');
				$('#nickname').attr('checked','checked');
				$('#nickname').parent().addClass('group_1_h');

				$('#first_name').parent().removeClass('ahover');
				$('#first_name').removeAttr('checked');

				$('#realname').parent().removeClass('ahover');
				$('#realname').removeAttr('checked');
				$('#realname').parent().addClass('group_1_h');
			}
			if($(this).attr('id')=='nickname')
			{
				$('#first_name').parent().removeClass('ahover');
				$('#first_name').removeAttr('checked');
			}
			if($(this).parent().hasClass('group_4'))
			{
				$(this).parent().removeClass('group_4_h');
				//$('#card_bk').find('img').removeAttr('src');
				$('.card_bk').html('');
				$('.card_bk').attr('id','card_bk1');
				$(this).parent().find('img').removeAttr('style');
				//$('#card_bk').find('img').attr('src',url+'bainkuang.png');
			}
			if($(this).parent().hasClass('group_5'))
			{
				$(this).parent().removeClass('group_5_h');
				$('.card_dw').html('');
				$('.card_dw').attr('id','card_dw1');
				$(this).parent().find('img').removeAttr('style');
				//$('#card_dw').find('img').attr('src',url+'diwen.png');
			}
			$(this).removeAttr('checked');
		}
		else
		{
			if($(this).parent().hasClass('group_1'))
			{
				$('.group_1').removeClass('ahover group_1_h');
				$('.group_1').find('input').removeAttr('checked');
				$(this).parent().addClass('group_1_h');
			}
			if($(this).parent().hasClass('group_2'))
			{
				$(this).parent().addClass('group_2_h');
			}
			if($(this).attr('id')=='first_name')
			{
				$('#nickname').parent().removeClass('ahover');
				$('#nickname').removeAttr('checked');
				$('#nickname').parent().removeClass('group_1_h');

				$('#first_name').parent().addClass('ahover');
				$('#first_name').attr('checked','checked');

				$('#realname').parent().addClass('ahover');
				$('#realname').attr('checked','checked');
				$('#realname').parent().addClass('group_1_h');
			}
			if($(this).attr('id')=='nickname')
			{
				$('#first_name').parent().removeClass('ahover');
				$('#first_name').removeAttr('checked');
			}
			if($(this).parent().hasClass('group_4'))
			{
				$('.group_4').removeClass('ahover group_4_h');
				$('.group_4').find('img').removeAttr('style');
				$('.group_4').find('input').removeAttr('checked');
				$(this).parent().addClass('group_4_h');
				$(this).parent().find('img').css({"border":"#ff8a00 2px solid"});

				$('.card_bk').html('<img src="">');
				$('.card_bk').attr('id','card_bk');

				var img = $(this).parent().find('img').attr('src');
				$('#card_bk').find('img').attr('src',img);
			}
			if($(this).parent().hasClass('group_5'))
			{
				$('.group_5').removeClass('ahover group_5_h');
				$('.group_5').find('img').removeAttr('style');
				$('.group_5').find('input').removeAttr('checked');
				$(this).parent().addClass('group_5_h');
				$(this).parent().find('img').css({"border":"#ff8a00 2px solid"});

				$('.card_dw').html('<img src="">');
				$('.card_dw').attr('id','card_dw');

				var img = $(this).parent().find('img').attr('src');
				$('#card_dw').find('img').attr('src',img);
			}
			$(this).parent().addClass('ahover');
			$(this).attr('checked','checked');
		}

		//传递选择的选项
		var str = '';
		$('.ahover').each(function(){			
			str += $(this).find('input').attr('id')+ '-';
		});
		if(str != '')
		{
			$.post('<?php echo site_url('user/card/show'); ?>' + '/' + str, function(data){
				if(data.length >0) { 
					$('.show').html(data);
				}
			});
		}
		else
		{
			location.reload();
		}

	});

	$('.user_submit').click(function(){
		var group_1_num = $('.group_1_h').length;
		var group_2_num = $('.group_2_h').length;
		var border = $('.group_4_h').attr('id');
		var bg = $('.group_5_h').attr('id');

		if(group_1_num <= 0 || group_2_num <= 0)
		{
			if(group_1_num <= 0)
			{
				alert('姓名和昵称必须选一个！');
				return false;
			}
			if(group_2_num <= 0)
			{
				alert('邮箱、手机、QQ和微信至少选一个！');
				return false;
			}
		}
		else
		{
			var str = '';
			$('.ahover').each(function(){
				str += $(this).find('input').attr('id')+ '-';
			});
			if(str != '')
			{
				$.post('<?php echo site_url('user/card/edit'); ?>' + '/' + str + '/' + border + '/' + bg, function(data){
					if(data.length >0) { 
						alert(data);
					}
				});
			}
			else
			{
				location.reload();
			}
		}
	});
});
</script>