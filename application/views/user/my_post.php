        <div class="user_right">
			<div class="user_right_title"><h2>我的公司</h2></div>
			<div class="user_right_content">
				<?php echo form_open_multipart('/user/company/my_post/'.$company['company_uuid']);?>
				<div class="user_form_gs">
                    <div class="user_form_gslf"><img src="<?php if($company['company_pic']){ echo static_url('uploadfile/image/company/'.$company['company_pic']);}else{ echo static_url('public/images/gslogo.jpg');}?>" width="180" height="180"></div>
                    <div class="user_form_gsrg">
                    	<dl>
                        	<dt><strong><?php echo $company['company_name'];?></strong> <span><a href="<?php echo site_url('user/company/select_company'); ?>">重新选择</a></span></dt>
                            <div class="clear"></div>
                            <dd style="font-size:14px;color:#666;height:20px;"><?php echo $company['company_address'];?></dd>
                        </dl>
                        <div class="clear"></div>
                        <p><?php echo cut_str($company['company_desc'],70,' ...');?></li>
                        </p>
                    </div>
                    <div class="clear"></div>
                    <div class="user_form_job">
						<input name="company_uuid" type="hidden" value="<?php echo $company['company_uuid'];?>"/>
                        <div class="user_form_line"><span class="job"><em>*</em>请输入您在这家公司的职位：</span><span><input name="employee_position" type="text" value="<?php echo $company['employee_position'];?>" class="user_input"/></span><div class="error_from"><?php echo form_error('employee_position'); ?></div></div>
				        <div class="user_form_line"><span class="job">您所属的部门：</span><span><input name="employee_dept" type="text" value="<?php echo $company['employee_dept'];?>" class="user_input"/></span></div>
				        <div class="user_form_line"><span  class="job">您的入职时间：</span><span><input name="year" type="text" value="<?php if($company['join_time']){ echo date('Y',$company['join_time']);} ?>" class="user_input1" maxlength="4"/> 年 <input name="month" type="text" value="<?php if($company['join_time']){ echo date('m',$company['join_time']);} ?>" class="user_input2" maxlength="2"/> 月 <input name="day" type="text" value="<?php if($company['join_time']){ echo date('d',$company['join_time']);} ?>" class="user_input2" maxlength="2"/> 日</span></div>
				        <div class="user_form_line">
							<span class="job">上传公司执照以进行验证：</span><span style="margin-top:8px;">
							<input type="file" name="userfile" size="40" /></span>
							<span style="font-size:12px;color:#999;text-align:left;width:505px;padding-left:230px;">支持 jpg、png、doc、pdf 格式，文件大小不得超过1M </span>
							</div>
                    </div>
                </div>
                <div class="clear"></div>				
				<div class="user_form_line prv"><a href="companyxx.html"><input name="" type="submit" value="确认保存" class="user_submit"/></a></div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>