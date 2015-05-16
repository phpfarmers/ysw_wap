<div class="main">
	<div class="page1 colist">
		<!--ban1 start-->
		<div class="colist_lf">
			<div class="new_nav">
				<div class="new_nav_l">
					<span><img src="<?php echo static_url('public/images/home.gif')?>"></span> 
					<span><a href="<?php echo site_url();?>">首页</a></span> 
					<span> > </span>
					<span><a href="<?php echo site_url('company/index');?>">公司列表</a></span>
					<span> > </span>
					<span style=" color:#333"><?php echo $company->company_name;?></span>
				</div>
				<div class="clear"></div>
				<div class="jiucuo"><a href="javascript:void(0);" class="Correction">我要纠错</a></div>
			</div>
			<div class="new_compan_a">
			<?php if($company->company_pic):?>
			<div class="ft new_compan_aa"><img src="<?php echo static_url('uploadfile/image/company/'.$company->company_pic);?>"></div>
			<?php else:?>
			<div class="ft new_compan_hui"><img src="<?php echo static_url('public/images/small_tu/hui.jpg');?>"></div>
			<?php endif;?>
			<div class="gt new_compan_a1">
				<dl>
					<dd class="conlist_d"><strong><?php echo $company->company_name;?></strong> <?php if($company->checked =='0'){echo '<em style="color:#f00;margin-left:5px;font-size:14px;">（未审核）</em>';}?></dd>
					<dd class="conlist_d conlist_d1" style="margin:12px 0px 0px 0px;"><span>公司类型：</span> 
					<?php
					$company_type = array_filter(explode(',',$company->company_type));
					$i = 0;
					foreach($company_type as $value)
					{
						$i++;
						echo $companytype[$value];
						if($i < count($company_type))
						{
							echo ' , ';
						}
					}
					?></dd>
					<dd class="conlist_d conlist_d1" style="margin:12px 0px 0px 0px;"><span>公司规模： </span> <?php if($company->company_size == 0){echo '1 -10人';}elseif($company->company_size == 1){echo '11-20人';}elseif($company->company_size == 2){echo '21-50人';}elseif($company->company_size == 3){echo '50-100人';}elseif($company->company_size == 4){echo '101-200人';}elseif($company->company_size == 5){echo '200-500人';}else{echo '500人以上';}?></dd>
					<dd class="conlist_d conlist_d1" style="margin:12px 0px 0px 0px;"><span>公司网址： </span> <a href="http://<?php echo str_replace('http://','',$company->company_web);?>" target="_blank"><?php echo str_replace('http://','',$company->company_web);?></a></dd>
					<dd class="conlist_d conlist_d1" style="margin:12px 0px 0px 0px;"><span>公司地址： </span> <?php echo $company->company_address;?></dd>
					<dd class="conlist_d conlist_d1" style="margin:12px 0px 0px 0px;"><span>联系电话： </span> <?php echo $company->company_phone;?></dd>
					<dd class="conlist_d conlist_d1" style="margin:12px 0px 0px 0px;"><span>联系邮箱： </span> <?php echo $company->company_email;?></dd>
					<div class="clear"></div>
					<?php
					if($company->sn != 0)
					{
						echo '<div class="new_compan_a2">公司编号：F'.$company->sn.'</div>';
					}
					?>
				</dl>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<!--ban1 end--> 
	<!--ban2 start-->
	<div class="new_compan_b">
		<h4>公司介绍</h4>
		<div style="padding:0px 20px 10px 20px;font:normal normal normal 12px/22px 宋体;"><?php echo $company->company_desc;?></div>
	</div>
	<!--ban2 end-->
	<div class="new_compan_b">
		<h4>公司产品</h4>
		<div class="company_b1">
			<?php
			if($product)
			{
				foreach($product as $row)
				{
					echo '<dl>';
					if($row->product_icon !='')
					{
						echo '<dt><a href="'.site_url('products/show/'.$row->product_uuid).'" target="_blank"><img src="'.static_url('uploadfile/image/product/'.$row->product_icon).'" width="180" height="180"></a></dt>';
					}
					else
					{
						echo '<dt><a href="'.site_url('products/show/'.$row->product_uuid).'" target="_blank"><img src="'.static_url('public/images/dtu_1.jpg').'" width="180" height="180"></a></dt>';
					}
					echo '<dd><a href="'.site_url('products/show/'.$row->product_uuid).'" target="_blank">'.$row->product_name.'</a></dd>';
					echo '</dl>';
				}
			}
			
			?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="new_compan_b">
		<h4>团队成员</h4>
		<table width="1155" style="border:#EEEEEE solid 1px; margin-left:20px; margin-bottom:10px;">
			<?php
			if($usercompany)
			{
				$i=0;
				foreach($usercompany as $row)
				{
					$i++;
					if($i % 2 !='0')
					{
						echo '<tr style="width:570px;float:left;">';
						if($row->user_pic != '')
						{
							echo '<td width="115"><img src="'.static_url('uploadfile/image/user/100_'.$row->user_pic).'" width="60" height="60"></td>';
						}
						else
						{
							echo '<td width="115"><img src="'.static_url('public/images/smtou.jpg').'" width="60" height="60"></td>';
						}						
						echo '<td width="139">'.$row->nickname.'</td>';
						echo '<td width="177">'.$row->employee_position.'</td>';
						echo '<td width="139">'.$row->employee_dept.'</td>';
						echo '</tr>';
					}
					else
					{
						echo '<tr style="width:549px;float:left;">';
						if($row->user_pic != '')
						{
							echo '<td width="116"><img src="'.static_url('uploadfile/image/user/100_'.$row->user_pic).'" width="60" height="60"></td>';
						}
						else
						{
							echo '<td width="116"><img src="'.static_url('public/images/smtou.jpg').'" width="60" height="60"></td>';
						}						
						echo '<td width="127">'.$row->nickname.'</td>';
						echo '<td width="171">'.$row->employee_position.'</td>';
						echo '<td width="135">'.$row->employee_dept.'</td>';
						echo '</tr>';
					}
					
				}
			}
			?>
		</table>
		<div class="clear"></div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.Correction').click(function(){
		var uuid = '<?php echo UUID;?>';
		var member = [<?php echo $member;?>];
		var status = '<?php echo $status;?>';

		if(uuid == '')
		{
			alert('登录之后才可以纠错！');
		}
		else if($.inArray(uuid,member) == '-1')
		{
			alert('成为此公司的验证成员之后才可以纠错！');
		}
		else if(status == '1')
		{
			alert('纠错信息正在处理中...！');
		}
		else
		{
			location.href = '<?php echo site_url('company/correction/'.$company->company_uuid);?>'+'/'+ status;
		}
	})
})
</script>