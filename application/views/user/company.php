        <div class="user_right">
			<div class="user_right_title"><h2>我的公司</h2></div>
			<div class="user_right_content">
				<script type="text/javascript">
					function lookup(str) {
						if(str.length == 0) {
							$('#auto').hide();
						} else {
							$.post("<?php echo $base_url; ?>index.php/user/company/company_name/" + str, function(data){
								if(data.length >0) {
									$('#auto').show();
									$('#autolist').html(data);
								}
							});
						}
					}
					function fill(value,id) {
						$('#str').val(value);
						$('#company_uuid').val(id);
						setTimeout("$('#auto').hide();", 200);
					}
				</script>
				<?php
				$attr = array('role' => 'form');
				echo form_open("/user/company/", $attr);
				?>
				<div class="company_name">
					<input name="company_name" type="text" class="company_input" value="" id="str" onkeyup="lookup(this.value);" onblur="fill(value,id);"/>
					<input name="company_uuid" id="company_uuid" type="hidden" value=""/>
					<div class="autobox" id="auto" style="display:none;">
						<div class="autolist" id="autolist">
						</div>
					</div>
				</div>
				<div class="company_submit"><input name="" type="submit" value="添加" class="user_submit"/></div>
				<?php echo '</form>';?>
			</div>
		</div>
	</div>
</div>