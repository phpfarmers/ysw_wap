        <div class="user_right">
			<div class="user_right_title"><h2>我的头像</h2></div>
			<div class="user_right_content">
			<script type="text/javascript" src="<?php echo static_url('public/js/jquery-pack.js');?>"></script>
			<script type="text/javascript" src="<?php echo static_url('public/js/jquery.imgareaselect-0.3.min.js');?>"></script>
				<?php
					//Only display the javacript if an image has been uploaded
					if(strlen($large_photo_exists)>0){?>
					<script type="text/javascript">
					function preview(img, selection) { 
						var scaleX = <?php echo $thumb_width;?> / selection.width; 
						var scaleY = <?php echo $thumb_height;?> / selection.height; 
						
						$('#thumbnail + div > img').css({ 
							width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px', 
							height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
							marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
							marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
						});
						$('#x1').val(selection.x1);
						$('#y1').val(selection.y1);
						$('#x2').val(selection.x2);
						$('#y2').val(selection.y2);
						$('#w').val(selection.width);
						$('#h').val(selection.height);
					} 

					$(document).ready(function () { 
						$('#save_thumb').click(function() {
							var x1 = $('#x1').val();
							var y1 = $('#y1').val();
							var x2 = $('#x2').val();
							var y2 = $('#y2').val();
							var w = $('#w').val();
							var h = $('#h').val();
							if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
								alert("You must make a selection first");
								return false;
							}else{
								return true;
							}
						});
					}); 

					$(window).load(function () { 
						$('#thumbnail').imgAreaSelect({ aspectRatio: '1:1', onSelectChange: preview }); 
					});

					</script>
					<?php }?>
					<?php
					//Display error message if there are any
					if(isset($error) && strlen($error)>0){
						echo "<ul><li><strong>Error!</strong></li><li>".$error."</li></ul>";
					}
					if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0){
							if(strlen($large_photo_exists)>0){?>
							<h2>当前头像</h2>
							<div align="left">
								<div style="float:left;text-align:center;margin:10px;">
									<span><img src="<?php echo static_url($upload_path.'/180_'.$large_image_name);?>" /></span>
								</div>
								<div style="float:left;text-align:center;margin:10px;"><img src="<?php echo static_url($upload_path.'/100_'.$large_image_name);?>" /></div>
							</div>
							<div  style="clear:both;"></div>
							<h2>制作头像</h2>
							<div align="center">
								<img src="<?php echo static_url($upload_path.'/'.$large_image_name);?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
								<div style="float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
									<img src="<?php echo static_url($upload_path.'/'.$large_image_name);?>" style="position: relative;" alt="Thumbnail Preview" />
								</div>
								<br style="clear:both;"/>
								<form name="thumbnail" action="<?php echo  site_url('user/avatar');?>" method="post">
									<input type="hidden" name="x1" value="" id="x1" />
									<input type="hidden" name="y1" value="" id="y1" />
									<input type="hidden" name="x2" value="" id="x2" />
									<input type="hidden" name="y2" value="" id="y2" />
									<input type="hidden" name="w" value="" id="w" />
									<input type="hidden" name="h" value="" id="h" />
									<input type="submit" name="upload_thumbnail" value="创建" id="save_thumb" />
								</form>
							</div>
						<hr />
						<?php
						}?>
					<?php } ?>
						<h2>上传图片</h2>
						<form name="photo" enctype="multipart/form-data" action="<?php echo site_url('user/avatar');?>" method="post">
						图片 <input type="file" name="image" size="30" /> <input type="submit" name="upload" value="上传" />
						</form>
			</div>
		</div>
	</div>
</div>