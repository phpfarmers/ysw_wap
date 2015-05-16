<dl>
	<dt>发送站内信</dt>
    <dd><a href="javascript:void(0);" onclick="closeBg();"><img src="<?php echo static_url('public/images/lace/cuo.gif');?>"></a></dd>
</dl>
<?php echo form_open('cooperation/send_letters',array('id' =>'myform'));?>
<ul class="dia_start">
	<input type="hidden" name="task_uuid" value="<?php echo $task_uuid;?>">
	<input type="hidden" name="accept_uuid" value="<?php echo $uuid;?>">
	<input type="hidden" name="type" value="<?php echo $type;?>">
	<li><strong>标题： </strong> <span><input type="text" name="title" id="title"/></span></li>
	<li><strong>收件人：</strong> <span><?php echo $nickname;?></span></li>
	<li><strong>内容： </strong> <span><textarea rows="10" cols="30" name="content" id="content"></textarea></span></li>
	<li><strong>验证码： </strong> <span><input style="float:left;" type="text" name="code" id="code" class="biao_y" maxlength="4"/><img id="code_img" style="cursor:pointer;float:left;"  title="点击更换验证码" alt="点击更换验证码" src="<?php echo site_url("cooperation/code");?>" onclick="javascript:this.src='<?php echo site_url("cooperation/code");?>?'+Math.random()">
	<a href="javascript:void(0);" id="change_code">换一组</a></span></li>
	<li class="cooplist_pro_a1"><a href="javascript:void(0);" onclick="check_letter()">发送</a></li>
</ul>
<?php echo form_close();?>
<script type="text/javascript">
function check_letter()
{
	if($("#title").val() == '' || $("#content").val() == '' || $("#code").val() == '')
	{
		if($("#title").val() == '')
		{
			alert('标题不可为空');
			$('#title').focus();
			return false;
		}
		if($("#content").val() == '')
		{
			alert('内容不可为空');
			$('#content').focus();
			return false;
		}
		if($("#code").val() == '')
		{
			alert('验证码不可为空');
			$('#code').focus();
			return false;
		}
	}
	else
	{
		var code = $("#code").val();
		$.get("<?php echo site_url('cooperation/check_code')?>" + '/' + code,function(data){
			if(data == 'false')
			{
				alert('验证码错误');
				$('#code').focus();
				return false;
			}
			else
			{
				document.getElementById('myform').submit();
			}
		});
	}
}
$(document).ready(function(){
	//刷新验证码
	$('#change_code').click(function(){
		$("#code_img").click();
	});
});
</script>