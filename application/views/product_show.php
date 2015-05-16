<div class="main">
	<div class="page1">
        <!--ban1 start-->
    	<div class="colist_lf">
            <div class="new_nav">
			       <div class="new_nav_l">
					   <span><img src="<?php echo static_url('public/images/home.gif');?>"></span> 
					   <span><a href="<?php echo site_url();?>">首页</a></span> 
					   <span> > </span>
					   <span><a href="<?php echo site_url('products');?>">所有产品</a></span>
					   <span> > </span>
					   <span style=" color:#333"><?php echo $product->product_name;?></span>
				   </div>
                   <div class="clear"></div>
             </div>
            <div class="new_compan_a">
				<?php if($product->product_icon):?>
				<div class="ft new_compan_aa"><img src="<?php echo static_url('uploadfile/image/product/'.$product->product_icon);?>"></div>
				<?php else:?>
                <div class="ft new_compan_hui"><img src="<?php echo static_url('public/images/small_tu/hui.jpg');?>"></div>
				<?php endif;?>
                <div class="gt new_compan_a1">
                     <dl>
						<?php
						if($product->product_name !='')
						{
							echo '<dd class="conlist_d"><strong>'.$product->product_name.'</strong>';
							if($product->checked =='0')
							{
								echo '<em style="color:#f00;margin-left:5px;font-size:14px;">（未审核）</em>';
							}
							echo '</dd>';
						}
						if($product->product_theme !='')
						{
							echo '<dd>游戏题材：'.$product->product_theme.'</dd>';
						}
						if($product->product_style !='')
						{
							echo '<dd>美术风格：'.$product->product_style.'</dd>';
						}
						if($product->single_type !='')
						{
							if($product->single_type == '1')
							{
								echo '<dd>是否单机： 是</dd>';
							}
							else
							{
								echo '<dd>是否单机： 否</dd>';
							}
						}
						if($product->company_name !='')
						{
							echo '<dd>研发公司：<a href="'.site_url('company/show/'.$product->company_uuid).'" target="_blank">'.$product->company_name.'</a></dd>';
						}
						$types = $product->radio1.','.$product->radio2.','.$product->product_type;
						$types = array_filter(explode(',',$types));
						if(is_array($types))
						{
							echo '<dd class="conlist_d conlist_d1" style="margin-bottom:0px;">游戏类型：';
							$i = 0;
							foreach($types as $value )
							{
								$i++;
								echo $product_type[$value];
								if($i < count($types))
								{
									echo ' 、';
								}
							}
							echo '</dd>';
						}
						$platform = array_filter(explode(',',$product->product_platform));
						if(is_array($platform))
						{
							echo '<dd class="conlist_d conlist_d1" style="margin-bottom:0px;">运行平台：';
							$j = 0;
							foreach($platform as $value )
							{
								$j++;
								echo $product_platform[$value];
								if($j < count($platform))
								{
									echo ' 、';
								}
							}
							echo '</dd>';
						}
						?>
                        <div class="clear"></div>
                     </dl>
                     <div class="clear"></div>
					<?php
					if($product->sn != 0)
					{
						echo '<div class="new_compan_a2">产品编号：P'.$product->sn.'</div>';
					}
					?>
               </div>
               <div class="clear"></div>
            </div>
        </div>
        <!--ban1 end--> 
        <!--ban2 start-->
        <div class="new_compan_b">
            <h4>游戏介绍</h4>
			<div style="padding:0px 20px 10px 20px;"><?php if($product->product_info !=''){echo $product->product_info;}else{echo '暂未填写！';}?></div>
        </div>
        <!--ban2 end-->
        <!--ban3 start-->
        <div class="new_compan_b">
            <h4>游戏特色</h4>
			<div style="padding:0px 20px 10px 20px;"><?php if($product->product_feature !=''){echo $product->product_feature;}else{echo '暂未填写！';}?></div>
        </div>
        <!--ban3 end-->
        <!--ban4 start-->
        <div class="new_compan_b">
            <h4>游戏图片</h4>
            <p>
			<?php
			if(count($product_pics)>0)
			{
				foreach($product_pics as $row)
				{
					echo '<img src="'.static_url('uploadfile/image/'.date('Y-m-d',$row->create_time).'/180_'.$row->url).'">';
				}
			}
			else
			{
				echo '暂未添加图片！';
			}			
			?></p>
        </div>
        <div class="new_compan_b">
            <h4>游戏视频</h4>
            <p class="cooplist_hui" style=" margin-bottom:10px;"><?php if($product->product_video !=''){echo '<a href="'.$product->product_video.'" target="_blank">'.$product->product_video.'</a>';}else{echo '暂未填写！';}?></p>
            <h4>下载地址</h4>
            <p class="cooplist_hui"><?php if($product->product_down !=''){echo '<a href="'.$product->product_down.'"  target="_blank">'.$product->product_down.'</a>';}else{echo '暂未填写！';}?></p>
        </div>
        <!--ban4 end-->
	</div>
</div>