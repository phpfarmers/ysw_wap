<div class="main">
	<div class="page1">
     <div style=" width:1200px;">
     	<div class="ft page_lf">
        	<dl>
            	<dt>最新合作</dt>
                <dd><a href="<?php echo site_url('cooperation/index/order/create_time-desc');?>" target="_blank">查看更多>></a></dd>
            </dl>
        </div>
        <div class="gt page_rt">
        	<dl>
            	<dt>热门资讯</dt>
                <dd><a href="<?php echo site_url('information');?>" target="_blank">查看更多>></a></dd>
            </dl>
        </div>
        <div class="clear"></div>
        <script type="text/javascript">
        $(".pange_ul").each(function(i) {
        $(this).find("li").mouseover(function(){
            $(this).find(".pange_dl").show().end().siblings("li").find(".pange_dl").hide();
            })
        });
        
        </script>
        <style>
        .pange_ul{ display:block;}
        </style>
        <div style=" border:#E9E9E9 solid 1px; background:#FFF; width:1198px;">
        	<ul class="ft page_lf">
				<?php if(isset($new_task) && $new_task):?>
					<?php
					$i='0';
					foreach($new_task as $row):
					$i++;
					?>
					<li <?php if($i > 8){echo 'class="page_no"';}?>>
						<a href="<?php echo site_url('cooperation/show/'.$row->task_uuid);?>" target="_blank">
							<div class="ft page_coop_a"><img src="<?php if($row->product_icon !=''){echo static_url('uploadfile/image/product/'.$row->product_icon);}else{echo static_url('public/images/not_pics.jpg');}?>" width="90" height="90"></div>
							<div class="gt page_coop_b">
								<h3><?php echo cut_str($row->name,6,'…');?></h3>
								<p><?php echo cut_str($row->title,12,'…');?></p>
								<div class="page_coop_b1">立即查看 >> </div>
							</div>
						</a>
						<div class="clear"></div>
					</li>
					<?php endforeach;?>
					<?php 
					if(count($new_task)<12)
					{
						$j = 12 - count($new_task);
						for($i=0;$i < $j;$i++)
						{
							if($i > $j-4)
							{
								echo '<li class="page_no"><div class="page_img"><img src="'.static_url('public/images/not_pics.jpg').'"></div></li>';
							}
							else
							{
								echo '<li><div class="page_img"><img src="'.static_url('public/images/not_pics.jpg').'"></div></li>';
							}
						}
					}
					?>
				<?php endif;?>
                <div class="clear"></div>
            </ul>
            <ul class="gt pange_ul">
				<?php if(isset($hot_news) && $hot_news):?>
					<?php
					$n = 0;
					foreach($hot_news as $row)
					{
						$n++;
						echo '
							<li>
								<p><span>'.$n.'</span> <a href="'.site_url('information/show/'.$row->article_uuid).'" title="'.$row->title.'" target="_blank">'.cut_str($row->title,16,'…').'</a></p>
								<div class="pange_dl">
								   <div class="ft pange_xun">
										<h2><span>'.$n.'</span> <a href="'.site_url('information/show/'.$row->article_uuid).'" target="_blank">'.cut_str($row->title,7,'…').'</a></h2>
										<h3><a href="'.site_url('information/show/'.$row->article_uuid).'" target="_blank">'.cut_str($row->summary,18,'…').'</a></h3>
									</div>
									<div class="gt"><a href="'.site_url('information/show/'.$row->article_uuid).'" target="_blank"><img src="';
									if($row->pic !='')
									{
										echo static_url('uploadfile/image/article/'.$row->pic);
									}
									else
									{
										echo static_url('public/images/not_pics.jpg');
									}
									echo '" width="80" height="80"></a></div>
								</div>
							</li>';
					}
					?>
				<?php endif;?>
            </ul>
            <div class="clear"></div>
        </div>
     </div>
        <!--热门合作 start-->
        <div class="page_coop_hot">
             <div style=" width:1200px;"> 
                <div class="ft page_lf page_hot">
                    <dl>
                        <dt>热门合作</dt>
                        <dd><a href="<?php echo site_url('cooperation/index/order/intents-desc');?>" target="_blank">/ 查看更多 >> </a></dd>
                    </dl>
                </div>
                <div class="gt page_rt">
                    <dl>
                        <dt> 新进公司</dt>
                        <dd><a href="<?php echo site_url('company');?>" target="_blank">查看更多 >></a></dd>
                    </dl>
                </div>
                <div class="clear"></div>
                <div style="border:#E9E9E9 solid 1px; background:#FFF; width:1198px;">
                    <ul class="ft page_lf page_lf_a">
						<?php if(isset($hot_task) && $hot_task):?>
							<?php
							$j = '0';
							foreach($hot_task as $row){
								$j++;
								if($j == '1'){
							?>
							<li class="page_ul_a page_no">
								<div class="page_ul_a1">
									<a href="<?php echo site_url('cooperation/show/'.$row->task_uuid);?>" target="_blank">
									  <div><img src="<?php if($row->product_icon !=''){echo static_url('uploadfile/image/product/'.$row->product_icon);}else{echo static_url('public/images/not_pics.jpg');}?>" width="200" height="200"></div>
									  <div class="page_ul_a3"><?php echo cut_str($row->title,22,'…');?><span class="page_ul_a2">立即查看 >> </span></div>
									</a>
								</div>
							</li>
							<?php
								}else{
							?>
							<li <?php if($j > 4){echo 'class="page_no"';}?>>
								<a href="<?php echo site_url('cooperation/show/'.$row->task_uuid);?>" target="_blank">
									<div class="ft page_coop_a"><img src="<?php if($row->product_icon !=''){echo static_url('uploadfile/image/product/'.$row->product_icon);}else{echo static_url('public/images/not_pics.jpg');}?>" width="90" height="90"></div>
									<div class="gt page_coop_b">
										<h3><?php echo cut_str($row->name,6,'…');?></h3>
										<p><?php echo cut_str($row->title,12,'…');?></p>
										<div class="page_coop_b1">立即查看 >> </div>
									</div>
								</a>
								<div class="clear"></div>
							</li>
							<?php
								}
							}
							?>
							<?php 
							if(count($hot_task)<7)
							{
								$j = 7 - count($hot_task);
								for($i=0;$i < $j;$i++)
								{
									if($i > $j-3)
									{
										echo '<li class="page_no"><div class="page_img"><img src="'.static_url('public/images/not_pics.jpg').'"></div></li>';
									}
									else
									{
										echo '<li><div class="page_img"><img src="'.static_url('public/images/not_pics.jpg').'"></div></li>';
									}
								}
							}
							?>
						<?php endif;?>
                        <div class="clear"></div>
                    </ul>
                    <ul class="gt pange_ul">
						<?php if(isset($new_company) && $new_company):?>
							<?php
							$m = '0';
							foreach($new_company as $row):
							$m++;
							?>
							<li>
								<p><span><?php echo $m;?></span> <a href="<?php echo site_url('company/show/'.$row->company_uuid);?>" title="<?php echo $row->company_name;?>" target="_blank"><?php echo cut_str($row->company_name,16,'…');?></a></p>
								<div class="pange_dl">
								   <div class="ft pange_xun">
										<h2><span><?php echo $m;?></span> <a href="<?php echo site_url('company/show/'.$row->company_uuid);?>" title="<?php echo $row->company_name;?>" target="_blank"><?php echo cut_str($row->company_name,7,'…');?></a></h2>
										<h3><a href="<?php echo site_url('company/show/'.$row->company_uuid);?>"><?php echo cut_str($row->company_desc,16,'…');?></a></h3>
									</div>
									<div class="gt"><a href="<?php echo site_url('company/show/'.$row->company_uuid);?>" target="_blank"><img src="<?php if($row->company_pic !='' && $row->company_pic !='0'){echo static_url('uploadfile/image/company/'.$row->company_pic);}else{echo static_url('public/images/not_pics.jpg');}?>" width="80" height="80" alt="<?php echo $row->company_name;?>"></a></div>
								</div>
							</li>
							<?php endforeach;?>
						<?php endif;?>
                    </ul>
                    <div class="clear"></div>
                 </div>
            </div> 
        </div>
        <div class="clear"></div>
        <!--热门合作 end-->
        <div class="smbanner"><a href="javascript:;"><img src="<?php echo static_url('public/images/big_tu/smbanner.gif');?>" width="1200" height="90"></a></div>
        <!--服务外包 start-->
        <div class="page_coop_fu">
			<div class="waibao1">外包服务商 <span>找我们</span></div>
            <div class="waibao_a">
                <ul>
					<?php if(isset($company) && $company):?>
						<?php
							$kk = 0;
							foreach($company as $row):
							$kk++;?>
						<li <?php if( 0 == $kk%3) echo "style='margin-right:0;'";?>>
							<div class="waibao_a1"><span><?php echo $row['name'];?></span> <a href="<?php echo site_url('company/index/type/'.$row['parent'].'/type_t/'.$row['id']);?>" target="_blank">查看更多>> </a></div>
							<div class="clear"></div>
							<?php
							$i='0';
							foreach($row['arr'] as $rowss):
							$i++;
							if($i =='1'){
							?>
							<div class="ft waibao_a2"><a href="<?php echo site_url('company/show/'.$rowss['company_uuid']);?>" title="<?php echo $row['name'];?>" target="_blank"><img src="<?php if($rowss['company_pic'] !=''){echo static_url('uploadfile/image/company/'.$rowss['company_pic']);}else{echo static_url('public/images/not_pics.jpg');}?>" width="180" height="120" alt="<?php echo $row['name'];?>"></a></div>
							<div class="gt waibao_a3">
								<h3><a href="<?php echo site_url('company/show/'.$rowss['company_uuid']);?>" title="<?php echo $rowss['company_name'];?>" target="_blank"><?php echo cut_str($rowss['company_name'],'6','…')?></a></h3>
								<p><a href="<?php echo site_url('company/show/'.$rowss['company_uuid']);?>" target="_blank"><?php echo cut_str($rowss['company_desc'],'30','…');?></a></p>
								<div class="waibao_b"><a href="<?php echo site_url('company/show/'.$rowss['company_uuid']);?>" class="page_coop_b1" target="_blank">立即查看 >> </a></div>
							</div>
							<?php }
							endforeach;?>
							<div class="clear"></div>
							<?php if(count($row['arr'])>1):?>
							<ul class="waibao_a4">
								<?php
								$i='0';
								foreach($row['arr'] as $rows):
								$i++;
								if($i !='1'){
								?>
								<li><a href="<?php echo site_url('company/show/'.$rows['company_uuid']);?>" title="<?php echo $rows['company_name'];?>" target="_blank"><img src="<?php if($rows['company_pic'] !=''){echo static_url('uploadfile/image/company/'.$rows['company_pic']);}else{echo static_url('public/images/not_pics.jpg');}?>" width="60" height="60" alt="<?php echo $rows['company_name'];?>"></a></li>
								<?php }
								endforeach;?>
							</ul>
							<?php endif;?>
						</li>
						<?php endforeach;?>
					<?php endif;?>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
        <!--服务外包 end-->
        <div class="smbanner" style="margin-bottom:0px;"><a href="http://www.ucloud.cn/" target="_blank"><img src="<?php echo static_url('public/images/big_tu/sm_d2.gif');?>" width="1200" height="90"></a></div>
        <!--热门招聘 start-->
        <!--<div class="page_coop_zp">
            <div class="waibao"><span>热门招聘  <i>最热最全的招聘网站</i></span> <a href="#">查看更多>> </a></div>
            <div class="clear"></div>
            <div class="zhaopin">
                <ul>
                	<li>
                    	<dl>
                        	<dt><a href="#"><img src="<?php echo static_url('public/images/big_tu/zhao1.jpg');?>"></a></dt>
                            <dd><a href="#">奇雨动漫</a></dd>
                            <dd><span>发布招聘 <a href="#" class="zhaopin_a">6</a> 个</span></dd>
                        </dl>
                        <div><a href="#">诚招美术人才，要求会ps，dw...</a></div>
                        <div><a href="#">诚招漫画设计差额雕刻时光很...</a></div>
                    </li>
                    <li>
                    	<dl>
                        	<dt><a href="#"><img src="<?php echo static_url('public/images/big_tu/zhao2.jpg');?>"></a></dt>
                            <dd><a href="#">奇雨动漫</a></dd>
                            <dd><span>发布招聘 <a href="#" class="zhaopin_a">6</a> 个</span></dd>
                        </dl>
                        <div><a href="#">诚招美术人才，要求会ps，dw...</a></div>
                        <div><a href="#">诚招漫画设计差额雕刻时光很...</a></div>
                    </li>
                    <li>
                    	<dl>
                        	<dt><a href="#"><img src="<?php echo static_url('public/images/big_tu/zhao3.jpg');?>"></a></dt>
                            <dd><a href="#">奇雨动漫</a></dd>
                            <dd><span>发布招聘 <a href="#" class="zhaopin_a">6</a> 个</span></dd>
                        </dl>
                        <div><a href="#">诚招美术人才，要求会ps，dw...</a></div>
                        <div><a href="#">诚招漫画设计差额雕刻时光很...</a></div>
                    </li>
                    <li>
                    	<dl>
                        	<dt><a href="#"><img src="<?php echo static_url('public/images/big_tu/zhao1.jpg');?>"></a></dt>
                            <dd><a href="#">奇雨动漫</a></dd>
                            <dd><span>发布招聘 <a href="#" class="zhaopin_a">6</a> 个</span></dd>
                        </dl>
                        <div><a href="#">诚招美术人才，要求会ps，dw...</a></div>
                        <div><a href="#">诚招漫画设计差额雕刻时光很...</a></div>
                    </li>
                    <li style="border-right:none;">
                    	<dl>
                        	<dt><a href="#"><img src="<?php echo static_url('public/images/big_tu/zhao3.jpg');?>"></a></dt>
                            <dd><a href="#">奇雨动漫</a></dd>
                            <dd><span>发布招聘 <a href="#" class="zhaopin_a">6</a> 个</span></dd>
                        </dl>
                        <div><a href="#">诚招美术人才，要求会ps，dw...</a></div>
                        <div><a href="#">诚招漫画设计差额雕刻时光很...</a></div>
                    </li>
                    <div class="clear"></div>
                </ul>
            </div>
        </div>
        <div class="clear"></div>-->
        <!--热门招聘 end-->
	</div>
</div>
</div>
<?php if(isset($friendlink) && $friendlink){?>
<div class="link">友情链接：
	<?php foreach($friendlink as $row){?>
	<a href="<?php echo prep_url($row->url);?>" title="<?php echo $row->title;?>" target="_blank"><?php echo $row->title;?></a> 	
	<?php }?>
</div>
<?php }?>