<div class="main">
	<div class="page1">
	   <!--left start-->
		<div class="coop_lf">
			<div class="new">
			 <div class="new_nav botop">
				   <div class="new_nav_l">
					   <span><img src="<?php echo static_url('public/images/home.gif');?>"></span> 
					   <span><a href="<?php echo site_url('');?>">首页</a></span> 
					   <span> > </span>
					   <span><a href="<?php echo site_url('data');?>">找资料</a></span> 
				   </div>
				   <div class="clear"></div>
			 </div>
			 <!--资料列表 start-->
			 <div class="tabPanel">
				<?php
				echo '<ul>';
				if($category !='')
				{
					echo '<li><a href="'.site_url('data').'">全部资料</a></li>';
				}
				else
				{
					echo '<li class="hit"><a href="'.site_url('data').'">全部资料</a></li>';
				}
				if(is_array($data_category))
				{
					foreach($data_category as $row)
					{
						if($row->id == $category)
						{
							echo '<li class="hit"><a href="'.site_url('data/index/category/'.$row->id).'">'.$row->name.'</a></li>';
						}
						else
						{
							echo '<li><a href="'.site_url('data/index/category/'.$row->id).'">'.$row->name.'</a></li>';
						}
					}
				}
				echo '</ul>';
				?>
				<div class="panes">
					<div class="pane" style="display:block;">
						<?php foreach ($data_list as $row): ?>
					  <div class="pane_ab">
							<div class="pane_a">
								<h3><?php echo date('d',$row->open_time);?></h3>
								<p><?php echo date('Y/m',$row->open_time);?></p>
							</div>
							<div class="pane_b">
								<h2><strong>【<?php echo $row->name;?>】</strong> <a href="<?php echo site_url('data/show/'.$row->data_uuid);?>" title="<?php echo $row->title;?>" target="_blank"><?php echo $row->title;?></a></h2>
								<dl class="pane_bdiv"> 
										<dd>浏览 <span><?php echo $row->view;?></span></dd>
										<dd>/</dd>
										<dd>点赞 <span><?php echo $row->upon;?></span></dd> 
										<dd>/</dd>
										<dd>收藏 <span><?php echo $row->collect;?></span></dd>
										<dd>/</dd>
										<dd>下载 <span><?php echo $row->hits;?></span></dd>
								</dl>
								<div class="clear"></div>
								<p><?php echo highlight_phrase(cut_str($row->summary,110,''),rawurldecode($keywords),'<span style="color:#f00">', '</span>');?> <span><a href="<?php echo site_url('data/show/'.$row->data_uuid);?>" target="_blank">[查看更多]</a></span></p>
							</div>
							<div class="clear"></div>
						</div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
			<!--资料列表 end-->
		  </div>
			<div style="width:740px;height:30px;text-align:center;margin:0 auto; margin-top:30px; margin-bottom:20px;">
			<?php echo $this->pagination->create_links(); ?>
			</div>
		</div>
		<!--left end-->
        <!--right start-->
        <div class="coop_rt"> 
            <div class="release"><a href="<?php echo site_url('data/add_data');?>" target="_blank"><span class="pub1_tu"></span><p class="rel_pp">上传资料</p></a></div>
			<?php $this->product->_new_product($new,$type);?>
			<?php $this->task->_hot_task($hot);?>
        </div>
        <!--right end-->
        <div class="clear"></div>
	</div>
</div>