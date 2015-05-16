<div class="main">
	<div class="page1">
	   <!--left start-->
		<div class="coop_lf">
			<div class="new">
				<div class="new_nav">
					<div class="new_nav_l">
						<span><img src="<?php echo static_url('public/images/home.gif');?>"></span> 
						<span><a href="<?php echo site_url();?>">首页</a></span> 
						<span> > </span>
						<span>找资料</span>
					</div>
					<div class="clear"></div>
				</div>
				 <?php echo form_open_multipart('data/add_upload');?>
				 <div class="app_con" style="position:relative;">
						<div class="app_cona" style="position:absolute;right:-15px;top:-47px;"><a href="javascript:history.back(-1)">返回上一步</a></div>
						<div class="user_form_line">
								<span class="width_100"><em>*</em>选择文件：</span>
								<span style=" text-align:left; font-size:14px; color:#999; line-height:55px; margin-top:8px; width:600px;"> <input id="upload" type="file" name="userfile" size="20" /> </span>
								<span style=" font-size:12px; color:#999;">支持 gif、jpg、jpeg、bmp、png、doc、docx、txt、ppt、pptx、xls、xlsx、rar、zip、pdf 格式 </span>
						</div>
						<div class="user_form_line">
								<span class="width_100"><em>*</em>标题：</span>
								<span><input type="text" id="title" class="user_input zil_input" value="" name="title" /></span>
						</div>
						<div class="user_form_line">
							   <span class="width_100"><em>*</em>资料分类：</span>
							   <span>
									<select name="category" id="category" class="user_select">
										<?php 
										foreach ($data_category as $row)
										{
											echo '<option value="'.$row->id.'">'.$row->name.'</option>';
										}
										?>
									</select>
							  </span>
						</div>
						<div class="user_form_line">
							   <span class="width_100"><em>*</em>下载积分：</span>
							   <span>
									<?php
									$arr = array('0','10','20','30','40','50','60','70','80','90','100');
									echo '<select name="intergral" id="intergral" class="user_select">';
									foreach ($arr as $value)
									{
										if($value == '10')
										{
											echo '<option value="'.$value.'" selected="selected">'.$value.'</option>';
										}
										else
										{
											echo '<option value="'.$value.'">'.$value.'</option>';
										}
									}
									echo '</select>';
									?>
							  </span>
						</div>
						<div class="user_form_line">
								<span class="width_100">资料简介：</span>
								<span><textarea rows="7" cols="50" class="suggtext data_sug" name="content" id="content"></textarea></span>
						</div>
						<div class="clear"></div>
						<div class="data_tj">
								<div style=" margin-bottom:10px;"><span>*</span> 游商网将对资料中出现的涉及公司、个人、产品及其他敏感信息,进行屏蔽，并反馈给您。（请在资料上传后的<span>1-3</span>个工作日内关注游商网）</div>
							   <div style="margin-bottom:10px;">您还接受哪种反馈方式：
									 <label><input type="checkbox" name="feedback[]" value="1"/> 邮箱沟通</label>
									 <label><input type="checkbox" name="feedback[]" value="2"/> 手机沟通</label>
									 <label><input type="checkbox" name="feedback[]" value="3"/> QQ沟通</label>
								</div>
								<div><label><input type="checkbox" id="agree" /> 我已经认真阅读并同意<strong>"游商网关于资料上传的《法律声明》"</strong>声明内容！ </label></div>
								<div style=" margin:20px 0;"><input name="" type="submit" value="确认提交" class="zil_sub check"/></div>
								<div class="clear"></div>
						</div>
						<div class="data_jf">
							<p><strong>积分奖励原则：</strong> 通过审核的资料，每被下载一次，您可获得一次积分奖励，每次积分奖励为该资料定价的一半。</p>
							<dl>
								<dt><strong>注 意 事 项：</strong></dt>
								<dd>(1) 恶意上传非法资料，一经发现，您的账号将被列入黑名单；</dd>
								<dd>(2) 发现多次故意骗币行为的（通过修改标题、内容分拆等方式，多次重复上传同一资料的），您的账号将被列入黑名单。</dd>
							</dl>
							
						</div>
				 </div>
				 <?php echo form_close();?>
		   </div>
		</div>
		<!--left end -->
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
<script type="text/javascript">
$(document).ready(function(){
	var key = /<?php echo $key;?>/g;
	$('.check').click(function()
	{
		if($.trim($('#upload').val())==""){
			alert('上传文件不可为空！');
			$("#upload").focus();
			return false;
		}
		if($.trim($('#title').val()) == ''){
			alert('标题内容不可为空！');
			$("#title").focus();
			return false;
		}
		else
		{
			var str = $.trim($('#title').val());
			if(key.test(str))
			{
				var arr = str.match(key);
				var arrs = '';
				for(var i=0;i<arr.length;i++)
				{
					if(arrs.contains(arr[i]) == false)
					{
						arrs += arr[i]+',';
					}
				}
				alert('标题包含敏感词：'+arrs+'请修改！');
				$('#title').focus();
				return false;
			}
		}
		if($.trim($('#content').val())!="")
		{
			var str = $.trim($('#content').val());
			if(key.test(str))
			{
				var arr = str.match(key);
				var arrs = '';
				for(var i=0;i<arr.length;i++)
				{
					if(arrs.contains(arr[i]) == false)
					{
						arrs += arr[i]+',';
					}
				}
				alert('资料简介包含敏感词：'+arrs+'请修改！');
				$('#content').focus();
				return false;
			}
		}
		if($("#agree").prop("checked")==false)
		{
			alert('同意申明内容才可以提交！');
			return false;
		}
	});
});
</script>
<!--left end--> 