<dl>
	<dt>我有意向</dt>
	<dd><a href="javascript:void(0);" onclick="closeBg();"><img src="<?php echo static_url('public/images/lace/cuo.gif');?>"></a></dd>
</dl>
<?php echo form_open('cooperation/send_intention',array('id' =>'myform'));?>
<ul class="dia_start">
	<input type="hidden" name="uuid" value="<?php echo $uuid;?>">
	<input type="hidden" name="task_uuid" value="<?php echo $task_uuid;?>">
	<li><strong>意向说明： </strong> <span><textarea rows="10" cols="70" class="dia_textart" name="content" id ="content"></textarea></span></li>
	<li><strong>名片隐藏： </strong> <span><input type="checkbox" name="hidden" class="dia_input" value="1"/> 确定隐藏名片信息</span></li>
	<li><strong>验证码： </strong> <span><input style="float:left;" type="text" name="code" id="code" class="biao_y" maxlength="4"/><img id="code_img" style="cursor:pointer;float:left;"  title="点击更换验证码" alt="点击更换验证码" src="<?php echo site_url("cooperation/code");?>" onclick="javascript:this.src='<?php echo site_url("cooperation/code");?>?'+Math.random()">
<a href="javascript:void(0);" id="change_code">换一组</a></span></li>
<li class="cooplist_pro_a1"><a id="submit" href="javascript:void(0);">发送</a></li>
</ul>
<?php echo form_close();?>
<script type="text/javascript">
$(document).ready(function(){
	//表单验证
	$('#submit').click(function(){
		//校验验证码
		var code = $("#code").val();
		if(code == '')
		{
			alert('验证码不可为空');
			return false;
		}
		else
		{
			$.get("<?php echo site_url('cooperation/check_code')?>" + '/' + code,function(data){
				if(data == 'false')
				{
					alert('验证码错误');
					return false;
				}
			});
		}

		if($("#content").val() == '')
		{
			alert('内容不可为空');
			return false;
		}
		else
		{
			document.getElementById('myform').submit();			
		}
	});

	//刷新验证码
	$('#change_code').click(function(){
		$("#code_img").click();
	});

});
</script>