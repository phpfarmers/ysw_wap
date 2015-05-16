        <div class="user_right">
			<style type="text/css">
			/********** 自动匹配弹出框样式 start **********/
			.autobox{font:normal normal normal 14px/30px 微软雅黑;background:#FFFFFF;border:#CCCCCC 1px solid;position:relative;top:-1px;left:0px;width:460px;z-index:811213;}
			.autolist{width:100%;margin:0px;padding:0px;}
			.autolist ul{margin:0px;padding:0px;list-style:none;}
			.autolist ul li{margin:0px;padding:0px 10px;cursor:pointer;}
			.autolist ul li:hover{background-color:#659CD8;color:#FFFFFF;}
			/********** 自动匹配弹出框样式 start **********/
			</style>
			<div class="user_right_title"><h2>我的公司</h2></div>
			<div class="user_right_content">
				<script type="text/javascript">
					function lookup(str) {
						if($.trim(str).length == 0) {
							$('#auto').hide();
						} else {
							$.post('<?php echo site_url('user/check/check_company_list'); ?>' +'/'+ str, function(data){
								if(data.length >0) {
									$('#auto').show();
									$('#autolist').html(data);
								}
								else
								{
									$('#auto').hide();
								}
							});
						}
					}

					function fill(value,id) {
						$('#str').val(value);
						setTimeout("$('#auto').hide();", 200);
					}

					//鼠标失去焦点操作
					function hove()
					{
						if('block' == $('#auto').css('display'))
						{
							var str = $('#str').val();
							$('#autolist li').each(function(){
								arr=$(this).html().split(' (未审核)');
								if(str == arr[0])
								{
									var aa = $(this).attr('onclick');
									eval(aa);
									return true;
								}
							});
						}
					}

					function move(value)
					{					
						if('block' == $('#auto').css('display'))
						{
							fill();
							$('#str').val(value);
						}
					}
				</script>
				<?php echo form_open('/user/company/select_company/'); ?>
				<div class="user_form_line gongsi"> 
                    <input name="company_name" type="text" class="txt" value="" id="str" onkeyup="lookup(this.value);" onmouseout="hove()" onblur="move(value)">
					<div class="autobox" id="auto" style="display:none;">
						<div class="autolist" id="autolist">
						</div>
					</div>
                </div>
				<div class="user_form_line prv"><input name="" type="submit" value="添加" class="user_submit"/></div>
				<?php echo form_close(); ?>
				
			</div>
		</div>
	</div>
</div>