<div class="main">
	<div class="append">
      <h1>添加产品</h1>
      <div class="app_nav"> </div>
	  <?php echo form_open_multipart('user/add_product/index/'.$product_info['product_uuid']);?>
	  <div style="color:red;"><?php echo validation_errors();?></div>
      <div class="app_con">
      		<h2>注<span style=" color:#F00;">*</span>为必填项</h2>
			<div class="user_form_line">
            		<span class="with_180">产品图片：</span>
                    <span><img id="preview" width="80px" src="<?php if($product_info['product_icon']!=''){ echo static_url('uploadfile/image/product/'.$product_info['product_icon']);}else{ echo static_url('public/images/huitx.jpg');}?>"></span>
                    <span style=" text-align:left; font-size:14px; color:#999; line-height:55px;">
						<input type="file" name="product_icon" id="product_icon" onchange="javascript:setImagePreview('product_icon','preview','80px','80px','<?echo static_url('public/images/huitx.jpg')?>');">						
                    <p>仅支持JPG/GIF/PNG格式，文件大小不超过200K，建议180*180px。</p>
                    </span>
            </div>
            <div class="user_form_line">
            		<span class="with_180"><em>*</em>游戏名称：</span>
                    <span><input name="product_name" type="text" value="<?php echo $product_info['product_name'];?>" class="user_input add_input"/></span>
            </div>
            <!--游戏平台 start-->
			<div class="user_form_line">
            		<span class="with_180"><em>*</em>游戏平台：</span>
            	    <span style="width:680px;">
						<?php $platform = explode(',',$product_info['product_platform']);?>
						<?php foreach ($platform_list as $key=>$value){ ?>
						<label><input id="platform" type="checkbox" value="<?php echo $key;?>" <?php if(in_array($key,$platform)){echo 'checked="checked"';} ?> name="product_platform[]"  /> <?php echo $value;?> </label>
						<?php }?>
                    </span>
            </div>
            <!--游戏平台 end-->
            <!--游戏style start-->
			<div class="user_form_line">
            		<span class="with_180"><em>*</em>游戏类型：</span>
            	    <span style="float:left;width:680px;background:#f1f1f1;padding:0px 10px;position:relative;">
						<?php 
						for ($i = 0; $i < count($type_sort); $i++) {
							echo '<div style="width:100%;float:left;">';
							foreach ($type_list as $row)
							{
								if($type_sort[$i] == 'typename')
								{
									$types = explode(',',$product_info['product_type']);
								}
								else
								{
									$types = explode(',',$product_info[$type_sort[$i]]);
								}

								if($type_sort[$i] == $row->input_name)
								{
									if($row->input_name == 'typename')
									{
										if(in_array($row->id,$types))
										{
											if($row->input_type == 1)
											{
												echo '<label><input id="product_type" type="radio" value="'.$row->id.'" name="product_type" checked="checked"/> '.$row->type_name.'</label>';
											}
											else
											{
												echo '<label><input id="product_type" type="checkbox" value="'.$row->id.'" name="product_type[]" checked="checked"/> '.$row->type_name.'</label>';
											}
										}
										else
										{
											if($row->input_type == 1)
											{
												echo '<label><input id="'.$row->input_name.'" type="radio" value="'.$row->id.'" name="product_type" /> '.$row->type_name.'</label>';
											}
											else
											{
												echo '<label><input id="'.$row->input_name.'" type="checkbox" value="'.$row->id.'" name="product_type[]" /> '.$row->type_name.'</label>';
											}
										}
									}
									else
									{
										if(in_array($row->id,$types))
										{
											if($row->input_type == 1)
											{
												echo '<label><input id="'.$row->input_name.'" type="radio" value="'.$row->id.'" name="'.$row->input_name.'" checked="checked"/> '.$row->type_name.'</label>';
											}
											else
											{
												echo '<label><input id="'.$row->input_name.'" type="checkbox" value="'.$row->id.'" name="'.$row->input_name.'[]" checked="checked"/> '.$row->type_name.'</label>';
											}
										}
										else
										{
											if($row->input_type == 1)
											{
												echo '<label><input id="'.$row->input_name.'" type="radio" value="'.$row->id.'" name="'.$row->input_name.'" /> '.$row->type_name.'</label>';
											}
											else
											{
												echo '<label><input id="'.$row->input_name.'" type="checkbox" value="'.$row->id.'" name="'.$row->input_name.'[]" /> '.$row->type_name.'</label>';
											}
										}
									}
								}
							}
							echo '<span style="color:red;">*</span></div>';
						}
						?>
                    </span>
            </div>
            <!--游戏style end-->
            <div class="user_form_line">
                    <span class="with_180"><em>*</em>是否单机：</span>
                    <span>
                            <label><input type="radio" value="0" <?php if($product_info['single_type'] == 0){echo 'checked="checked"';} ?> name="single_type"  class="danji"/> 否 </label>
                            <label><input type="radio" value="1" <?php if($product_info['single_type'] == 1){echo 'checked="checked"';} ?> name="single_type" class="danji"/> 是 </label>
                    </span>
            </div>
            <!--题材 start-->
             <div class="user_form_line">
                    <span class="with_180">游戏题材：</span> 
                    <span style=" margin-right:0; width:680px;">
                	    <label><input id="theme" type="radio" value="战争历史" <?php if($product_info['product_theme'] == '战争历史'){echo 'checked="checked"';}?> name="product_theme" onclick="hide(id)"/> 战争历史 </label>
                        <label><input id="theme" type="radio" value="东方仙侠" <?php if($product_info['product_theme'] == '东方仙侠'){echo 'checked="checked"';} ?> name="product_theme" onclick="hide(id)"/> 东方仙侠 </label>
                        <label><input id="theme" type="radio" value="西方魔幻" <?php if($product_info['product_theme'] == '西方魔幻'){echo 'checked="checked"';} ?> name="product_theme" onclick="hide(id)"/> 西方魔幻 </label>
                        <label><input id="theme" type="radio" value="近现代" <?php if($product_info['product_theme'] == '近现代'){echo 'checked="checked"';} ?> name="product_theme" onclick="hide(id)"/> 近现代 </label>
                        <label><input id="theme" type="radio" value="科幻" <?php if($product_info['product_theme'] == '科幻'){echo 'checked="checked"';} ?> name="product_theme" onclick="hide(id)"/> 科幻 </label>
                        <label><input id="theme" type="radio" value="灾难末世" <?php if($product_info['product_theme'] == '灾难末世'){echo 'checked="checked"';} ?> name="product_theme" onclick="hide(id)"/> 灾难末世 </label>

						<?php if($product_info['product_theme'] != '战争历史' && $product_info['product_theme'] != '东方仙侠' && $product_info['product_theme'] != '西方魔幻' && $product_info['product_theme'] != '近现代' && $product_info['product_theme'] != '科幻' && $product_info['product_theme'] != '灾难末世' && $product_info['product_theme'] != '' ){?>
						<label><input id="theme" id="theme" type="radio" class="test1" value="<?php echo $product_info['product_theme'];?>" name="product_theme" onclick="show(id)" checked="checked"/> 其他 </label>
                        <div class="theme" style="display:block;">
                        	<span><input value="<?php echo $product_info['product_theme'];?>" id="test1" type="text" name="art_style" class="user_input" onkeyup="lookup(this.value,id)"/>
                        </div>
						<?php }else{?>
						<label><input id="theme" id="theme" type="radio" class="test1" value="" name="product_theme" onclick="show(id)" /> 其他 </label>
                        <div class="theme" style="display:none;">
                        	<span><input value="" id="test1" type="text" name="art_style" class="user_input" onkeyup="lookup(this.value,id)"/>
                        </div>
						<?php }?>
                   </span>
                  <div class="clear"></div>
             </div>


             <!--<div class="user_form_line">
                    <span class="with_180">游戏题材：</span> 
                    <span style=" margin-right:0; width:680px;"> 
                	    <label><input type="radio" value="0" <?php if($product_info['product_theme'] == 0){echo 'checked="checked"';} ?> name="product_theme"/> 战争历史 </label>
                        <label><input type="radio" value="1" <?php if($product_info['product_theme'] == 1){echo 'checked="checked"';} ?> name="product_theme"/> 东方仙侠 </label>
                        <label><input type="radio" value="2" <?php if($product_info['product_theme'] == 2){echo 'checked="checked"';} ?> name="product_theme"/> 西方魔幻 </label>
                        <label><input type="radio" value="3" <?php if($product_info['product_theme'] == 3){echo 'checked="checked"';} ?> name="product_theme"/> 近现代 </label>
                        <label><input type="radio" value="4" <?php if($product_info['product_theme'] == 4){echo 'checked="checked"';} ?> name="product_theme"/> 科幻 </label>
                        <label><input type="radio" value="5" <?php if($product_info['product_theme'] == 5){echo 'checked="checked"';} ?> name="product_theme"/> 灾难末世 </label>
                        <div>
                        	<span><input type="text" name="art_style" class="user_input" /> <input type="button" value="自定义" name"art" class="art_xie"></span>
                            <span class="art_host" style=" text-align:center;">东方历史
                                 <div class="art_hosh" id="art_hosh"><img src="<?php echo static_url('public/images/shanchu.gif');?>"></div>
                            </span> 
                            <div class="clear"></div>
                        </div>
                   </span>
                  <div class="clear"></div>
             </div>-->
             <!--题材 end-->

             <div class="user_form_line">
                    <span class="with_180">美术风格：</span> 
                    <span style=" margin-right:0; width:680px;"> 
                	    <label><input id="styles" type="radio" value="写实" <?php if($product_info['product_style'] == '写实'){echo 'checked="checked"';} ?> name="product_style" onclick="hide(id)"/> 写实 </label>
                        <label><input id="styles" type="radio" value="日韩卡通" <?php if($product_info['product_style'] == '日韩卡通'){echo 'checked="checked"';} ?> name="product_style" onclick="hide(id)"/> 日韩卡通 </label>
                        <label><input id="styles" type="radio" value="欧美漫画" <?php if($product_info['product_style'] == '欧美漫画'){echo 'checked="checked"';} ?> name="product_style" onclick="hide(id)"/> 欧美漫画 </label>
                        <label><input id="styles" type="radio" value="Q版" <?php if($product_info['product_style'] == 'Q版'){echo 'checked="checked"';} ?> name="product_style" onclick="hide(id)"/> Q版 </label>
						<?php if($product_info['product_style'] != '写实' && $product_info['product_style'] != '日韩卡通' && $product_info['product_style'] != '欧美漫画' && $product_info['product_style'] != 'Q版' && $product_info['product_style'] != ''){?>
						<label><input id="styles" type="radio" class="test" value="<?php echo $product_info['product_style'];?>" name="product_style" onclick="show(id)" checked="checked"/> 其他 </label>
                        <div class="styles" style="display:block;">
                        	<span><input id="test" value="<?php echo $product_info['product_style'];?>" type="text" name="art_style" class="user_input" onkeyup="lookup(this.value,id)"/>
                        </div>
						<?php }else{?>
						<label><input id="styles" type="radio" class="test" value="" name="product_style" onclick="show(id)"/> 其他 </label>
                        <div class="styles" style="display:none;">
                        	<span><input id="test" value="" type="text" name="art_style" class="user_input" onkeyup="lookup(this.value,id)"/>
                        </div>
						<?php }?>
                   </span>
                  <div class="clear"></div>
             </div>


             <!--<div class="user_form_line">
                    <span class="with_180">美术风格：</span> 
                    <span style=" margin-right:0; width:680px;"> 
                	    <label><input type="radio" value="0" <?php if($product_info['product_style'] == 0){echo 'checked="checked"';} ?> name="product_style"/> 写实 </label>
                        <label><input type="radio" value="1" <?php if($product_info['product_style'] == 1){echo 'checked="checked"';} ?> name="product_style"/> 日韩卡通 </label>
                        <label><input type="radio" value="2" <?php if($product_info['product_style'] == 2){echo 'checked="checked"';} ?> name="product_style"/> 欧美漫画 </label>
                        <label><input type="radio" value="3" <?php if($product_info['product_style'] == 3){echo 'checked="checked"';} ?> name="product_style"/> Q版 </label>
                        <div>
                        	<span><input type="text" name="art_style" class="user_input" /> <input type="button" value="自定义" name"art" class="art_xie"></span>
                            <span class="art_host" style=" text-align:center;">美术风格
                                 <div class="art_hosh" id="art_hosh"><img src="<?php echo static_url('public/images/shanchu.gif');?>"></div>
                            </span> 
                            <div class="clear"></div>
                        </div>
                   </span>
                  <div class="clear"></div>
             </div>-->
              <div class="user_form_line">
                    <span class="with_180">游戏特色：</span> 
                    <span><textarea name="product_feature" rows="7" cols="78" value="" class="suggtext"><?php echo $product_info['product_feature'];?></textarea></span> 
              </div>
              <div class="user_form_line">
                    <span class="with_180">游戏介绍：</span> 
                    <span><textarea name="product_info" rows="7" cols="78" value="" class="suggtext"><?php echo $product_info['product_info'];?></textarea></span> 
              </div> 
              <div class="user_form_line">
              		<span class="with_180">游戏视频：</span>
                    <span><input name="product_video" type="text" value="<?php echo $product_info['product_video'];?>" class="user_input add_input"/></span>
              </div>
              <!--游戏图片 start-->
              <div class="user_form_line">
                    <span class="with_180">游戏图片：</span>
                    <span>
                 	    <div class="app_icort">
						<?php
						if(isset($album) && $album)
						{
							foreach($album as $key=>$val)
							{
						?>
								<p style="width:161px;height:161px;display:block;margin:2px;position:relative;overflow:hidden;border:2px #fff solid;float:left;" class="delpimg_space">
									<img src = <?php echo static_url('uploadfile/image/'.date("Y-m-d",$val["create_time"]).'/180_'.$val["url"]);?> />
									<span class="delpimg pointer" style="display:none;position:absolute;background-color:#666;width:100%;height:30px;line-height:30px;left:0;top:90px;text-align:center;color:#fff;" rel="<?php echo site_url('/user/products/delalbum/'.$val['album_uuid']);?>" title="删除">x</span>
								</p>
							
						<?php
							}
						}?>							
							<div class="clear"></div>
							<link rel="stylesheet" type="text/css" href="<?php echo static_url('public/webuploader/webuploader.css');?>" />
							<link rel="stylesheet" type="text/css" href="<?php echo static_url('public/webuploader/style.css');?>" />
							<link rel="stylesheet" type="text/css" href="<?php echo static_url('public/webuploader/diyUpload.css');?>" />
							 <div id="wrapper" style="margin:0px;">
								<div id="container">
									<!--头部，相册选择和格式选择-->
									<div id="uploader">
										<div class="queueList">
											<div id="dndArea" class="placeholder">
												<div id="filePicker"></div>
												<p>单次最多可选9张，单张最大不超过1M</p>
											</div>
										</div>
										<div class="statusBar" style="display:none;">
											<div class="progress">
												<span class="text">0%</span>
												<span class="percentage"></span>
											</div><div class="info"></div>
											<div class="btns">
												<div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                    </span>
              </div></div>
              <!--游戏图片 end-->
              <div class="user_form_line">
              		<span class="with_180">游戏下载：</span>
                    <span><input name="product_down" type="text" value="<?php echo $product_info['product_down'];?>" class="user_input add_input" original-title="" placeholder="请输入游戏的下载地址"/></span>
              </div>
             <div class="user_form_line prv2"><input type="hidden" name="create_time" value= "<?php echo $product_info['create_time'];?>"><input name="" type="submit" value="继续下一步" class="user_submit"/><input name="company_uuid" type="hidden" value="<?php echo $product_info['company_uuid'];?>"/></div>
      </div>
	  <?php echo form_close();?>
		<!-- 复选框全选 start -->
		<script type="text/javascript">
		function selectAll(checkbox,id)
		{
			$('input[id='+ id + ']').prop('checked', $(checkbox).prop('checked'));
		}

		//其他
		function show(id)
		{
			$('.'+id).css({"display":"block"});
		}

		function hide(id)
		{
			$('.'+id).css({"display":"none"});
		}

		function lookup(str,id) 
		{
			//alert(str);
			$('.'+id).val(str);
		}

		</script>
		<!-- 复选框全选 start -->
	</div>
</div>

<script type="text/javascript" src="<?php echo static_url('public/webuploader/webuploader.nolog.js');?>"></script>
<script type="text/javascript" src="<?php echo static_url('public/webuploader/diyUpload.js');?>"></script>
<script type="text/javascript">

/*
* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
* 其他参数同WebUploader
*/
$(document).ready(function () {
	$('#filePicker').diyUpload({
		url:"<?php echo site_url('/user/upload/img/product/'.$product_info['create_time'].'/'.$product_info['product_uuid']);?>",
		success:function( data ) {
			console.info( data );
		},
		error:function( err ) {
			console.info( err );	
		}
	});
});
</script>