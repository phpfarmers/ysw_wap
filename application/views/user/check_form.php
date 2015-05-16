<?php if($sid == 2){?>

<!-- 发行/独代 start -->
<div style="width:100%;height:15px;float:left;"></div>
<div class="user_form_line">
	  <span class="with_120">合作公司要求：</span><?php $requires = explode(',',$info['requires']);?>
	  <span><label><input type="checkbox" name="requires[]" value="0" <?php if(in_array('0',$requires)){echo 'checked="checked"';}?>/> 本地 </label> <label><input type="checkbox" name="requires[]" value="1" <?php if(in_array('1',$requires)){echo 'checked="checked"';}?>/> 公司验证 </label></span>
	  <p style="color:#F00;font:normal normal normal 12px/36px 宋体; margin-left:130px;">不满足条件的用户将不能查看你的联系方式</p>
</div>
<div class="user_form_line">
	  <span class="with_120">合作类型：</span> 
	  <span>
		 <label><input type="radio" name="financing" value="0" <?php if($info['financing']==0){echo 'checked="checked"';}?>/> 独代 </label>
		 <!--<label><input type="radio" name="financing" value="1" <?php if($info['financing']==1){echo 'checked="checked"';}?>/> 联运 </label>-->
		 <label><input type="radio" name="financing" value="2" <?php if($info['financing']==2){echo 'checked="checked"';}?>/> 产品收购 </label> 
	 </span> 
</div>
<div class="user_form_line">
	  <span class="with_120">合作区域：</span> 
	  <span><?php $area = explode(',',$info['area']);?> 
			<label><input id="area" name="area[]" type="checkbox" value="1" <?php if(in_array('1',$area)){echo 'checked="checked"';}?>/> 国内 </label>
			<label><input id="area" name="area[]" type="checkbox" value="2" <?php if(in_array('2',$area)){echo 'checked="checked"';}?>/> 北美 </label>
			<label><input id="area" name="area[]" type="checkbox" value="3" <?php if(in_array('3',$area)){echo 'checked="checked"';}?>/> 南美 </label>
			<label><input id="area" name="area[]" type="checkbox" value="4" <?php if(in_array('4',$area)){echo 'checked="checked"';}?>/> 东南亚 </label>
			<label><input id="area" name="area[]" type="checkbox" value="5" <?php if(in_array('5',$area)){echo 'checked="checked"';}?>/> 日韩 </label>
			<label><input id="area" name="area[]" type="checkbox" value="6" <?php if(in_array('6',$area)){echo 'checked="checked"';}?>/> 西亚 </label>
			<label><input id="area" name="area[]" type="checkbox" value="7" <?php if(in_array('7',$area)){echo 'checked="checked"';}?>/> 非洲 </label>
			<label><input id="area" name="area[]" type="checkbox" value="8" <?php if(in_array('8',$area)){echo 'checked="checked"';}?>/> 欧洲 </label>
			<label><input id="area" name="area[]" type="checkbox" value="9" <?php if(in_array('9',$area)){echo 'checked="checked"';}?>/> 其他 </label>
	   </span>
</div>
<div class="user_form_line">
	  <span class="with_120">代理费：</span> 
	  <span><input id="amount" onkeyup="check(id);" name="amount" value="<?php if($info['amount']!= 0){echo $info['amount'];}?>" type="text" class="user_input" style="width:120px;"/> ￥</span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作对象数量：</span>
	  <span>
			<label><input type="radio" name="partner_num" value="0" <?php if($info['partner_num']==0){echo 'checked="checked"';}?>/> 单人 </label> 
			<label><input type="radio" name="partner_num" value="1" <?php if($info['partner_num']==1){echo 'checked="checked"';}?>/> 多人 </label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作有效期：</span> 
	  <span>
			 <label><input name="end_year" value="<?php if($info['end_time']!=0){echo date('Y',$info['end_time']);}?>" type="text" class="user_input1" maxlength="4"/> 年</label>
			 <label><input name="end_mouth" value="<?php if($info['end_time']!=0){echo date('m',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 月 </label>
			 <label><input name="end_day" value="<?php if($info['end_time']!=0){echo date('d',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 日</label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">说明：</span> 
	  <span><textarea name="info" rows="5" cols="100" class="speed_textarea"><?php echo $info['info'];?></textarea></span>
</div>
<!-- 发行/独代 end -->

<?php }else if($sid == 4){?>

<!-- 找投资 start -->
<div style="width:100%;height:15px;float:left;"></div>
<div class="user_form_line">
	<span class="with_120">项目阶段：</span>
	<span>
		<?php foreach($step as $row):?>
		<label><input type="radio" value="<?php echo $row['id'];?>" name="product_step" <?php if($info['product_step']==$row['id']){echo 'checked="checked"';}?>> <?php echo $row['name'];?></label>
		<?php endforeach;?>
	</span>
</div>
<div class="user_form_line">
	  <span class="with_120">团队阶段：</span> 
	  <span>
			 <label><input type="radio" name="team_step" value="0" <?php if($info['team_step']==0){echo 'checked="checked"';}?>/> 暂无收入 </label> 
			 <label><input type="radio" name="team_step" value="1" <?php if($info['team_step']==1){echo 'checked="checked"';}?>/> 稍有流水 </label>
			 <label><input type="radio" name="team_step" value="2" <?php if($info['team_step']==2){echo 'checked="checked"';}?>/> 有盈利 </label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120"><em>*</em>融资金额：</span> 
	  <span><label><input id="amount" onkeyup="check(id);" name="amount" value="<?php if($info['amount']!= 0){echo $info['amount'];}?>" type="text" class="user_input" style="width:120px;"/> ￥ </label></span>
</div>
<div class="user_form_line">
	  <span class="with_120"><em>*</em>出让股份：</span> 
	  <span><label><input id="stock" onkeyup="check(id);" name="stock" value="<?php if($info['stock']!= 0){echo $info['stock'];}?>" type="text" class="user_input" style="width:120px;"/> % </label> </span>
</div>
<div class="user_form_line">
	  <span class="with_120">融资周期：</span> 
	  <span><label><input id="cycle" onkeyup="check(id);" name="cycle" value="<?php if($info['cycle']!= 0){echo $info['cycle'];}?>" type="text" class="user_input"  style="width:120px;"/> 天 </label> </span>
</div>
<div class="user_form_line">
	  <span class="with_120">商业计划书：</span> 
	  <span><?php if($info['prospectus']){echo $info['prospectus'];}?> <input name="prospectus" type="file" id="prospectus" size="40" /></span>
</div>
<div class="user_form_line">
	  <span class="with_120"><em>*</em>融资阶段：</span> 
	  <span>
			 <label><input type="radio" name="financing" value="0" <?php if($info['financing']==0){echo 'checked="checked"';}?>/> 天使 </label>
			 <label><input type="radio" name="financing" value="1" <?php if($info['financing']==1){echo 'checked="checked"';}?>/> Pre-A轮 </label>
			 <label><input type="radio" name="financing" value="2" <?php if($info['financing']==2){echo 'checked="checked"';}?>/> B轮 </label>
			 <label><input type="radio" name="financing" value="3" <?php if($info['financing']==3){echo 'checked="checked"';}?>/> C轮 </label> 
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作对象数量：</span> 
	  <span>
			<label><input type="radio" name="partner_num" value="0" <?php if($info['partner_num']==0){echo 'checked="checked"';}?>/> 单人 </label> 
			<label><input type="radio" name="partner_num" value="1" <?php if($info['partner_num']==1){echo 'checked="checked"';}?>/> 多人 </label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">说明：</span> 
	  <span><textarea name="info" rows="5" cols="100" class="speed_textarea"><?php echo $info['info'];?></textarea></span>
</div>
<!-- 找投资 end -->

<?php }else if($sid == 5){?>

<!-- 美术外包 start -->
<div class="user_form_line">
	  <span class="with_120">外包预算：</span> 
	  <span><input id="amount" onkeyup="check(id);" name="amount" value="<?php if($info['amount']!= 0){echo $info['amount'];}?>" type="text" class="user_input" style="width:120px;"/> ￥</span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作公司要求：</span><?php $requires = explode(',',$info['requires']);?>
	  <span><label><input type="checkbox" name="requires[]" value="0" <?php if(in_array('0',$requires)){echo 'checked="checked"';}?>/> 本地 </label> <label><input type="checkbox" name="requires[]" value="1" <?php if(in_array('1',$requires)){echo 'checked="checked"';}?>/> 公司验证 </label></span>
	  <p style="color:#F00;font:normal normal normal 12px/36px 宋体; margin-left:130px;">不满足条件的用户将不能查看你的联系方式</p>
</div>
<div class="user_form_line">
	  <span class="with_120">完成时间：</span> 
	  <span style="text-align:left;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="0" <?php if($info['cycle']!=0){echo 'checked="checked"';}?>/> 签约后</label><input id="cycle" onkeyup="check(id);" name="cycle" value="<?php if($info['cycle']!=0){echo $info['cycle'];}?>" type="text" class="user_input1" /> 天内完成
		<div class="clear"></div>
		<span style=" margin-top:20px;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="1" <?php if($info['limit_time']!=0){echo 'checked="checked"';}?>/> 限定时间至</label><input id="limit_time"  name="limit_time" value="<?php if($info['limit_time']!=0 ){echo date('Y-m-d',$info['limit_time']);}?>" type="text" class="user_input1" style="width:150px;"/></span>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">美术风格：</span> 
	  <span><input type="text" name="styles" class="user_input" value="<?php echo $info['styles'];?>" style="width:700px;"/></span>
</div>
<div class="user_form_line">
	  <span class="with_120">制作内容：</span> 
	  <span style="width:790px;float:left;">
		  <div id="add_content">
			  <?php 
				$serialize = unserialize($info['content_serialize']);
				if($serialize){
					$i = 0;
					foreach($serialize as $key=>$value)
					{
						echo '<div><input name="serialize_key[]" type="text" class="art_mag" value="'.$key.'" placeholder="输入内容" maxlength="10"/><input name="serialize_value[]" value="'.$value.'" placeholder="输入数量" type="text" class="art_mag" maxlength="10"/>';
						if($i++ > 0)
						{
							echo '<a class="bbb" id="aaa'.$i++.'" onclick="delXie(id)">删除</a>';
						}
						else
						{
							echo '<a class="bbb" id="aaa'.$i++.'" onclick="addXie(id)">添加</a>';
						}
						echo '</div><div class="clear"></div>';
					}
				?>
			  <?php }else{?>
				  <input name="serialize_key[]" type="text" class="art_mag" value="" placeholder="输入内容" maxlength="10"/><input name="serialize_value[]" value="" placeholder="输入数量" type="text" class="art_mag" maxlength="10"/><a name="art" onclick="addXie(id)" id="art_xie">添加</a>
				  <div class="clear"></div>
			  <?php }?>
		  </div>
		  <p style="float:left;color:#FF0000;text-align:left;font:normal normal normal 12px/36px 宋体;">请添加要外包的内容及数量，例如：原画，动画，特效，UI ……</p>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作对象数量：</span>
	  <span>
			<label><input type="radio" name="partner_num" value="0" <?php if($info['partner_num']==0){echo 'checked="checked"';}?>/> 单人 </label> 
			<label><input type="radio" name="partner_num" value="1" <?php if($info['partner_num']==1){echo 'checked="checked"';}?>/> 多人 </label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作有效期：</span> 
	  <span>
			 <label><input name="end_year" value="<?php if($info['end_time']!=0){echo date('Y',$info['end_time']);}?>" type="text" class="user_input1" maxlength="4"/> 年</label>
			 <label><input name="end_mouth" value="<?php if($info['end_time']!=0){echo date('m',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 月 </label>
			 <label><input name="end_day" value="<?php if($info['end_time']!=0){echo date('d',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 日</label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">说明：</span> 
	  <span><textarea name="info" rows="5" cols="100" class="speed_textarea"><?php echo $info['info'];?></textarea></span>
</div>
<!-- 美术外包 end -->

<?php }else if($sid == 6){?>

<!-- 找渠道 start -->
<div style="width:100%;height:15px;float:left;"></div>
<div class="user_form_line">
	  <span class="with_120" style="float:left;">平台类型：</span> 
	  <span style="width:700px;float:left;">
			<?php
			$plat = explode(',',$info['platform']);
			foreach($platform as $key=>$value)
			{
				if(in_array($key,$plat))
				{
					echo '<label><input type="checkbox" name="platform[]" value="'.$key.'" checked="checked"/> '.$value.' </label>';
				}
				else
				{
					echo '<label><input type="checkbox" name="platform[]" value="'.$key.'"/> '.$value.' </label>';
				}
			}
			?>
	  </span>
	  <div class="clear"></div>
</div>
<div class="user_form_line">
	  <span class="with_120">合作模式：</span> 
	  <span>
			<label><input type="radio" name="financing" value="0" <?php if($info['financing']==0){echo 'checked="checked"';}?>/> 联运 </label> 
			<label><input type="radio" name="financing" value="1" <?php if($info['financing']==1){echo 'checked="checked"';}?>/> 混服 </label> 
			<label><input type="radio" name="financing" value="2" <?php if($info['financing']==2){echo 'checked="checked"';}?>/> CPA合作  </label> 
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作对象数量：</span> 
	  <span>
			<label><input type="radio" name="partner_num" value="0" <?php if($info['partner_num']==0){echo 'checked="checked"';}?>/> 单人 </label> 
			<label><input type="radio" name="partner_num" value="1" <?php if($info['partner_num']==1){echo 'checked="checked"';}?>/> 多人 </label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作有效期：</span> 
	  <span>
			 <label><input name="end_year" value="<?php if($info['end_time']!=0){echo date('Y',$info['end_time']);}?>" type="text" class="user_input1" maxlength="4"/> 年</label>
			 <label><input name="end_mouth" value="<?php if($info['end_time']!=0){echo date('m',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 月 </label>
			 <label><input name="end_day" value="<?php if($info['end_time']!=0){echo date('d',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 日</label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">说明：</span> 
	  <span><textarea name="info" rows="5" cols="100" class="speed_textarea"><?php echo $info['info'];?></textarea></span>
</div>
<!-- 找渠道 end -->

<?php }else if($sid == 7){?>

<!-- 找外包 start -->
<div class="user_form_line">
	  <input name="grade_id" id="grade_id" gid="<?php echo $grade[0]['id'];?>" sid="<?php echo urlencode(base64_encode($grade[0]['id']));?>" type="hidden" />
	  <div class="artout">
			  <span>
					<?php foreach ($grade as $row){?>
					 <label><input id="show_<?php echo $row['id'];?>" type="radio" value="<?php echo $row['id'];?>" sid="<?php echo urlencode(base64_encode($row['id']));?>" onclick="show_target_from(id)" name="task_target_id_1" /> <?php echo $row['name'];?> </label>
					<?php } ?>
			  </span>
			  <div class="clear"></div>
	  </div>  
</div>
<!-- 找外包 end -->

<?php }else if($sid == 8){?>

<!-- IDC合作 start -->
<div style="width:100%;height:15px;float:left;"></div>
<div class="user_form_line">
	  <span class="with_120">合作公司要求：</span><?php $requires = explode(',',$info['requires']);?>
	  <span><label><input type="checkbox" name="requires[]" value="0" <?php if(in_array('0',$requires)){echo 'checked="checked"';}?>/> 本地 </label> <label><input type="checkbox" name="requires[]" value="1" <?php if(in_array('1',$requires)){echo 'checked="checked"';}?>/> 公司验证 </label></span>
	  <p style="color:#F00;font:normal normal normal 12px/36px 宋体; margin-left:130px;">不满足条件的用户将不能查看你的联系方式</p>
</div>
<div class="user_form_line">
	  <span class="with_120">完成时间：</span> 
	  <span style="text-align:left;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="0" <?php if($info['cycle']!=0){echo 'checked="checked"';}?>/> 签约后</label><input id="cycle" onkeyup="check(id);" name="cycle" value="<?php if($info['cycle']!=0){echo $info['cycle'];}?>" type="text" class="user_input1" /> 天内完成
		<div class="clear"></div>
		<span style=" margin-top:20px;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="1" <?php if($info['limit_time']!=0){echo 'checked="checked"';}?>/> 限定时间至</label><input id="limit_time"  name="limit_time" value="<?php if($info['limit_time']!=0 ){echo date('Y-m-d',$info['limit_time']);}?>" type="text" class="user_input1" style="width:150px;"/></span>
	  </span>
</div>
 <div class="user_form_line">
	  <span class="with_120">合作类型：</span> 
	  <span>
		 <label><input type="radio" name="partner_type" value="0" <?php if($info['partner_type']==0){echo 'checked="checked"';}?>/> 空间租赁 </label>
		 <label><input type="radio" name="partner_type" value="1" <?php if($info['partner_type']==1){echo 'checked="checked"';}?>/> 服务器托管 </label>
		 <label><input type="radio" name="partner_type" value="2" <?php if($info['partner_type']==2){echo 'checked="checked"';}?>/> 云服务 </label> 
	 </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作对象数量：</span>
	  <span>
			<label><input type="radio" name="partner_num" value="0" <?php if($info['partner_num']==0){echo 'checked="checked"';}?>/> 单人 </label> 
			<label><input type="radio" name="partner_num" value="1" <?php if($info['partner_num']==1){echo 'checked="checked"';}?>/> 多人 </label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作有效期：</span> 
	  <span>
			 <label><input name="end_year" value="<?php if($info['end_time']!=0){echo date('Y',$info['end_time']);}?>" type="text" class="user_input1" maxlength="4"/> 年</label>
			 <label><input name="end_mouth" value="<?php if($info['end_time']!=0){echo date('m',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 月 </label>
			 <label><input name="end_day" value="<?php if($info['end_time']!=0){echo date('d',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 日</label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">说明：</span> 
	  <span><textarea name="info" rows="5" cols="100" class="speed_textarea"><?php echo $info['info'];?></textarea></span>
</div>
<!-- IDC合作 end -->

<?php }else if($sid == 9){?>

<!-- 各类证照申请 start -->
<div style="width:100%;height:15px;float:left;"></div>
<!--<div class="user_form_line">
	  <span class="with_120">合作公司要求：</span><?php $requires = explode(',',$info['requires']);?>
	  <span><label><input type="checkbox" name="requires[]" value="0" <?php if(in_array('0',$requires)){echo 'checked="checked"';}?>/> 本地 </label> <label><input type="checkbox" name="requires[]" value="1" <?php if(in_array('1',$requires)){echo 'checked="checked"';}?>/> 公司验证 </label></span>
	  <p style="color:#F00;font:normal normal normal 12px/36px 宋体; margin-left:130px;">不满足条件的用户将不能查看你的联系方式</p>
</div>-->
<div class="user_form_line">
	  <span class="with_120">完成时间：</span> 
	  <span style="text-align:left;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="0" <?php if($info['cycle']!=0){echo 'checked="checked"';}?>/> 签约后</label><input id="cycle" onkeyup="check(id);" name="cycle" value="<?php if($info['cycle']!=0){echo $info['cycle'];}?>" type="text" class="user_input1" /> 天内完成
		<div class="clear"></div>
		<span style=" margin-top:20px;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="1" <?php if($info['limit_time']!=0){echo 'checked="checked"';}?>/> 限定时间至</label><input id="limit_time"  name="limit_time" value="<?php if($info['limit_time']!=0 ){echo date('Y-m-d',$info['limit_time']);}?>" type="text" class="user_input1" style="width:150px;"/></span>
	  </span>
</div>
 <div class="user_form_line">
	  <span class="with_120">证件类型：</span> 
	  <span>
		 <label><input type="radio" name="styles" value="0" <?php if($info['styles']==0){echo 'checked="checked"';}?>/> 著作权 </label>
		 <label><input type="radio" name="styles" value="1" <?php if($info['styles']==1){echo 'checked="checked"';}?>/> 版号 </label>
		 <label><input type="radio" name="styles" value="2" <?php if($info['styles']==2){echo 'checked="checked"';}?>/> 文网文 </label> 
	 </span>
	  
</div>

<div class="user_form_line">
	  <span class="with_120">合作对象数量：</span>
	  <span>
			<label><input type="radio" name="partner_num" value="0" <?php if($info['partner_num']==0){echo 'checked="checked"';}?>/> 单人 </label> 
			<label><input type="radio" name="partner_num" value="1" <?php if($info['partner_num']==1){echo 'checked="checked"';}?>/> 多人 </label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作有效期：</span> 
	  <span>
			 <label><input name="end_year" value="<?php if($info['end_time']!=0){echo date('Y',$info['end_time']);}?>" type="text" class="user_input1" maxlength="4"/> 年</label>
			 <label><input name="end_mouth" value="<?php if($info['end_time']!=0){echo date('m',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 月 </label>
			 <label><input name="end_day" value="<?php if($info['end_time']!=0){echo date('d',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 日</label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">说明：</span> 
	  <span><textarea name="info" rows="5" cols="100" class="speed_textarea"><?php echo $info['info'];?></textarea></span>
</div>
<!-- 各类证照申请 end -->

<?php }else if($sid == 10){?>

<!-- 宣传合作 start -->
<div style="width:100%;height:15px;float:left;"></div>
<div class="user_form_line">
	  <span class="with_120">宣传预算：</span> 
	  <span><input id="amount" onkeyup="check(id);" name="amount" value="<?php if($info['amount']!= 0){echo $info['amount'];}?>" type="text" class="user_input" style="width:120px;"/> ￥</span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作公司要求：</span><?php $requires = explode(',',$info['requires']);?>
	  <span><label><input type="checkbox" name="requires[]" value="0" <?php if(in_array('0',$requires)){echo 'checked="checked"';}?>/> 本地 </label> <label><input type="checkbox" name="requires[]" value="1" <?php if(in_array('1',$requires)){echo 'checked="checked"';}?>/> 公司验证 </label></span>
	  <p style="color:#F00;font:normal normal normal 12px/36px 宋体; margin-left:130px;">不满足条件的用户将不能查看你的联系方式</p>
</div>
<div class="user_form_line">
	  <span class="with_120">合作类型：</span> 
	  <span><?php $partner_type = explode(',',$info['partner_type']);?>
		 <label><input type="checkbox" name="partner_type[]" value="0" <?php if(in_array('0',$partner_type)){echo 'checked="checked"';}?>/> 方案整包 </label>
		 <label><input type="checkbox" name="partner_type[]" value="1" <?php if(in_array('1',$partner_type)){echo 'checked="checked"';}?>/> 广告投放 </label>
		 <label><input type="checkbox" name="partner_type[]" value="2" <?php if(in_array('2',$partner_type)){echo 'checked="checked"';}?>/> 媒体合作 </label> 
		 <label><input type="checkbox" name="partner_type[]" value="3" <?php if(in_array('3',$partner_type)){echo 'checked="checked"';}?>/> 线下活动 </label>
		 <label><input type="checkbox" name="partner_type[]" value="4" <?php if(in_array('4',$partner_type)){echo 'checked="checked"';}?>/> 异业合作 </label>
	 </span> 
</div>
<div class="user_form_line">
	  <span class="with_120">合作方式：</span> 
	  <span><?php $partner_method = explode(',',$info['partner_method']);?>
		 <label><input type="checkbox" name="partner_method[]" value="0" <?php if(in_array('0',$partner_method)){echo 'checked="checked"';}?>/> CPA </label>
		 <label><input type="checkbox" name="partner_method[]" value="1" <?php if(in_array('1',$partner_method)){echo 'checked="checked"';}?>/> CPS </label>
		 <label><input type="checkbox" name="partner_method[]" value="2" <?php if(in_array('2',$partner_method)){echo 'checked="checked"';}?>/> CPT </label> 
		 <label><input type="checkbox" name="partner_method[]" value="3" <?php if(in_array('3',$partner_method)){echo 'checked="checked"';}?>/> 其他 </label>
	 </span> 
</div>
<div class="user_form_line">
	  <span class="with_120">宣传时间：</span> 
	  <span>
			 <label><input name="start_year" value="<?php if($info['start_time']!=0){echo date('Y',$info['start_time']);}?>" type="text" class="user_input1" maxlength="4"/> 年</label>
			 <label><input name="start_mouth" value="<?php if($info['start_time']!=0){echo date('m',$info['start_time']);}?>" type="text" class="user_input2" maxlength="2"/> 月 </label>
			 <label><input name="start_day" value="<?php if($info['start_time']!=0){echo date('d',$info['start_time']);}?>" type="text" class="user_input2" maxlength="2"/> 日</label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作对象数量：</span>
	  <span>
			<label><input type="radio" name="partner_num" value="0" <?php if($info['partner_num']==0){echo 'checked="checked"';}?>/> 单人 </label> 
			<label><input type="radio" name="partner_num" value="1" <?php if($info['partner_num']==1){echo 'checked="checked"';}?>/> 多人 </label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作有效期：</span> 
	  <span>
			 <label><input name="end_year" value="<?php if($info['end_time']!=0){echo date('Y',$info['end_time']);}?>" type="text" class="user_input1" maxlength="4"/> 年</label>
			 <label><input name="end_mouth" value="<?php if($info['end_time']!=0){echo date('m',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 月 </label>
			 <label><input name="end_day" value="<?php if($info['end_time']!=0){echo date('d',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 日</label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">说明：</span> 
	  <span><textarea name="info" rows="5" cols="100" class="speed_textarea"><?php echo $info['info'];?></textarea></span>
</div>
<!-- 宣传合作 end -->

<?php }else if($sid == 11){?>

<!--  音乐音效外包 start -->
<div class="user_form_line">
	  <span class="with_120">外包预算：</span> 
	  <span><input id="amount" onkeyup="check(id);" name="amount" value="<?php if($info['amount']!= 0){echo $info['amount'];}?>" type="text" class="user_input" style="width:120px;"/> ￥</span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作公司要求：</span><?php $requires = explode(',',$info['requires']);?>
	  <span><label><input type="checkbox" name="requires[]" value="0" <?php if(in_array('0',$requires)){echo 'checked="checked"';}?>/> 本地 </label> <label><input type="checkbox" name="requires[]" value="1" <?php if(in_array('1',$requires)){echo 'checked="checked"';}?>/> 公司验证 </label></span>
	  <p style="color:#F00;font:normal normal normal 12px/36px 宋体; margin-left:130px;">不满足条件的用户将不能查看你的联系方式</p>
</div>
<div class="user_form_line">
	  <span class="with_120">完成时间：</span> 
	  <span style="text-align:left;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="0" <?php if($info['cycle']!=0){echo 'checked="checked"';}?>/> 签约后</label><input id="cycle" onkeyup="check(id);" name="cycle" value="<?php if($info['cycle']!=0){echo $info['cycle'];}?>" type="text" class="user_input1" /> 天内完成
		<div class="clear"></div>
		<span style=" margin-top:20px;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="1" <?php if($info['limit_time']!=0){echo 'checked="checked"';}?>/> 限定时间至</label><input id="limit_time"  name="limit_time" value="<?php if($info['limit_time']!=0 ){echo date('Y-m-d',$info['limit_time']);}?>" type="text" class="user_input1" style="width:150px;"/></span>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">音乐风格：</span> 
	  <span><input type="text" name="styles" class="user_input" value="<?php echo $info['styles'];?>" style="width:700px;"/></span>
</div>
<div class="user_form_line">
	  <span class="with_120">制作内容：</span> 
	  <span style="width:790px;float:left;">
		  <div id="add_content">
			<?php 
				$serialize = unserialize($info['content_serialize']);
				if($serialize){
					$i = 0;
					foreach($serialize as $key=>$value)
					{
						echo '<div><input name="serialize_key[]" type="text" class="art_mag" value="'.$key.'" placeholder="输入内容" maxlength="10"/><input name="serialize_value[]" value="'.$value.'" placeholder="输入数量" type="text" class="art_mag" maxlength="10"/>';
						if($i++ > 0)
						{
							echo '<a class="bbb" id="aaa'.$i++.'" onclick="delXie(id)">删除</a>';
						}
						else
						{
							echo '<a class="bbb" id="aaa'.$i++.'" onclick="addXie(id)">添加</a>';
						}
						echo '</div><div class="clear"></div>';
					}
				?>
			  <?php }else{?>
				  <input name="serialize_key[]" type="text" class="art_mag" value="" placeholder="输入内容" maxlength="10"/><input name="serialize_value[]" value="" placeholder="输入数量" type="text" class="art_mag" maxlength="10"/><a name="art" onclick="addXie(id)" id="art_xie">添加</a>
				  <div class="clear"></div>
			  <?php }?>
		  </div>
		  <p style="float:left;color:#FF0000;text-align:left;font:normal normal normal 12px/36px 宋体;">请添加要外包的内容及数量，例如：背景音乐，主题曲，音效 ……</p>
	  </span>
</div>

<div class="user_form_line">
	  <span class="with_120">合作对象数量：</span>
	  <span>
			<label><input type="radio" name="partner_num" value="0" <?php if($info['partner_num']==0){echo 'checked="checked"';}?>/> 单人 </label> 
			<label><input type="radio" name="partner_num" value="1" <?php if($info['partner_num']==1){echo 'checked="checked"';}?>/> 多人 </label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作有效期：</span> 
	  <span>
			 <label><input name="end_year" value="<?php if($info['end_time']!=0){echo date('Y',$info['end_time']);}?>" type="text" class="user_input1" maxlength="4"/> 年</label>
			 <label><input name="end_mouth" value="<?php if($info['end_time']!=0){echo date('m',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 月 </label>
			 <label><input name="end_day" value="<?php if($info['end_time']!=0){echo date('d',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 日</label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">说明：</span> 
	  <span><textarea name="info" rows="5" cols="100" class="speed_textarea"><?php echo $info['info'];?></textarea></span>
</div>
<!--  音乐音效外包 end -->

<?php }else if($sid == 12){?>

<!-- 网站制作外包 start -->
<div class="user_form_line">
	  <span class="with_120">外包预算：</span> 
	  <span><input id="amount" onkeyup="check(id);" name="amount" value="<?php if($info['amount']!= 0){echo $info['amount'];}?>" type="text" class="user_input" style="width:120px;"/> ￥</span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作公司要求：</span><?php $requires = explode(',',$info['requires']);?>
	  <span><label><input type="checkbox" name="requires[]" value="0" <?php if(in_array('0',$requires)){echo 'checked="checked"';}?>/> 本地 </label> <label><input type="checkbox" name="requires[]" value="1" <?php if(in_array('1',$requires)){echo 'checked="checked"';}?>/> 公司验证 </label></span>
	  <p style="color:#F00;font:normal normal normal 12px/36px 宋体; margin-left:130px;">不满足条件的用户将不能查看你的联系方式</p>
</div>
<div class="user_form_line">
	  <span class="with_120">完成时间：</span> 
	  <span style="text-align:left;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="0" <?php if($info['cycle']!=0){echo 'checked="checked"';}?>/> 签约后</label><input id="cycle" onkeyup="check(id);" name="cycle" value="<?php if($info['cycle']!=0){echo $info['cycle'];}?>" type="text" class="user_input1" /> 天内完成
		<div class="clear"></div>
		<span style=" margin-top:20px;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="1" <?php if($info['limit_time']!=0){echo 'checked="checked"';}?>/> 限定时间至</label><input id="limit_time"  name="limit_time" value="<?php if($info['limit_time']!=0 ){echo date('Y-m-d',$info['limit_time']);}?>" type="text" class="user_input1" style="width:150px;"/></span>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">网站类型：</span><?php $styles = explode(',',$info['styles']);?>
	  <span><label><input type="checkbox" name="styles[]" value="0" <?php if(in_array('0',$styles)){echo 'checked="checked"';}?>/> 公司网站</label></span>  
	  <span><label><input type="checkbox" name="styles[]" value="1" <?php if(in_array('1',$styles)){echo 'checked="checked"';}?>/> 产品网站</label></span>
	  <span><label><input type="checkbox" name="styles[]" value="2" <?php if(in_array('2',$styles)){echo 'checked="checked"';}?>/> 其他</label></span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作对象数量：</span>
	  <span>
			<label><input type="radio" name="partner_num" value="0" <?php if($info['partner_num']==0){echo 'checked="checked"';}?>/> 单人 </label> 
			<label><input type="radio" name="partner_num" value="1" <?php if($info['partner_num']==1){echo 'checked="checked"';}?>/> 多人 </label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作有效期：</span> 
	  <span>
			 <label><input name="end_year" value="<?php if($info['end_time']!=0){echo date('Y',$info['end_time']);}?>" type="text" class="user_input1" maxlength="4"/> 年</label>
			 <label><input name="end_mouth" value="<?php if($info['end_time']!=0){echo date('m',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 月 </label>
			 <label><input name="end_day" value="<?php if($info['end_time']!=0){echo date('d',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 日</label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">说明：</span> 
	  <span><textarea name="info" rows="5" cols="100" class="speed_textarea"><?php echo $info['info'];?></textarea></span>
</div>
<!-- 网站制作外包 end -->

<?php }else if($sid == 13){?>

<!-- 视频制作外包 start -->
<div class="user_form_line">
	  <span class="with_120">外包预算：</span> 
	  <span><input id="amount" onkeyup="check(id);" name="amount" value="<?php if($info['amount']!= 0){echo $info['amount'];}?>" type="text" class="user_input" style="width:120px;"/> ￥</span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作公司要求：</span><?php $requires = explode(',',$info['requires']);?>
	  <span><label><input type="checkbox" name="requires[]" value="0" <?php if(in_array('0',$requires)){echo 'checked="checked"';}?>/> 本地 </label> <label><input type="checkbox" name="requires[]" value="1" <?php if(in_array('1',$requires)){echo 'checked="checked"';}?>/> 公司验证 </label></span>
	  <p style="color:#F00;font:normal normal normal 12px/36px 宋体; margin-left:130px;">不满足条件的用户将不能查看你的联系方式</p>
</div>
<div class="user_form_line">
	  <span class="with_120">完成时间：</span> 
	  <span style="text-align:left;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="0" <?php if($info['cycle']!=0){echo 'checked="checked"';}?>/> 签约后</label><input id="cycle" onkeyup="check(id);" name="cycle" value="<?php if($info['cycle']!=0){echo $info['cycle'];}?>" type="text" class="user_input1" /> 天内完成
		<div class="clear"></div>
		<span style=" margin-top:20px;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="1" <?php if($info['limit_time']!=0){echo 'checked="checked"';}?>/> 限定时间至</label><input id="limit_time"  name="limit_time" value="<?php if($info['limit_time']!=0 ){echo date('Y-m-d',$info['limit_time']);}?>" type="text" class="user_input1" style="width:150px;"/></span>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">制作内容：</span> 
	  <span style="width:790px;float:left;">
		  <div id="add_content">
			<?php 
			$serialize = unserialize($info['content_serialize']);
			if($serialize){
				$i = 0;
				foreach($serialize as $key=>$value)
				{
					echo '<div><input name="serialize_key[]" type="text" class="art_mag" value="'.$key.'" placeholder="输入内容" maxlength="10"/><input name="serialize_value[]" value="'.$value.'" placeholder="输入秒数" type="text" class="art_mag" maxlength="10"/>';
					if($i++ > 0)
					{
						echo '<a class="bbb" id="aaa'.$i++.'" onclick="delXie(id)">删除</a>';
					}
					else
					{
						echo '<a class="bbb" id="aaa'.$i++.'" onclick="addXie(id)">添加</a>';
					}
					echo '</div><div class="clear"></div>';
				}
			?>
		  <?php }else{?>
			  <input name="serialize_key[]" type="text" class="art_mag" value="" placeholder="输入内容" maxlength="10"/><input name="serialize_value[]" value="" placeholder="输入秒数" type="text" class="art_mag" maxlength="10"/><a name="art" onclick="addXie(id)" id="art_xie">添加</a>
			  <div class="clear"></div>
		  <?php }?>
		  </div>
		  <p style="float:left;color:#FF0000;text-align:left;font:normal normal normal 12px/36px 宋体;">请添加要外包的内容及时间，例如：开场CG，宣传视频，游戏展示视频 ……</p>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作对象数量：</span>
	  <span>
			<label><input type="radio" name="partner_num" value="0" <?php if($info['partner_num']==0){echo 'checked="checked"';}?>/> 单人 </label> 
			<label><input type="radio" name="partner_num" value="1" <?php if($info['partner_num']==1){echo 'checked="checked"';}?>/> 多人 </label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作有效期：</span> 
	  <span>
			 <label><input name="end_year" value="<?php if($info['end_time']!=0){echo date('Y',$info['end_time']);}?>" type="text" class="user_input1" maxlength="4"/> 年</label>
			 <label><input name="end_mouth" value="<?php if($info['end_time']!=0){echo date('m',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 月 </label>
			 <label><input name="end_day" value="<?php if($info['end_time']!=0){echo date('d',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 日</label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">说明：</span> 
	  <span><textarea name="info" rows="5" cols="100" class="speed_textarea"><?php echo $info['info'];?></textarea></span>
</div>
<!-- 视频制作外包 end -->

<?php }else if($sid == 14){?>

<!-- 产品测试外包 start -->
<div class="user_form_line">
	  <span class="with_120">外包预算：</span> 
	  <span><input id="amount" onkeyup="check(id);" name="amount" value="<?php if($info['amount']!= 0){echo $info['amount'];}?>" type="text" class="user_input" style="width:120px;"/> ￥</span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作公司要求：</span><?php $requires = explode(',',$info['requires']);?>
	  <span><label><input type="checkbox" name="requires[]" value="0" <?php if(in_array('0',$requires)){echo 'checked="checked"';}?>/> 本地 </label> <label><input type="checkbox" name="requires[]" value="1" <?php if(in_array('1',$requires)){echo 'checked="checked"';}?>/> 公司验证 </label></span>
	  <p style="color:#F00;font:normal normal normal 12px/36px 宋体; margin-left:130px;">不满足条件的用户将不能查看你的联系方式</p>
</div>
<div class="user_form_line">
	  <span class="with_120">完成时间：</span> 
	  <span style="text-align:left;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="0" <?php if($info['cycle']!=0){echo 'checked="checked"';}?>/> 签约后</label><input id="cycle" onkeyup="check(id);" name="cycle" value="<?php if($info['cycle']!=0){echo $info['cycle'];}?>" type="text" class="user_input1" /> 天内完成
		<div class="clear"></div>
		<span style=" margin-top:20px;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="1" <?php if($info['limit_time']!=0){echo 'checked="checked"';}?>/> 限定时间至</label><input id="limit_time"  name="limit_time" value="<?php if($info['limit_time']!=0 ){echo date('Y-m-d',$info['limit_time']);}?>" type="text" class="user_input1" style="width:150px;"/></span>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">测试内容：</span> 
	  <span>
			<label><input type="radio" name="financing" value="0" <?php if($info['financing']==0){echo 'checked="checked"';}?>/> 黑盒测试 </label>
			<label><input type="radio" name="financing" value="1" <?php if($info['financing']==1){echo 'checked="checked"';}?>/> 白盒测试 </label>
			<label><input type="radio" name="financing" value="2" <?php if($info['financing']==2){echo 'checked="checked"';}?>/> 压力测试 </label> 
			<label><input type="radio" name="financing" value="3" <?php if($info['financing']==3){echo 'checked="checked"';}?>/> 兼容性测试 </label> 
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">测试要求：</span> 
	  <span>
			<label><input type="radio" name="styles" value="0" <?php if($info['styles']==0){echo 'checked="checked"';}?>/> 测试报告 </label>
			<label><input type="radio" name="styles" value="1" <?php if($info['styles']==1){echo 'checked="checked"';}?>/> 外派 </label>
			<label><input type="radio" name="styles" value="2" <?php if($info['styles']==2){echo 'checked="checked"';}?>/> 其他 </label> 
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作对象数量：</span>
	  <span>
			<label><input type="radio" name="partner_num" value="0" <?php if($info['partner_num']==0){echo 'checked="checked"';}?>/> 单人 </label> 
			<label><input type="radio" name="partner_num" value="1" <?php if($info['partner_num']==1){echo 'checked="checked"';}?>/> 多人 </label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作有效期：</span> 
	  <span>
			 <label><input name="end_year" value="<?php if($info['end_time']!=0){echo date('Y',$info['end_time']);}?>" type="text" class="user_input1" maxlength="4"/> 年</label>
			 <label><input name="end_mouth" value="<?php if($info['end_time']!=0){echo date('m',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 月 </label>
			 <label><input name="end_day" value="<?php if($info['end_time']!=0){echo date('d',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 日</label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">说明：</span> 
	  <span><textarea name="info" rows="5" cols="100" class="speed_textarea"><?php echo $info['info'];?></textarea></span>
</div>
<!-- 产品测试外包 end -->

<?php }else if($sid == 15){?>

<!-- SDK接入外包 start -->
<div class="user_form_line">
	  <span class="with_120">外包预算：</span> 
	  <span><input id="amount" onkeyup="check(id);" name="amount" value="<?php if($info['amount']!= 0){echo $info['amount'];}?>" type="text" class="user_input" style="width:120px;"/> ￥</span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作公司要求：</span><?php $requires = explode(',',$info['requires']);?>
	  <span><label><input type="checkbox" name="requires[]" value="0" <?php if(in_array('0',$requires)){echo 'checked="checked"';}?>/> 本地 </label> <label><input type="checkbox" name="requires[]" value="1" <?php if(in_array('1',$requires)){echo 'checked="checked"';}?>/> 公司验证 </label></span>
	  <p style="color:#F00;font:normal normal normal 12px/36px 宋体; margin-left:130px;">不满足条件的用户将不能查看你的联系方式</p>
</div>
<div class="user_form_line">
	  <span class="with_120">完成时间：</span> 
	  <span style="text-align:left;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="0" <?php if($info['cycle']!=0){echo 'checked="checked"';}?>/> 签约后</label><input id="cycle" onkeyup="check(id);" name="cycle" value="<?php if($info['cycle']!=0){echo $info['cycle'];}?>" type="text" class="user_input1" /> 天内完成
		<div class="clear"></div>
		<span style=" margin-top:20px;"><label style="margin-right:5px;"><input id="times" type="radio" name="times" value="1" <?php if($info['limit_time']!=0){echo 'checked="checked"';}?>/> 限定时间至</label><input id="limit_time"  name="limit_time" value="<?php if($info['limit_time']!=0 ){echo date('Y-m-d',$info['limit_time']);}?>" type="text" class="user_input1" style="width:150px;"/></span>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">技术要求：</span> 
	  <span>
			<label><input type="radio" name="financing" value="0" <?php if($info['financing']==0){echo 'checked="checked"';}?>/> Cocos </label>
			<label><input type="radio" name="financing" value="1" <?php if($info['financing']==1){echo 'checked="checked"';}?>/> U3D </label>
			<label><input type="radio" name="financing" value="2" <?php if($info['financing']==2){echo 'checked="checked"';}?>/> Flash </label> 
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">系统：</span> 
	  <span>
			<label><input type="radio" name="styles" value="0" <?php if($info['styles']==0){echo 'checked="checked"';}?>/> IOS越狱 </label>
			<label><input type="radio" name="styles" value="1" <?php if($info['styles']==1){echo 'checked="checked"';}?>/> 其他 </label> 
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作对象数量：</span>
	  <span>
			<label><input type="radio" name="partner_num" value="0" <?php if($info['partner_num']==0){echo 'checked="checked"';}?>/> 单人 </label> 
			<label><input type="radio" name="partner_num" value="1" <?php if($info['partner_num']==1){echo 'checked="checked"';}?>/> 多人 </label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">合作有效期：</span> 
	  <span>
			 <label><input name="end_year" value="<?php if($info['end_time']!=0){echo date('Y',$info['end_time']);}?>" type="text" class="user_input1" maxlength="4"/> 年</label>
			 <label><input name="end_mouth" value="<?php if($info['end_time']!=0){echo date('m',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 月 </label>
			 <label><input name="end_day" value="<?php if($info['end_time']!=0){echo date('d',$info['end_time']);}?>" type="text" class="user_input2" maxlength="2"/> 日</label>
	  </span>
</div>
<div class="user_form_line">
	  <span class="with_120">说明：</span> 
	  <span><textarea name="info" rows="5" cols="100" class="speed_textarea"><?php echo $info['info'];?></textarea></span>
</div>
<!-- SDK接入外包 end -->

<?php } ?>