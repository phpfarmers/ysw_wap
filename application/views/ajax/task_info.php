<?php if($task_target_id === 2){?>

<!-- 发行/独代 start -->合作类型： 
	<?php if((isset($financing) && $financing==0) || !isset($financing)){echo '独代';}?>
	<!--<label class="radio-inline"><input type="radio" name="financing" value="1" <?php if(isset($financing) && $financing==1){echo 'checked="checked"';}?>/> 联运 </label>-->
	<?php if(isset($financing) && $financing==2){echo '产品收购';}?>
	<br>
	合作区域：
	<?php
	$area = isset($area)?explode(',',$area):array();
	$str = '';
	$str .= in_array('1',$area)?'国内,':'';
	$str .= in_array('2',$area)?'北美,':'';
	$str .= in_array('3',$area)?'南美,':'';
	$str .= in_array('4',$area)?'东南亚,':'';
	$str .= in_array('5',$area)?'日韩,':'';
	$str .= in_array('6',$area)?'西亚,':'';
	$str .= in_array('7',$area)?'非洲,':'';
	$str .= in_array('8',$area)?'欧洲,':'';
	$str .= in_array('9',$area)?'其他,':'';
	echo trim($str,',');
	?>
	<br>
	代理费：<?php if(isset($amount) && $amount!= 0){echo $amount;}?>
	<br >
	合作对象：
	<?php if(isset($partner_num) && $partner_num!= 0){echo '可与多家合作';}else{echo '仅与单家合作';}?>
	<br>
	合作公司要求：
	<?php
	$requires = isset($requires)?explode(',',$requires):array();
	$str = '';
	$str .= in_array('1',$requires)?'公司验证,':'';
	$str .= in_array('0',$requires)?'本地,':'';
	echo trim($str,',');
	?>
	<?php
	if($areas)
	{?>
		<br>
		<?php
		if(isset($areas[$province])) echo '省 :'.$areas[$province];
		if(isset($areas[$city])) echo '市 :'.$areas[$city];
		?>
	<?php
	}?>
	<?php
	if($info)
	{?>
		<br>
		说明：<?php echo $info;?>
	<?php
	}?>
	<?php
	if($end_time)
	{?>
		<br>
		<?php echo date('Y-m-d',$end_time);?>
	<?php
	}?>
<!-- 发行/独代 end -->

<?php }else if($task_target_id == 4){?>

<!-- 找投资 start -->
	<?php
		if($product_step)
		{
			echo lang('Step').': '.$product_step;
		}
	?>
	<br>
	团队阶段：
	<?php
	if('2' === $team_step) {echo '有盈利';}elseif('1' === $team_step){echo '稍有流水';}else{echo '暂无收入';}
	?>
	<br>
	融资金额：<?php if(isset($amount) && $amount!= 0){echo $amount;}?> ￥ 
	<br>
	出让股份：
	<?php if(isset($stock) && $stock!= 0){echo $stock;}?> % 
	<br>
	融资周期：
	<?php if(isset($cycle) && $cycle!= 0){echo $cycle;}?> 天 
	<br>
	商业计划书：
	<?php if(isset($prospectus) && $prospectus){echo '有';}else{echo '无';}?> 
	<br>
	融资阶段：<?php if('3' === $financing){echo 'C轮';}elseif('2' === $financing){echo 'B轮';}elseif('1' === $financing){echo 'Pre-A轮';}else{echo '天使';}?>
	<br>
	合作对象：<?php if('1' === $partner_num){echo '可与多家合作';}else{echo '仅与单家合作';}?>
	<?php
	if($info)
	{?>
		<br>
		说明：<?php echo $info;?>
	<?php
	}?>
<!-- 找投资 end -->

<?php }else if($task_target_id == 5){?>
<!-- 美术外包 start -->
	外包预算：<?php if(isset($amount) && $amount!= 0){echo $amount;}?>￥
	<br>
	合作公司要求：
	<?php
	$requires = isset($requires)?explode(',',$requires):array();
	$str = '';
	$str = in_array('0',$requires)?'本地':'';
	$str .= in_array('1',$requires)?',公司验证':'';
	echo $str;
	?>
	  <?php
	if($areas)
	{?>
		<br>
		<?php
		if(isset($areas[$provinces])) echo '省 :'.$areas[$provinces];
		if(isset($areas[$citys])) echo '市 :'.$areas[$citys];
		?>
	<?php
	}?>
	<br>
	完成时间：<?php if(isset($cycle) && $cycle!=0){echo '签约后'.$cycle.'天内完成';}?> <?php if(isset($limit_time) && $limit_time!=0 ){echo '限定时间至: '.date('Y-m-d',$limit_time);}?>
	<br>
	美术风格：<?php if(isset($styles)) echo $styles;?>
	<br>内容与数量：
	<?php 
	$serialize = isset($content_serialize)?unserialize($content_serialize):'';
	if($serialize)
	{
		$i = 0;
		foreach($serialize as $key=>$value)
		{
			echo $key.':'.$value.';';
			
		}
	}?>
	<br>合作对象：
	<?php if((isset($partner_num) && '0' === $partner_num) || !isset($info)){echo "仅与单家合作";}?>
	<?php if(isset($partner_num) && $partner_num!= 0){echo "可与多家合作";}?> 
	<br>
	合作有效期：
	<?php if($end_time) echo date('Y-m-d',$end_time);?>
	<?php
	if($info)
	{?>
		<br>
		说明：<?php echo $info;?>
	<?php
	}?>
<!-- 美术外包 end -->

<?php }else if($task_target_id == 6){?>

<!-- 找渠道 start -->
	<br>平台类型：
		<?php		
		if(isset($platform) && $platform)
		{
			if(strpos($platform,','))
			{
				$infoarr = explode(',',$platform);
			}
			else
			{
				$infoarr[] = $platform;
			}
			$str = '';
			foreach($infoarr as $k=>$v)
			{
				if(isset($platforms[$v]) && $platforms[$v])
					$str .= $platforms[$v].',';
			}
			echo trim($str,',');
		}
		?> 
	<br>
	合作模式：<?php if('2' === $financing){echo 'CPA合作';}elseif('1' === $financing){echo '混服';}else{echo '联运';}?>
	<br>
	合作对象：<?php if('1' === $partner_num){echo '可与多家合作';}else{echo '仅与单家合作';}?>
	<br>
	合作有效期：<?php if($end_time) echo date('Y-m-d',$end_time);?>
	<?php
	if($info)
	{?>
		<br>
		说明：<?php echo $info;?>
	<?php
	}?>
<!-- 找渠道 end -->



<?php }else if($task_target_id == 8){?>

<!-- IDC合作 start -->
	合作公司要求：
	<?php
	$requires = isset($requires)?explode(',',$requires):array();
	$str = '';
	$str = in_array('0',$requires)?'本地':'';
	$str .= in_array('1',$requires)?',公司验证':'';
	echo $str;
	?>
	<br>
	<?php
	if($areas)
	{?>
		<br>
		<?php
		if(isset($areas[$province])) echo '省 :'.$areas[$province];
		if(isset($areas[$city])) echo '市 :'.$areas[$city];
		?>
	<?php
	}?>
	<br>
	完成时间：<?php if(isset($cycle) && $cycle!=0){echo '签约后'.$cycle.'天内完成';}?> <?php if(isset($limit_time) && $limit_time!=0 ){echo '限定时间至: '.date('Y-m-d',$limit_time);}?>
	<br>
	合作类型：
	<?php
		if('0' === $partner_type)echo '空间租赁';
		if('1' === $partner_type)echo '服务器托管';
		if('2' === $partner_type)echo '云服务';
	?>
	<br>
	合作对象：<?php if('1' === $partner_num){echo '可与多家合作';}else{echo '仅与单家合作';}?>
	<br>
	合作有效期：<?php if($end_time) echo date('Y-m-d',$end_time);?>
	<br>
	<?php
	if($info)
	{?>
		<br>
		说明：<?php echo $info;?>
	<?php
	}?>
<!-- IDC合作 end -->

<?php }else if($task_target_id == 9){?>

<!-- 各类证照申请 start -->
	完成时间：<?php if(isset($cycle) && $cycle!=0){echo '签约后'.$cycle.'天内完成';}?> <?php if(isset($limit_time) && $limit_time!=0 ){echo '限定时间至: '.date('Y-m-d',$limit_time);}?>
	<br>证件类型：
	<?php
	if('0' === $styles) echo '著作权';
	if('1' === $styles) echo '版号';
	if('2' === $styles) echo '文网文';
	?>
	<br>
	合作对象：<?php if('1' === $partner_num){echo '可与多家合作';}else{echo '仅与单家合作';}?>
	<br>
	合作有效期：<?php if($end_time) echo date('Y-m-d',$end_time);?>
	<?php
	if($info)
	{?>
		<br>
		说明：<?php echo $info;?>
	<?php
	}?>
<!-- 各类证照申请 end -->

<?php }else if($task_target_id == 10){?>

<!-- 宣传合作 start -->
	宣传预算：<?php if(isset($amount) && $amount!= 0){echo $amount;}?>
	<br>
	合作公司要求：
	<?php
	$requires = isset($requires)?explode(',',$requires):array();
	$str = '';
	$str = in_array('0',$requires)?'本地':'';
	$str .= in_array('1',$requires)?',公司验证':'';
	echo $str;
	
	if($areas)
	{?>
		<br>
		<?php
		if(isset($areas[$province])) echo '省 :'.$areas[$province];
		if(isset($areas[$city])) echo '市 :'.$areas[$city];
		?>
	<?php
	}?>
	<br>
	合作类型：
	<?php
	$partner_type = isset($partner_type)?explode(',',$partner_type):array();
	$str = '';	
	$str .= in_array('0',$partner_type)?'方案整包,':'';
	$str .= in_array('1',$partner_type)?'广告投放,':'';
	$str .= in_array('2',$partner_type)?'媒体合作,':'';
	$str .= in_array('3',$partner_type)?'线下活动,':'';
	$str .= in_array('4',$partner_type)?'异业合作,':'';
	echo trim($str,',');
	?>
	<br>
	合作方式：
	<?php
	$partner_method = isset($partner_method)?explode(',',$partner_method):array();
	$str = '';	
	$str .= in_array('0',$partner_type)?'CPA,':'';
	$str .= in_array('1',$partner_type)?'CPS,':'';
	$str .= in_array('2',$partner_type)?'CPT,':'';
	$str .= in_array('3',$partner_type)?'其他,':'';
	echo trim($str,',');
	?>
	<br>
	宣传时间：<?php if($start_time){echo date('Y-m-d',$start_time);}?>
	<br>
	合作对象：<?php if('1' === $partner_num){echo '可与多家合作';}else{echo '仅与单家合作';}?>
	<br>
	合作有效期：<?php if($end_time) echo date('Y-m-d',$end_time);?>
	<br>
	<?php
	if($info)
	{?>
		<br>
		说明：<?php echo $info;?>
	<?php
	}?>
<!-- 宣传合作 end -->

<?php }else if($task_target_id == 11){?>

<!--  音乐音效外包 start -->
	外包预算：<?php if(isset($amount) && $amount!= 0){echo $amount;}?>￥
	<br>
	合作公司要求
	<?php
	$requires = isset($requires)?explode(',',$requires):array();
	$str = '';
	$str = in_array('0',$requires)?'本地':'';
	$str .= in_array('1',$requires)?',公司验证':'';
	echo $str;
	
	if($areas)
	{?>
		<br>
		<?php
		if(isset($areas[$province])) echo '省 :'.$areas[$province];
		if(isset($areas[$city])) echo '市 :'.$areas[$city];
		?>
	<?php
	}?>
	<br>
	完成时间：<?php if(isset($cycle) && $cycle!=0){echo '签约后'.$cycle.'天内完成';}?> <?php if(isset($limit_time) && $limit_time!=0 ){echo '限定时间至: '.date('Y-m-d',$limit_time);}?>
	<br>
	音乐风格：<?php if(isset($styles)) echo $styles;?>
	<br>
	制作内容：
	<?php 
		$serialize = isset($content_serialize)?unserialize($content_serialize):'';
		if($serialize){
			$str = '';
			foreach($serialize as $key=>$value)
			{
				$str .= $key.':'.$value.';';				
			}
			echo trim($str,';');
		}
	?>
	<br>
	合作对象：<?php if('1' === $partner_num){echo '可与多家合作';}else{echo '仅与单家合作';}?>
	<br>
	合作有效期：<?php if($end_time) echo date('Y-m-d',$end_time);?>
	<br>
	<?php
	if($info)
	{?>
		<br>
		说明：<?php echo $info;?>
	<?php
	}?>
<!--  音乐音效外包 end -->

<?php }else if($task_target_id == 12){?>

<!-- 网站制作外包 start -->
	外包预算：<?php if(isset($amount) && $amount!= 0){echo $amount;}?>￥
	<br>
	合作公司要求：
	<?php
	$requires = isset($requires)?explode(',',$requires):array();
	$str = '';
	$str = in_array('0',$requires)?'本地':'';
	$str .= in_array('1',$requires)?',公司验证':'';
	echo $str;
	
	if($areas)
	{?>
		<br>
		<?php
		if(isset($areas[$province])) echo '省 :'.$areas[$province];
		if(isset($areas[$city])) echo '市 :'.$areas[$city];
		?>
	<?php
	}?>
	<br>
	完成时间：<?php if(isset($cycle) && $cycle!=0){echo '签约后'.$cycle.'天内完成';}?> <?php if(isset($limit_time) && $limit_time!=0 ){echo '限定时间至: '.date('Y-m-d',$limit_time);}?>
	<br>
	网站类型：
	<?php
	$styles = isset($styles)?explode(',',$styles):array();
	$str = '';
	$str .= in_array('0',$styles)?' 公司网站,':'';
	$str .= in_array('1',$styles)?' 产品网站,':'';
	$str .= in_array('2',$styles)?' 其他,':'';
	echo trim($str,',');
	?>
	<br>
	合作对象：<?php if('1' === $partner_num){echo '可与多家合作';}else{echo '仅与单家合作';}?>
	<br>
	合作有效期：<?php if($end_time) echo date('Y-m-d',$end_time);?>
	<br>
	<?php
	if($info)
	{?>
		<br>
		说明：<?php echo $info;?>
	<?php
	}?>
<!-- 网站制作外包 end -->

<?php }else if($task_target_id == 13){?>

<!-- 视频制作外包 start -->
	外包预算：<?php if(isset($amount) && $amount!= 0){echo $amount;}?>￥
	<br>
	合作公司要求：
	<?php
	$requires = isset($requires)?explode(',',$requires):array();
	$str = '';
	$str = in_array('0',$requires)?'本地':'';
	$str .= in_array('1',$requires)?',公司验证':'';
	echo $str;
	
	if($areas)
	{?>
		<br>
		<?php
		if(isset($areas[$province])) echo '省 :'.$areas[$province];
		if(isset($areas[$city])) echo '市 :'.$areas[$city];
		?>
	<?php
	}?>
	<br>
	完成时间：<?php if(isset($cycle) && $cycle!=0){echo '签约后'.$cycle.'天内完成';}?> <?php if(isset($limit_time) && $limit_time!=0 ){echo '限定时间至: '.date('Y-m-d',$limit_time);}?>
	<br>
	制作内容：
	<?php 
		$serialize = isset($content_serialize)?unserialize($content_serialize):'';
		if($serialize){
			$str = '';
			foreach($serialize as $key=>$value)
			{
				$str .= $key.':'.$value.';';				
			}
			echo trim($str,';');
		}
	?>
	<br>
	合作对象：<?php if('1' === $partner_num){echo '可与多家合作';}else{echo '仅与单家合作';}?>
	<br>
	合作有效期：<?php if($end_time) echo date('Y-m-d',$end_time);?>
	<br>
	<?php
	if($info)
	{?>
		<br>
		说明：<?php echo $info;?>
	<?php
	}?>
<!-- 视频制作外包 end -->

<?php }else if($task_target_id == 14){?>

<!-- 产品测试外包 start -->
	外包预算：<?php if(isset($amount) && $amount!= 0){echo $amount;}?>￥
	<br>
	合作公司要求：
	<?php
	$requires = isset($requires)?explode(',',$requires):array();
	$str = '';
	$str = in_array('0',$requires)?'本地':'';
	$str .= in_array('1',$requires)?',公司验证':'';
	echo $str;
	
	if($areas)
	{?>
		<br>
		<?php
		if(isset($areas[$province])) echo '省 :'.$areas[$province];
		if(isset($areas[$city])) echo '市 :'.$areas[$city];
		?>
	<?php
	}?>
	<br>
	完成时间：<?php if(isset($cycle) && $cycle!=0){echo '签约后'.$cycle.'天内完成';}?> <?php if(isset($limit_time) && $limit_time!=0 ){echo '限定时间至: '.date('Y-m-d',$limit_time);}?>
	<br>
	测试内容：
	<?php
	if('0' === $financing) echo '黑盒测试';
	if('1' === $financing) echo '白盒测试';
	if('2' === $financing) echo '压力测试';
	if('3' === $financing) echo '兼容性测试';	
	?>
	<br>
	测试要求：
	<?php
		if('0' === $styles) echo '测试报告';
		if('1' === $styles) echo '外派';
		if('2' === $styles) echo '其他';
	?>
	<br>
	合作对象：<?php if('1' === $partner_num){echo '可与多家合作';}else{echo '仅与单家合作';}?>
	<br>
	合作有效期：<?php if($end_time) echo date('Y-m-d',$end_time);?>
	<?php
	if($info)
	{?>
		<br>
		说明：<?php echo $info;?>
	<?php
	}?>
<!-- 产品测试外包 end -->

<?php }else if($task_target_id == 15){?>

<!-- SDK接入外包 start -->
	外包预算：<?php if(isset($amount) && $amount!= 0){echo $amount;}?>￥
	<br>
	合作公司要求：
	<?php
	$requires = isset($requires)?explode(',',$requires):array();
	$str = '';
	$str = in_array('0',$requires)?'本地':'';
	$str .= in_array('1',$requires)?',公司验证':'';
	echo $str;
	
	if($areas)
	{?>
		<br>
		<?php
		if(isset($areas[$province])) echo '省 :'.$areas[$province];
		if(isset($areas[$city])) echo '市 :'.$areas[$city];
		?>
	<?php
	}?>
	<br>
	完成时间：<?php if(isset($cycle) && $cycle!=0){echo '签约后'.$cycle.'天内完成';}?> <?php if(isset($limit_time) && $limit_time!=0 ){echo '限定时间至: '.date('Y-m-d',$limit_time);}?>
	<br>
	技术要求：
	<?php
	if('0' === $financing) echo 'Cocos';
	if('1' === $financing) echo 'U3D';
	if('2' === $financing) echo 'Flash';
	?>
	<br>
	系统：
	<?php
	if('0' === $styles) echo 'IOS越狱';
	if('1' === $styles) echo '其他';
	?>
	<br>
	合作对象：<?php if('1' === $partner_num){echo '可与多家合作';}else{echo '仅与单家合作';}?>
	<br>
	合作有效期：<?php if($end_time) echo date('Y-m-d',$end_time);?>
	<?php
	if($info)
	{?>
		<br>
		说明：<?php echo $info;?>
	<?php
	}?>
<!-- SDK接入外包 end -->

<?php } ?>