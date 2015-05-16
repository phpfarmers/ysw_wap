<!-- 发布委托 start -->
<div id="dialog_content" class="add_trust_1" style="display:block;">
	<dl>
		<dt>委托给游商网</dt>
		<dd><a href="JavaScript:;" onclick="closeBg();"><img src="<?php echo static_url('public/images/lace/cuo.gif');?>"></a></dd>
	</dl>
	<?php if(count($my_task)>0):?>
		<div class="dia_xuan"><a href="JavaScript:;" class="trust" id ="add_trust_1" sid="add_trust_2">从已有合作中选择</a></div>
	<?php else:?>
		<div class="dia_xuan"><a href="JavaScript:;" onclick="javascript:alert('您暂未添加合作信息！')">从已有合作中选择</a></div>
	<?php endif;?>
	<?php echo form_open('trust/add_trust',array('id'=>'myform'));?>
	<ul class="dia_start">
		<li><strong>委托描述： </strong> <span><textarea id="msg" name="msg" class="prompt" rows="10" cols="30"></textarea></span></li>
		<li><strong>手机： </strong> <span><input id="mobile" name="mobile" type="text" name="biao_y"  class="biao_y prompt" value="<?php echo $contact['mobile'];?>"/> <strong>QQ： </strong> <input id="qq" name="qq" type="text" class="biao_y prompt" value="<?php echo $contact['qq'];?>"/></span></li>	
		<li><strong>邮箱：</strong> <span><input id="email" name="email" type="text" class="biao_s prompt" value="<?php echo $contact['email'];?>"/></span></li>
		<div class="dia_start_a">问题描述不能为空!</div>
		<li class="cooplist_pro_a1"><a id="myform" class="submit" href="javascript:;" style="color:#FFF;">确认委托</a> </li>
	</ul>
	<?php echo form_close();?>
</div>
<!-- 发布委托 start -->

<!-- 合作列表 start -->
<div id="dialog_content" class="add_trust_2" style="display:none;">
	<dl>
		<dt>委托给游商网</dt>
		<dd><a href="JavaScript:;" onclick="closeBg();"><img src="<?php echo static_url('public/images/lace/cuo.gif');?>"></a></dd>
	</dl>
	<div class="tabPanel3">
		<ul>
			<li class="hit3"><a href="javascript:;">发布的中合作</a></li>
			<li><a href="javascript:;">已结束合作</a></li>
		</ul>
		<div class="panes3">
			<div class="pane3" style="display:block;">
				<?php
				if($in_task  && isset($in_task))
				{
					$i = '0';
					foreach($in_task as $row)
					{
						$i++;
						if( $i%2 == 0)
						{
							echo '<div class="pane3_a pane_ul">';
						}
						else
						{
							echo '<div class="pane3_a">';
						}
						echo '<strong><input type="checkbox" name="pan_int1" value="'.$row->task_uuid.'/'.$row->title.'/'.date('Y-m-d',$row->create_time).'"/> <a href="'.site_url('cooperation/show/'.$row->task_uuid).'" target="_blank">'.$row->title.'</a></strong> <span>'.date('Y-m-d',$row->create_time).'</span></div>';
					}
				}
				?>
			</div>
			<div class="pane3" style=" display:none;">
				<?php
				if($end_task && isset($end_task))
				{
					$j = '0';
					foreach($in_task as $row)
					{
						$j++;
						if( $j%2 == 0)
						{
							echo '<div class="pane3_a pane_ul">';
						}
						else
						{
							echo '<div class="pane3_a">';
						}
						echo '<strong><input id="end_task" type="checkbox" name="pan_int1" value="'.$row->task_uuid.'"/> <a href="'.site_url('cooperation/show/'.$row->task_uuid).'" target="_blank">'.$row->title.'</a></strong> <span>'.date('Y-m-d',$row->create_time).'</span></div>';
					}
				}
				?>
			</div>
		</div>
		<div class="clear"></div>
		<!--<div class="pane3_b"><label><input type="checkbox" onclick="selectAll(this);"/> 全选</label></div>-->
		<div class="cooplist_pro_a1 pan_que"><a href="javascript:;" class="trust select" id ="add_trust_2" sid="add_trust_3">确认选择</a> <a href="JavaScript:;" class="trust pan_fan" id ="add_trust_2" sid="add_trust_1">返回</a></div>
	</div>
</div>
<!-- 合作列表 end -->

