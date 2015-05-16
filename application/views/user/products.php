        <div class="user_right">
			<style type="text/css">
			.user_list_title{width:100%;float:left;background:#eeeeee;}
			.user_list_title dl{font:normal normal normal 16px/42px 微软雅黑;color:#666666;}
			.user_list_title dl dd{text-align:center;border:#eeeeee 1px solid;border-right:none;float:left;padding:0px 5px;}

			.user_list{width:100%;float:left;}
			.user_list dl{font:normal normal normal 14px/50px 微软雅黑;color:#666666;width:100%;overflow:hidden;float:left;}
			.user_list dl dd{text-align:center;border-bottom:#eeeeee 1px solid;border-right:#eeeeee 1px solid;float:left;padding:0px 5px;overflow:hidden;}

			.width_list_1{width:60px;}
			.width_list_2{width:169px;}
			.width_list_3{width:259px;}
			.width_list_4{width:140px;}

			.user_right_title em{height:35px;margin:10px 20px;padding:0px 20px;font:normal normal normal 16px/35px 微软雅黑;color:#FFFFFF;background:#ff8a00;float:right;text-indent:2px;}
			</style>
			<div class="user_right_title"><a href="<?php echo site_url('user/add_product');?>"><em>添加新产品</em></a><h2>我提交的产品</h2></div>
			<div class="user_right_content">
				<div class="user_list_title">
					<dl>
						<dd class="width_list_1" style="border-left:#eeeeee 1px solid;">图片</dd>
						<dd class="width_list_2">产品名称</dd>
						<dd class="width_list_3">公司名称</dd>
						<dd class="width_list_1">状态</dd>
						<dd class="width_list_4">操作</dd>
					</dl>
				</div>
				<div class="user_list">
					<?php foreach ($product_list as $row){ ?>
					<dl>
						<dd class="width_list_1" style="border-left:#eeeeee 1px solid;"><a href="<?php echo site_url('products/show/'.$row->product_uuid)?>"><img src="<?php if($row->product_icon){ echo static_url('uploadfile/image/product/'.$row->product_icon);}else{echo static_url('public/images/prod1.jpg');}?>" style="width:40px; height:40px; float:left;margin:5px 10px;" ></a></dd>
						<dd class="width_list_2" style="text-align:left;"><a href="<?php echo site_url('products/show/'.$row->product_uuid)?>"><?php echo $row->product_name;?></a></dd>
						<dd class="width_list_3" style="text-align:left;"><?php if($row->company_name!=''){echo $row->company_name;}else{echo '产品关联公司之后才可提交审核！';}?></dd>
						<dd class="width_list_1"><?php if($row->checked ==0){ echo '未审核';}elseif($row->checked ==1){echo '已审核';}else{echo '审核未通过';}?></dd>
						<dd class="width_list_4"><a href="<?php echo site_url('user/add_cooperation/index'.'/'.$row->product_uuid);?>">发布合作</a> | <a href="<?php echo site_url('user/add_product/index/'.$row->product_uuid);?>">编辑</a> | <a href="<?php echo site_url('user/products/del/'.$row->product_uuid);?>">删除</a></dd>
					</dl>
					<?php }?>
				</div>
				<div style="width:740px;height:30px;text-align:center;margin:0 auto; margin-top:10px; margin-bottom:0px;float:left;">
				<?php echo $this->pagination->create_links(); ?>
				</div>
			</div>
		</div>
	</div>
</div>