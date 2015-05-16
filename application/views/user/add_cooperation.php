<script type="text/javascript" src="<?php echo static_url('public/js/tanchu.js');?>"></script>
<link rel="stylesheet" href="<?php echo static_url('public/css/tanchu.css'); ?>" type="text/css">
<div class="main">
	<div class="append">
      <h1>发布合作信息</h1>
			<style type="text/css">
			/********** 自动匹配弹出框样式 start **********/
			.autobox{font:normal normal normal 14px/30px 微软雅黑;background:#FFFFFF;border:#ff8a00 2px solid;position:absolute;top:64px;left:30px;width:703px;z-index:811213;z-index:10;}
			.autolist{width:100%;margin:0px;padding:0px;}
			.autolist ul{margin:0px;padding:0px;list-style:none;}
			.autolist ul li{margin:0px;padding:0px 10px;cursor:pointer;text-align:left;}
			.autolist ul li:hover{background-color:#659CD8;color:#FFFFFF;}
			/********** 自动匹配弹出框样式 start **********/
			</style>
			<script type="text/javascript">
			function lookup(str) 
			{
				if($.trim(str).length != 0) 
				{
					$.post('<?php echo site_url('user/check/check_product_list'); ?>' + '/' + str, function(data){
						if(data.length >0) { 
							$('#auto').show();
							$('#autolist').html(data);
							$('#linked').html('确认选择');
							$('#linked').css({'background':'#666666'});
							$('.demand_a').css({'border':'2px solid #666666'});
							$('#linked').removeAttr('onclick');
							$('#product_uuid').val('');
						}
						else
						{
							$('#auto').hide();
							$('#linked').html('确认选择');
							$('#linked').css({'background':'#666666'});
							$('.demand_a').css({'border':'2px solid #666666'});
							$('#linked').removeAttr('onclick');
							$('#product_uuid').val('');
						}
					});
				}
				else
				{
					$('#auto').hide();
					$('#linked').html('确认选择');
					$('#linked').css({'background':'#666666'});
					$('.demand_a').css({'border':'2px solid #666666'});
					$('#linked').removeAttr('onclick');
					$('#product_uuid').val('');
				}
			}

			function fill(value,id) {
				$('#str').val(value);
				$('#product_uuid').val(id);
				$('#linked').html('确认选择');
				$('#linked').css({'background':'#ff8a00'});
				$('.demand_a').css({'border':'2px solid #ff8a00'});
				$('#linked').attr('onclick','show()');
				setTimeout("$('#auto').hide();", 200);
			}

			//关联产品
			function show() {
				var product_uuid = $('#product_uuid').val();
				if(product_uuid != '')
				{
					$.post('<?php echo site_url('user/check/check_product_info'); ?>' + '/' + product_uuid, function(data){
						if(data.length >0) { 
							$('#product_info').html(data);
						}
					});
				}
			}

			//重新选择
			function reselect()
			{
				$.post('<?php echo site_url('user/check/reselect_product'); ?>', function(data){
					if(data.length >0) { 
						$('#product_info').html(data);
					}
				});
			}

			function add(id)
			{
				var url = '<?php echo site_url('user/add_product/add'); ?>';
				var str = $('#'+id).val();
				window.location.href=url+'/'+str;
			}

			//鼠标失去焦点操作
			function hove()
			{
				if('block' == $('#auto').css('display'))
				{
					var str = $('#str').val();
					$('#autolist li').each(function(){
						arr=$(this).html().split(' - ');
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
			<div class="app_con">
			<?php echo form_open('user/add_cooperation/index/'.$product_uuid.'/'.$task_uuid);?>
			<div style="color:red;margin-top:10px;"><?php echo validation_errors();?></div>
      		<h2>注<span style=" color:#F00;">*</span>为必填项</h2>
            <div class="demand">
				<div id="product_info">
					<?php
					if($product_uuid != '0')
					{
						if($product_info)
						{
							if(!$product_info['product_icon'])
							{
								$product_info['product_icon'] = static_url('public/images/card.jpg');
							}
							echo '<dl>
									<dd><img src="'.static_url('uploadfile/image/product/'.$product_info['product_icon']).'" width="80" height="80"></dd>
									<dd class="dem_a">'.$product_info['product_name'].'<p class="dem_a1">'.$product_info['company_name'].'</p></dd>
									<dd class="dem_b"><input type="button" value="重新选择游戏" class="user_submit" onClick="reselect()"/></dd>
									<div class="clear"></div>
								</dl>
								<div class="clear"></div>
								<input type="hidden" id="product_uuid" name="product_uuid" value="'.$product_info['product_uuid'].'"/>
								<input type="hidden" id="company_uuid" name="company_uuid" value="'.$product_info['company_uuid'].'"/>
								';
						}
						else
						{
							echo '
								<div class="demand_p">
									<div><label><input class="dem_input" type="text" name="product" value="" id="str" onkeyup="lookup(this.value);" onmouseout="hove()" onblur="move(value)" placeholder="请输入游戏名称，并在下拉菜单中选择" original-title="" /><a href="javascript:;" id="linked" class="demand_a" onClick="show(\'product_uuid\')">确认选择</a></label> </div>
									<div class="clear"></div>
									<div class="demand_d">若为空，则表示您将要发布的合作没有产品，若没有您想要的产品信息，请<a href="'.base_url('user/add_product').'">添加新产品</a></div>
									<input type="hidden" id="product_uuid" name="product_uuid" value=""/>
									<div class="autobox" id="auto" style="display:none;">
										<div class="autolist" id="autolist">
										</div>
									</div>
								</div>
							';
						}
					}
					else
					{
							echo '
								<div class="demand_p">
									<div><label><input class="dem_input" type="text" name="product" value="" id="str" onkeyup="lookup(this.value);" onmouseout="hove()" onblur="move(value)" placeholder="请输入游戏名称，并在下拉菜单中选择" original-title="" /><a href="javascript:;" id="linked" class="demand_a" onClick="show(\'product_uuid\')">确认选择</a></label> </div>
									<div class="clear"></div>
									<div class="demand_d">若为空，则表示您将要发布的合作没有产品，若没有您想要的产品信息，请<a href="'.base_url('user/add_product').'">添加新产品</a></div>
									<input type="hidden" id="product_uuid" name="product_uuid" value=""/>
									<div class="autobox" id="auto" style="display:none;">
										<div class="autolist" id="autolist">
										</div>
									</div>
								</div>
							';
					}
					?>
				</div>
			<div class="clear"></div>
			<div class="user_form_line" style="margin-top:15px;">
				  <span class="with_120"><em>*</em>合作标题：</span> 
				  <span><input id="title" style="width:700px;" type="text" class="user_input" value="<?php echo $info['title'];?>" name="title"></span>
			</div>
			<!--找投资 start-->
			<div class="speed_right_content">
			<input type="hidden" id="task_uuid" name="task_uuid" value="<?php echo $task_uuid;?>" />

				<div class="user_form_line" style="margin-bottom:0px;">
					<span class="with_120"><em>*</em>合作需求：</span>
					<span>
						<?php foreach($target as $row):?>
						<label><input class="target" type="radio" value="<?php echo $row['id'];?>" sid="<?php echo $row['id'];?>" id="show_<?php echo $row['id'];?>" name="task_target_id" onclick="show_target(id)"> <?php echo $row['name'];?></label>
						<?php endforeach;?>
					</span>
				</div>
				<div class="step" style="width:100%;overflow:hidden;float:left;"></div>
				<div class="show" style="width:100%;overflow:hidden;float:left;"></div>
				<div class="show_from" style="width:100%;overflow:hidden;float:left;"></div>
				<div class="user_form_line prv3"><input id="submit" name="" type="submit" value="确认发布" class="user_submit"/></div>
				<script language="javascript">
				var task_uuid= '<?php echo urlencode(base64_encode($task_uuid));?>';
				/*var target_id= '<?php echo (int)$info['task_target_id'];?>';*/

				<?php if($info['parent']!=0){?>
				var target_id = '<?php echo (int)$info['parent'];?>';
				<?php }else if($info['task_target_id']!=0){?>
				var target_id = '<?php echo (int)$info['task_target_id'];?>';
				<?php }else{ ?>
				var target_id = '<?php echo (int)$target[0]['id'];?>';
				<?php }?>

				$(document).ready(function(){
					$('#show_'+target_id).prop('checked','checked');
					show_target('show_'+target_id);
				});

				//单击游戏需求目标（一级）,加载相应的from表单或二级需求目标
				function show_target(id){
					var sid= $('#'+id).attr('sid');
					if($.trim(sid) != 0)
					{
						$.post('<?php echo site_url('user/add_cooperation/check_show'); ?>' + '/' + sid + '/' + task_uuid + '/' + target_id, function(data){
							if(data.length >0) {
								$('.show').show();
								$('.show').html(data);

								<?php if($info['parent']!=0){ ?>
									<?php if($info['task_target_id']!=0){ ?>
										var gid = <?php echo (int)$info['task_target_id'];?>;
									<?php } else { ?>
										var gid = $('#grade_id').attr("gid");
									<?php }?>
								<?php } else { ?>
										var gid = $('#grade_id').attr("gid");
								<?php } ?>

								if (gid != undefined)
								{
									$('#show_'+gid).prop('checked','checked');
									show_target_from('show_'+gid);
								}
							}
						});
						$('.show_from').hide();
					}
				}

				//单击游戏二级需求目标现实相应的from表达
				function show_target_from(id){
					var sid= $('#'+id).attr('sid');
					var target_id = '<?php echo (int)$info['task_target_id'];?>';
					if($.trim(sid) != 0)
					{
						$.post('<?php echo site_url('user/add_cooperation/check_show_from'); ?>' + '/' + sid + '/' + task_uuid + '/' + target_id, function(data){
							if(data.length >0) {
								$('.show_from').show();
								$('.show_from').html(data);
							}
						});
					}
				}
				</script>
				<!-- 复选框全选 start -->
				<script type="text/javascript">
				function selectAll(checkbox,id)
				{
					$('input[id='+ id + ']').prop('checked', $(checkbox).prop('checked'));
				}
				</script>
				<!-- 复选框全选 end -->
				<!-- add start -->
				<script type="text/javascript">
				function addXie(id)
				{
					var aa = $(".art_mag").length;
					$('#add_content').append('<div><input name="serialize_key[]" type="text" placeholder="" class="art_mag" value="" maxlength="10"/><input name="serialize_value[]" value="" placeholder="" type="text" class="art_mag" maxlength="10"/><a class="bbb" id="aaa'+aa+'" onclick="delXie(id)">删除</a></div><div class="clear"></div>');
				}
				</script>
				<script type="text/javascript">
				function delXie(id)
				{
					$('#'+id).parent().remove();
				}
				</script>
				<style type="text/css">
				#add_content{width:100%;float:left;text-align:left;}
				#add_content input{ width:100px;float:left;margin:0px 10px 15px 0px;border:1px solid #cccccc;color:#878787;font:normal normal normal 16px/27px 微软雅黑;height:27px;padding:5px;}
				#add_content a{width:60px;height:39px;background:#ff8a00;color:#FFFFFF;display:block;float:left;text-align:center;text-decoration:none;cursor:pointer;}
				</style>
				<!-- add end -->
			</div>
		</div>
		<?php echo form_close();?>
  	  </div>
   </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#submit').click(function(){
		//合作标题
		if($.trim($('#title').val()).length == 0)
		{
			alert('合作标题必须填写！');
			$("#title").focus();
			return false;
		}
	});
});
</script>

<!-- 验证 -->
<script type="text/javascript">
function check(id)
{
	var str = document.getElementById(id).value;
	if($.trim(str).length != 0)
	{
		if(id == 'stock')
		{
			if(!$.trim(str).match(/^(\d{0,2}|0|100)(\.\d{0,2})?$/))
			{
				$('#'+id).val('');
				alert('只能填写0到100之间的整数和两位小数');
			}
		}
		/*else if(id == 'limit_time')
		{
			if(!$.trim(str).match(/^\d{4}-\d{2}-\d{2}$/))
			{
				$('#'+id).val('');
				alert('时间个数有误！例如:2015-01-01');
			}
		}*/
		else
		{
			if(!$.trim(str).match(/^[1-9][0-9]{0,}$/))
			{
				$('#'+id).val('');
				alert('只能填写大于0的整数');
			}
		}
	}
}
</script>
<script type="text/javascript">
$(document).ready(function(){
	var my_card = '<?php echo $my_card;?>';
	if(my_card <= '0')
	{
		$.get("<?php echo site_url('user/add_cooperation/load')?>",function(data){
			if(data.length >0)
			{
				$('#dialog').html(data);
				showBg('dialog','dialog_content');
			}
		});
	}
});
</script>