<!-- 选择合作 start -->
<div id="dialog_content" class="add_trust_3" style="display:none;">
	<dl>
		<dt>委托给游商网</dt>
		<dd><a href="JavaScript:;" onclick="closeBg();"><img src="<?php echo static_url('public/images/lace/cuo.gif');?>"></a></dd>
	</dl>
	<div class="dia_xuan"><a href="javascript:;" class="trust" id ="add_trust_3" sid="add_trust_2">重新选择</a></div>
	<div class="dia_yes"></div>
	<?php echo form_open('trust/add_trust',array('id'=>'myform1'));?>
	<ul class="dia_start">
		<li><strong>委托描述： </strong> <span><textarea id="msg" name="msg" class="prompt" rows="10" cols="30"></textarea></span></li>
		<li><strong>手机： </strong> <span><input id="mobile" name="mobile" type="text" name="biao_y"  class="biao_y prompt" value="<?php echo $contact['mobile'];?>"/> <strong>QQ： </strong> <input id="qq" name="qq" type="text" class="biao_y prompt" value="<?php echo $contact['qq'];?>"/></span></li>	
		<li><strong>邮箱：</strong> <span><input id="email" name="email" type="text" class="biao_s prompt" value="<?php echo $contact['email'];?>"/></span></li>
		<div class="dia_start_a">问题描述不能为空!</div>
		<input id="task_uuid" name="task_uuid" type="hidden" value=""/>
		<li class="cooplist_pro_a1"><a id="myform1" class="submit" href="javascript:;" style="color:#FFF;">确认委托</a> </li>
	</ul>
	<?php echo form_close();?>
</div>
<!-- 选择合作 end -->


<script type="text/javascript">
$(function(){	
	$('.tabPanel3 ul li').click(function(){
		$(this).addClass('hit3').siblings().removeClass('hit3');
		$('.panes3>div:eq('+$(this).index()+')').show().siblings().hide();	
	})
})

$(document).ready(function(){
	//点击跳转
	$('.trust').click(function(){
		var id = $(this).attr('id');
		var sid = $(this).attr('sid');
		if(sid == 'add_trust_2')
		{
			$('.pan_fan').attr('sid',id);
		}
		$('.'+id).hide();
		$('.'+sid).show();
	});
	//表单验证
	$('.submit').click(function(){
		var myform = $(this).attr('id');
		var msg = document.getElementById(myform).msg;
		var mobile = document.getElementById(myform).mobile;
		var qq = document.getElementById(myform).qq;
		var email = document.getElementById(myform).email;
		if(msg.value == '')
		{
			$('.dia_start_a').show();
			$('.dia_start_a').html('委托描述不可为空!');
			msg.focus();
			return false;
		}
		if(mobile.value != ''){
			if(!mobile.value.match(/^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/))
			{
				$('.dia_start_a').show();
				$('.dia_start_a').html('请填写正确的手机号码！');
				mobile.focus();
				return false;
			}
		}
		if(qq.value != ''){
			if(!qq.value.match(/^[1-9][0-9]{4,}$/))
			{
				$('.dia_start_a').show();
				$('.dia_start_a').html('请输入正确的QQ号！');
				qq.focus();
				return false;
			}
		}
		if(email.value != ''){
			if(!email.value.match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/))
			{
				$('.dia_start_a').show();
				$('.dia_start_a').html('您输入的邮件格式有误！');
				email.focus();
				return false;
			}
		}
		if(mobile.value == '' && qq.value == '' && email.value == '')
		{
			$('.dia_start_a').show();
			$('.dia_start_a').html('手机、邮箱、QQ不可全为空！');
			mobile.focus();
			return false;
		}
		if(msg.value != '' &&  (mobile.value != '' || qq.value != '' || email.value != ''))
		{
			document.getElementById(myform).submit();
		}
	});
	//点击隐藏错误提示
	$('.prompt').click(function(){
		$('.dia_start_a').hide();
	});

	//确认选择合作
	$('.select').click(function(){
		var str=strs=task_uuid='';
		$('input[name="pan_int1"]:checked').each(function(){
			str+=$(this).val()+',';
		});
		arr=str.split(',');
		for(var i=0;i<arr.length-1;i++)
		{
			arrs=arr[i].split('/');
			if(i%2 != 0)
			{
				strs+='<div class="pane3_a pane_ul"><strong><a target="_blank" href="http://localhost/ysw_front/index.php/cooperation/show/'+arrs[0]+'">'+arrs[1]+'</a></strong> <span>'+arrs[2]+'</span></div>';
			}
			else
			{
				strs+='<div class="pane3_a"><strong><a target="_blank" href="http://localhost/ysw_front/index.php/cooperation/show/'+arrs[0]+'">'+arrs[1]+'</a></strong> <span>'+arrs[2]+'</span></div>';
			}
			task_uuid+=arrs[0]+',';

		}
		if(strs != '')
		{
			if(arr.length-1 == 1)
			{
				$('.dia_yes').css({'height':'45px'});
			}
			else if(arr.length-1 == 2)
			{
				$('.dia_yes').css({'height':'90px'});
			}
			$('.dia_yes').html(strs);
			$('#task_uuid').val(task_uuid);;
		}
		else
		{
			$('.add_trust_3').hide();
			$('.add_trust_1').show();
		}
	});

});

//复选框全选
/*function selectAll(checkbox) {
	$('input[type=checkbox]').prop('checked', $(checkbox).prop('checked'));
}*/
</script>