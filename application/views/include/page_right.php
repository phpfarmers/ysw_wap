        <!--right start-->
        <div class="coop_rt"> 
            <div class="release"><a href="<?php echo site_url('data/add_data');?>"><span class="pub1_tu"></span><p class="rel_pp">我要发布</p></a></div>
            <!--newprod start-->
            <div class="coop_newp">
            	<div class="hot_more coop_hot"><strong>新进产品</strong><span><a href="<?php echo site_url('product/index/orderby/new');?>">查看更多>> </a></span></div>
                <?php
				if($product)
				{
					$i = 0;
					foreach($product as $row)
					{
						$i++;
						if($i<3)
						{
				?>
							<dl>
								<dt><a href="<?php echo site_url('product/show/'.$row->product_uuid);?>"><img src="<?php if($row->product_icon){echo static_url('uploadfile/image/product/'.$row->product_icon);}else{echo static_url('public/images/prod1.jpg');}?>" height="60" width="60"></a></dt>
								<dd class="newcon_aa"><a href="<?php echo site_url('product/show/'.$row->product_uuid);?>" title="<?php echo $row->product_name;?>"><?php echo cut_str($row->product_name,6);?></a></dd>
								<dd>
									类型：
									<?php
										$str = '';
										if(FALSE !== strpos($row->product_type,','))
										{
											$arr = explode(',',$row->product_type);
											for($ii=0;$ii<count($arr);$ii++)
											{
												if(isset($ptype[$arr[$ii]]))
													$str .= $ptype[$arr[$ii]].',';
											}
										}
										else
										{
											if(isset($ptype[$row->product_type]))
												$str .= $ptype[$row->product_type];
										}
										echo cut_str($str,6,'');
									?>
								</dd>								
							</dl>
						<?php
						}else{?>							
							<dl class="hotpaih nobm">
								<dt><a href="<?php echo site_url('product/show/'.$row->product_uuid);?>"><img src="<?php if($row->product_icon){echo static_url('uploadfile/image/product/'.$row->product_icon);}else{echo static_url('public/images/prod1.jpg');}?>" height="60" width="60"></a></dt>
								<dd class="newcon_aa"><a href="<?php echo site_url('product/show/'.$row->product_uuid);?>" title="<?php echo $row->product_name;?>"><?php echo cut_str($row->product_name,6);?></a></dd>
								<dd>
									类型：
									<?php
										if(FALSE !== strpos($row->product_type,','))
										{
											$arr = explode(',',$row->product_type);
											for($ii=0;$ii<count($arr);$ii++)
											{
												if(isset($ptype[$arr[$ii]]))
													echo $ptype[$arr[$ii]].',';
											}
										}
										else
										{
											if(isset($ptype[$row->product_type]))
												echo $ptype[$row->product_type];
										}
									?>
								</dd>								
							</dl>
				<?php
						}
					}
				}?>
            </div>
            <!--newprod end-->
            <!--remenhezuo start-->
            <div class="page_hotcop">
            	<div class="hot_more"><strong>热门合作</strong><span><a href="<?php echo site_url('cooperation/index/orderby/hot');?>">查看更多>></a></span></div>
				<?php
				if($task_hot)
				{
					$i = 0;
					foreach($task_hot as $row)
					{
						$i++;
						if($i<3)
						{
				?>
							<dl>
								<dt>
									<span><?php echo $i;?></span>
									<a href="<?php echo site_url('cooperation/lists/'.$row->product_uuid.'/'.$row->task_target_id.'/'.$row->task_uuid);?>">
										<img src="<?php if($hot_task_product[$row->product_uuid]->product_icon){echo static_url('uploadfile/image/product/'.$hot_task_product[$row->product_uuid]->product_icon);}else{echo static_url('public/images/smtu1.jpg');}?>" height="60" width="60">
									</a>
								</dt>
								<dd>
									<a href="<?php echo site_url('cooperation/lists/'.$row->product_uuid.'/'.$row->task_target_id.'/'.$row->task_uuid);?>" title="找<?php if(isset($target[$row->task_target_id])) echo cut_str($target[$row->task_target_id],6,'');?>">
										找<?php if(isset($target[$row->task_target_id])) echo $target[$row->task_target_id];?>
									</a>
								</dd>
								<dd>
									<a href="<?php echo site_url('cooperation/lists/'.$row->product_uuid.'/'.$row->task_target_id.'/'.$row->task_uuid);?>" title="<?php if($company_hot[$hot_task_product[$row->product_uuid]->company_uuid]) echo $company_hot[$hot_task_product[$row->product_uuid]->company_uuid];?>">
										合作：<?php if($company_hot[$hot_task_product[$row->product_uuid]->company_uuid]) echo cut_str($company_hot[$hot_task_product[$row->product_uuid]->company_uuid],4,'');?>
									</a>
								</dd>
							</dl>
						<?php
						}else{?>							
							<dl class="hotpaih nobm">
								<dt><span><?php echo $i;?></span></dt>
								<dd><a href="<?php echo site_url('cooperation/lists/'.$row->product_uuid.'/'.$row->task_target_id.'/'.$row->task_uuid);?>">找<?php if(isset($target[$row->task_target_id])) echo $target[$row->task_target_id];?></a></dd>
							</dl>
				<?php
						}
					}
				}?>
            </div>
            <!--remenhezuo end-->
        </div>
        <!--right end-->
        <div class="clear"></div>
	</div>
</div>