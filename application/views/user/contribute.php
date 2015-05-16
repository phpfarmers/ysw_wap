        <div class="user_right">
			<style type="text/css">
			.user_list_title{width:100%;float:left;background:#eeeeee;}
			.user_list_title dl{font:normal normal normal 16px/42px 微软雅黑;color:#666666;}
			.user_list_title dl dd{text-align:center;border:#eeeeee 1px solid;border-right:none;float:left;padding:0px 5px;}

			.user_list{width:100%;float:left;}
			.user_list dl{font:normal normal normal 14px/50px 微软雅黑;color:#666666;width:100%;overflow:hidden;float:left;}
			.user_list dl dd{text-align:center;border-bottom:#eeeeee 1px solid;border-right:#eeeeee 1px solid;float:left;padding:0px 5px;overflow:hidden;}

			.width_list_1{width:333px;}
			.width_list_2{width:100px;}
			.width_list_3{width:160px;}

			.user_right_title em{height:35px;margin:10px 20px;padding:0px 20px;font:normal normal normal 16px/35px 微软雅黑;color:#FFFFFF;background:#ff8a00;float:right;text-indent:2px;}
			</style>
			<div class="user_right_title"><h2>我上传的资料</h2></div>
			<div class="user_right_content">
				<div class="user_list_title">
					<dl>
						<dd class="width_list_1">资料名称</dd>
						<dd class="width_list_2">资料分类</dd>
						<dd class="width_list_3">上传时间</dd>
						<dd class="width_list_2">操作</dd>
					</dl>
				</div>
				<div class="user_list">
					<?php foreach($contribute as $row):?>
					<dl>
						<dd class="width_list_1" style="border-left:#eeeeee 1px solid;text-align:left;padding-left:10px;"><a href="<?php echo site_url('/data/show').'/'.$row->data_uuid;?>"><?php echo $row->title;?></a></dd>
						<dd class="width_list_2"><?php echo $row->name;?></dd>
						<dd class="width_list_3"><?php echo date('Y-m-d H:i:s',$row->create_time);?></dd>
						<dd class="width_list_2"><a href="<?php echo site_url('data/edit_data').'/'.$row->data_uuid;?>">编辑</a> | <a href="javascript:void(0);" onclick="del('<?php echo $row->data_uuid;?>')">删除</a></dd>
					</dl>
					<?php endforeach;?>
				</div>
				<?php if($this->pagination->create_links()):?>
				<div style="width:740px;height:30px;text-align:center;margin:0 auto; margin-top:20px; margin-bottom:0px;float:left;">
				<?php echo $this->pagination->create_links(); ?>
				</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
//删除资料
function del(data_uuid)
{
	$.get("<?php echo site_url('user/contribute/del/') . '/' ?>" + data_uuid ,function(data){
		location.reload();
	});
}
</script>