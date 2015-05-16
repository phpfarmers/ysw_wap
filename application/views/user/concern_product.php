        <div class="user_right">
			<style type="text/css">
			.user_list_title{width:100%;float:left;background:#eeeeee;}
			.user_list_title dl{font:normal normal normal 16px/42px 微软雅黑;color:#666666;}
			.user_list_title dl dd{text-align:center;border:#eeeeee 1px solid;border-right:none;float:left;padding:0px 5px;}

			.user_list{width:100%;float:left;}
			.user_list dl{font:normal normal normal 14px/50px 微软雅黑;color:#666666;width:100%;overflow:hidden;float:left;}
			.user_list dl dd{text-align:center;border-bottom:#eeeeee 1px solid;border-right:#eeeeee 1px solid;float:left;padding:0px 5px;overflow:hidden;}

			.width_list_1{width:80px;}
			.width_list_2{width:214px;}
			.width_list_3{width:100px;}

			.user_right_title em{height:35px;margin:10px 20px;padding:0px 20px;font:normal normal normal 16px/35px 微软雅黑;color:#FFFFFF;background:#ff8a00;float:right;text-indent:2px;}
			</style>
			<div class="user_right_title"><h2>我关注的产品</h2></div>
			<div class="user_right_content">
				<div class="user_list_title">
					<dl>
						<dd class="width_list_1" style="border-left:#eeeeee 1px solid;">产品图片</dd>
						<dd class="width_list_2">产品名称</dd>
						<dd class="width_list_2">公司名称</dd>
						<dd class="width_list_1">产品状态</dd>
						<dd class="width_list_3">操作</dd>
					</dl>
				</div>
				<div class="user_list">
					<?php foreach($product as $row):?>
					<dl>
						<dd class="width_list_1" style="border-left:#eeeeee 1px solid;"><a href="<?php echo site_url('products/show').'/'.$row->product_uuid;?>"><img src="<?php if($row->product_icon){ echo static_url('uploadfile/image/product/'.$row->product_icon);}else{echo static_url('public/images/prod1.jpg');}?>" style="width:40px; height:40px; float:left;margin:5px 20px;" ></a></dd>
						<dd class="width_list_2"><a href="<?php echo site_url('products/show').'/'.$row->product_uuid;?>"><?php echo $row->product_name;?></a></dd>
						<dd class="width_list_2"><?php if($row->company_name!=''){echo $row->company_name;}else{echo '产品暂未关联公司';}?></dd>
						<dd class="width_list_1"><?php if($row->status==1){ echo '已审核';}else{echo '未审核';}?></dd>
						<dd class="width_list_3"><a href="javascript:void(0);" onclick="del('<?php echo $row->product_collection_uuid;?>')">取消关注</a></dd>
					</dl>
					<?php endforeach;?>
				</div>
				<div style="width:740px;height:30px;text-align:center;margin:0 auto; margin-top:20px; margin-bottom:0px;float:left;">
				<?php echo $this->pagination->create_links(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function del(collection_uuid)
{
	$.get("<?php echo site_url('user/concern_product/del/') . '/' ?>" + collection_uuid ,function(data){
		location.reload();
	});
}
</script>