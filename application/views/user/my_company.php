		<style type="text/css">
		.my_com_pro{width:100%;color:#666;}
		.my_com_pro ul{marrgin:0px;padding:0px;}
		.my_com_pro ul li{width:50%;marrgin:0px;padding:10px 0px;list-style:none;text-align:left;float:left;border-bottom: 1px dashed #eeeeee;}
		.my_com_pro ul li img{width:60px;height:60px;border:none;float:left;margin-right:10px;}
		.my_com_pro ul li p{width:292px;height:60px;float:left;}
		.my_com_pro ul li p b{width:95%;float:left;font:normal normal bold 14px/30px 宋体;margin-bottom:5px;}
		.my_com_pro ul li p span{width:95%;float:left;font:normal normal normal 12px/16px 宋体;}
		</style>
		<div class="user_right">
			<div class="user_right_title"><h2>我的公司</h2></div>
			<div class="user_right_content">
				<div class="user_form_gs">
                    <div class="user_form_gslf"><a href="<?php echo site_url('/company/show/'.$company['company_uuid']);?>"><img src="<?php if($company['company_pic']){ echo static_url('uploadfile/image/company/'.$company['company_pic']);}else{ echo static_url('public/images/gslogo.jpg');}?>" width="180" height="180"></a></div>
                    <div class="user_form_gslok">
                    	<dl>
                        	<dt><?php echo $company['employee_position'];?></dt>
                            <div class="clear"></div>
                            <dd style=" font-size:16px;"><strong><a href="<?php echo site_url('/company/show/'.$company['company_uuid']);?>"><?php echo $company['company_name'];?></a></strong><span style=" color:#F00">
							<?php
							if($company['status']=='0')
							{
								//var_dump($company['verification_info']);
								if(!empty($company['verification_info']))
								{
									echo '(验证中...)';
								}
								else
								{
									echo '<a href="'.site_url('/user/company/my_post/'.$company['company_uuid']).'" style="color:#f00;">(未验证)</a>';
								}
								
							}
							?></span></dd>
                            <dd style=" font-size:14px;color:#666;height:20px;"><?php echo $company['company_address'];?></dd>
                        </dl>
                        <ul>
                        	<li><a href="<?php echo site_url('user/company/select_company');?>">跳槽新公司</a></li>
                            <li><a href="<?php echo site_url('/company/show/'.$company['company_uuid']);?>">查看公司详细资料</a></li>
                            
                        </ul>
                    </div>
                    <div class="clear"></div>
                    <div class="chyaun">
                        <div class="colle">
                            <div style="width:744px; text-align:right;"><input type="button" onclick="document.getElementById('col').style.display=document.getElementById('col').style.display==''?'none':''" value="查看公司其他成员"> </div>  
                            <div id="col" style="display:none;overflow:hidden;border:#ebebeb solid 1px;">
							<?php if($employee){?>
								<?php foreach ($employee as $row){ ?>
                                <table style="width:370px;float:left;" cellpadding="0" cellspacing="0">
                                    <tr>
										<td><img src="<?php if($row['user_pic']){ echo static_url('uploadfile/image/user/100_'.$row['user_pic']);}else{ echo static_url('public/images/smtou.jpg');}?>" width="60" height="60"></td>
										<td><?php echo $row['realname'];?></td>
										<td><?php echo $row['employee_position'];?></td>
										<td><?php echo $row['employee_dept'];?></td>
									</tr>
                                </table>
                                <?php } ?>
							<?php }else{?>
							<p style="margin:0px; padding:10px;text-align:center;">暂无数据！</p>
							<?php } ?>
                            </div>
                        </div>
                        <div class="colle">
                            <div style="width:744px;text-align:right;"><input type="button" onclick="document.getElementById('col1').style.display=document.getElementById('col1').style.display==''?'none':''" value="公司相关产品"> </div>  
                            <div id="col1" style="display:none;text-align:left;overflow:hidden;padding:0px 10px;">
							<?php if($product):?>
								<div class="my_com_pro"><ul>
								<?php foreach ($product as $row): ?>
									<li><a href="<?php echo site_url('product/show/'.$row->product_uuid);?>"><img src="<?php echo static_url('uploadfile/image/product/'.$row->product_icon);?>"></a><p><b><a href="<?php echo site_url('product/show/'.$row->product_uuid);?>"><?php echo $row->product_name;?></a></b>
									<span>类型：
									<?php 
									$arr = explode(',',$row->radio1.','.$row->radio2.','.$row->product_type);
									if(count($arr)>7)
									{
										$arr = array_slice(explode(',',$row->radio1.','.$row->radio2.','.$row->product_type),0,6);
									}
									for($ii=0;$ii<count($arr);$ii++)
									{
										if($arr[$ii]<4)
										{
											echo '<a href="'.site_url('product/index/type/'.$arr[$ii].'-0-0').'">'.$type[$arr[$ii]].'</a>';
										}
										else if($arr[$ii]>=4 && $arr[$ii]<6)
										{
											echo '<a href="'.site_url('product/index/type/0-'.$arr[$ii].'-0').'">'.$type[$arr[$ii]].'</a>';
										}
										else
										{
											echo '<a href="'.site_url('product/index/type/0-0-'.$arr[$ii]).'">'.$type[$arr[$ii]].'</a>';
										}
										if($ii<count($arr)-1)
										{
											echo '、';
										}
									}
									?>
									</span>
									</p></li>
								<?php endforeach;?>
								</ul></div>
							<?php else:?>
							<p style="margin:0px; padding:10px;text-align:center;">暂无数据！</p>
							<?php endif;?>
                            </div> 
                        </div>
                   </div>
                   </div>
                   <div class="before">
					<h3>您以前的公司</h3>
						<div class="old_company">
						<table width="740" cellpadding="0" cellspacing="0">
						<?php if($old_company){?>
							<?php foreach ($old_company as $row){?>
							<tr>
								<td width="15%"><a href="<?php echo site_url('company/show/'.$row['company_uuid']);?>"><img width="65" hight='55' src="<?php if($row['company_pic']){ echo static_url('uploadfile/image/company/'.$row['company_pic']);}else{ echo static_url('public/images/smtou.jpg');}?>"></a></td>
								<td width="30%"><a href="<?php echo site_url('company/show/'.$row['company_uuid']);?>"><?php echo $row['company_name'];?></a><br /> <span><?php echo $region[$row['province']].'-'.$region[$row['city']]?></span></td>
								<td width="15%"><?php if($row['employee_position']!=''){echo $row['employee_position'];}else{echo '未填写';}?></td>
								<td width="20%"><?php if($row['join_time']==0){echo '未填写';}else{echo date('Y/m',$row['join_time']);}?>-2014/11</td>
								<td width="20%" style="text-align:right;"><a href="javascript:void(0);" onclick="del('<?php echo $row['uuid'];?>','<?php echo $row['company_uuid'];?>')">删除</a> | <a href="<?php echo site_url('user/cooperation/index/'.$row['company_uuid'])?>">管理</a></td>
							</tr>
							<?php } ?>
						<?php }else{ ?>
							<tr>
								<td>暂无数据！</td>
							</tr>
						<?php } ?>
						</table>
						</div>
                  </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
//删除公司
function del(uuid,company_uuid)
{
	$.get("<?php echo site_url('user/company/del/') . '/' ?>" + uuid + '/' + company_uuid,function(data){
		location.reload();
	});
}
</script>