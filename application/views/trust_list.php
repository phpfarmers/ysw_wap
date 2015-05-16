<div class="main">
	<div class="page1 colist">
       <!--left start-->
    	<div class="colist_lf">
         	<h3><img src="<?php echo static_url('public/images/home.gif');?>"> <a href="<?php echo site_url();?>">首页</a> > <a href="<?php echo site_url('trust/index');?>">委托</a> > <span class="conlist_a"><?php echo $product->product_name;?></span></h3>
            <div class="conlist_xx">
                <dl>
                    <dt><img src="<?php if($product->product_icon){echo static_url('uploadfile/image/product/'.$product->product_icon);}else{echo static_url('public/images/dtu_1.jpg');}?>"> 
                        <span><a class="conlist_a1 upon_product pointer" rel="<?php echo $product->product_uuid;?>" link="<?php echo uri_string();?>"></a></span>
                        <span><a class="conlist_a2 collection_product pointer" rel="<?php echo $product->product_uuid;?>" link="<?php echo uri_string();?>"></a></span>
                        <span><a class="conlist_a3 download_product pointer" href="<?php if($product->product_video){echo site_url('/product/download/'.$product->product_uuid);}?>" target="_blank"></a></span>
                    </dt>
                    <dd class="conlist_d"><strong><?php echo $product->product_name;?></strong></dd>
                    <dd>研发公司： <?php echo $company[$product->company_uuid];?></dd>
                    <dd>
						运行平台：
						<?php
							if(FALSE !== strpos($product->product_platform,','))
							{
								if(FALSE !== strpos($product->product_platform,','))
									$strpos = explode(',',$product->product_platform);
								foreach($strpos as $row)
								{
									echo $platform[$row];
								}
							}
							else
							{							
								echo $platform[$product->product_platform];
							}
						?>
					</dd>
                    <dd>
						游戏类型：
						<?php
							$str = $producttype[$product->radio1];$str .=','.$producttype[$product->radio2];
							if(FALSE !== strpos($product->product_type,','))
							{
								if(FALSE !== strpos($product->product_type,','))
									$strpos = explode(',',$product->product_type);
								foreach($strpos as $row)
								{
									$str .=','.$producttype[$row];
								}
							}
							else
							{							
								$str .=','.$producttype[$product->product_type];
							}
							echo $str;
						?>
					</dd>
                    <dd>游戏题材：<?php echo $product->product_theme;?></dd>
                    <dd>美术风格：<?php echo $product->product_style;?></dd>
                    <div class="clear"></div>
                </dl>
                <div class="clear"></div>
				<?php
					if($producer)
					{
				?>
                <ul>
                	<li><img src="<?php if($producer->producer_pic){echo static_url('uploadfile/image/product/'.$producer->producer_pic);}else{ echo static_url('public/images/xida.gif');}?>"></li>
                    <li class="conliat_c">游戏制作人：<a href="<?php echo site_url('/producer/show/'.$producer->producer_uuid);?>"><?php echo $producer->producer_name;?></a></li>
                </ul>
				<?php
					}
				?>
                <div class="conlist_sj">
                	<h4>游戏介绍</h4>
                    <p>
						<?php echo $product->product_info;?>
					</p>
					<h4>游戏特色</h4>
                    <p>
						<?php echo $product->product_feature;?>
					</p>
                    <h4>游戏图片</h4>
                    <p>
						<?php
						if($album)
						{
							foreach($album as $row)
							{
						?>
								<img src="<?php echo static_url('public/images/avatar.jpg');?>">
						<?php
							}
						}?>
					</p>
                    <h5>游戏视频</h5>
                    <p class="cooplist_hui">
						<?php if($product->product_video){echo $product->product_video;}else{echo '暂无视频';}?>						
					</p>
                    <h5>下载地址</h5>
                    <p class="cooplist_hui">
						<?php if($product->product_video){echo '<a href="'.site_url('/product/download/'.$product->product_uuid).'" target="_blank">下载</a>';}else{echo '暂无下载';}?>
					</p>
                </div>
            </div>
        </div>
        <!--left end--> 
        <!--right start-->
        <div class="colist_rt"> 
             <h1><?php echo $target->name;?></h1>
			 <?php
				if($task)
				{
					foreach($task as $row)
					{
			 ?>
					 <div class="colist_card">
						<?php
						if('2' === $row->task_target_id)
						{
						?>
							<div class="coliat_card_span">
								<span>游戏阶段：<?php echo $step[$row->product_step];?></span> 
								<span style=" margin:0 20px 0 20px;"></span> 
								<span><a class="conlist_a2 collection_task pointer" rel="<?php echo  $row->task_uuid;?>" link="<?php echo uri_string();?>"></a></span>
							</div>
							<div class="clear"></div>
							<div>合作指数：星星等级</div>
							<dl>
								<dt>合作信息：</dt>
								<dd><?php echo $company[$product->company_uuid];?></dd>
								<dd>代理费：￥<?php echo $row->amount;?></dd>
								<dd>合作类型：<?php if('2' === $row->financing){echo '产品收购';}elseif('1' === $row->financing){echo '联运';}else{echo '独代';}?></dd>
								<dd>合作对象数量：<?php echo $row->stock;?></dd>
								<dd>合作有效期：<?php echo date('Y-m-d',$row->end_time);?></dd>
							</dl>
						<?php
						}
						if('4' === $row->task_target_id)
						{
						?>
							<div class="coliat_card_span">
								<span>游戏阶段：<?php echo $step[$row->product_step];?></span> 
								<span style=" margin:0 20px 0 20px;">完成度：<?php echo $row->product_step_percent;?>%</span> 
								<span><a class="conlist_a2 collection_task pointer" rel="<?php echo  $row->task_uuid;?>" link="<?php echo uri_string();?>"></a></span>
							</div>
							<div class="clear"></div>
							<div>合作指数：星星等级</div>
							<dl>
								<dt>合作信息：</dt>
								<dd><?php echo $company[$product->company_uuid];?></dd>
								<dd>融资金额：￥<?php echo $row->amount;?></dd>
								<dd>让出股份：<?php echo $row->stock;?>%</dd>
								<dd>融资阶段：<?php if('3' === $row->financing){echo 'C轮';}elseif('2' === $row->financing){echo 'B轮';}elseif('1' === $row->financing){echo 'Pre-A轮';}else{echo '天使';}?></dd>
								<dd>商业企划书：<?php if($row->prospectus){echo '有';}else{echo '无';}?></dd>
							</dl>
						<?php
						}
						if('5' === $row->task_target_id)
						{
						?>
							<div class="coliat_card_span">
								<span>游戏阶段：<?php echo $step[$row->product_step];?></span> 
								<span style=" margin:0 20px 0 20px;">完成度：<?php echo $row->product_step_percent;?>%</span> 
								<span><a class="conlist_a2 collection_task pointer" rel="<?php echo  $row->task_uuid;?>" link="<?php echo uri_string();?>"></a></span>
							</div>
							<div class="clear"></div>
							<div>合作指数：星星等级</div>
							<dl>
								<dt>合作信息：</dt>
								<dd><?php echo $company[$product->company_uuid];?></dd>
								<dd>外包预算：￥<?php echo $row->amount;?></dd>
								<dd>美术风格：<?php echo $row->styles;?></dd>
								<dd>合作对象数量：<?php echo $row->partner_num;?>人</dd>
								<dd><?php if(!$row->cycle){echo '完成时间：限定至'.date('m-d',$row->limit_time);}else{echo '限定时间：'.$row->cycle.'天';}?></dd>
							</dl>
						<?php
						}
						if('6' === $row->task_target_id)
						{
						?>
							<div class="coliat_card_span">
								<span>游戏阶段：<?php echo $step[$row->product_step];?></span> 
								<span style=" margin:0 20px 0 20px;">完成度：<?php echo $row->product_step_percent;?>%</span> 
								<span><a class="conlist_a2 collection_task pointer" rel="<?php echo  $row->task_uuid;?>" link="<?php echo uri_string();?>"></a></span>
							</div>
							<div class="clear"></div>
							<div>合作指数：星星等级</div>
							<dl>
								<dt>合作信息：</dt>
								<dd><?php echo $company[$product->company_uuid];?></dd>
								<dd>系统平台：<?php if(isset($platform[$row->platform]))echo $platform[$row->platform];?></dd>
								<dd>合作类型：<?php if('2' === $row->financing){echo '产品收购';}elseif('1' === $row->financing){echo '联运';}else{echo '独代';}?></dd>
								<dd>合作对象数量：<?php echo $row->partner_num;?>人</dd>
								<dd></dd>
							</dl>
						<?php
						}
						if('8' === $row->task_target_id)
						{
						?>
							<div class="coliat_card_span">
								<span>游戏阶段：<?php echo $step[$row->product_step];?></span> 
								<span style=" margin:0 20px 0 20px;">完成度：<?php echo $row->product_step_percent;?>%</span> 
								<span><a class="conlist_a2 collection_task pointer" rel="<?php echo  $row->task_uuid;?>" link="<?php echo uri_string();?>"></a></span>
							</div>
							<div class="clear"></div>
							<div>合作指数：星星等级</div>
							<dl>
								<dt>合作信息：</dt>
								<dd>合作类型：<?php if('2' === $row->partner_type){echo '云服务';}elseif('1' === $row->partner_type){echo '服务器托管';}else{echo '空间租赁';}?></dd>
								<dd>代理费：￥<?php echo $row->amount;?></dd>
								<dd>合作对象数量：<?php echo $row->partner_num;?>人</dd>
								<dd><?php if(!$row->cycle){echo '完成时间：限定至'.date('m-d',$row->limit_time);}else{echo '限定时间：'.$row->cycle.'天';}?></dd>
							</dl>
						<?php
						}
						if('9' === $row->task_target_id)
						{
						?>
							<div class="coliat_card_span">
								<span>游戏阶段：<?php echo $step[$row->product_step];?></span> 
								<span style=" margin:0 20px 0 20px;">完成度：<?php echo $row->product_step_percent;?>%</span> 
								<span><a class="conlist_a2 collection_task pointer" rel="<?php echo  $row->task_uuid;?>" link="<?php echo uri_string();?>"></a></span>
							</div>
							<div class="clear"></div>
							<div>合作指数：星星等级</div>
							<dl>
								<dt>合作信息：</dt>
								<dd>证件类型：<?php if('2' === $row->financing){echo '文网文';}elseif('1' === $row->financing){echo '版号';}else{echo '著作权';}?></dd>
								<dd>代理费：￥<?php echo $row->amount;?></dd>
								<dd>合作对象数量：<?php echo $row->partner_num;?>人</dd>
								<dd><?php if(!$row->cycle){echo '完成时间：限定至'.date('m-d',$row->limit_time);}else{echo '限定时间：'.$row->cycle.'天';}?></dd>
							</dl>
						<?php
						}
						if('10' === $row->task_target_id)
						{
						?>
							<div class="coliat_card_span">
								<span>游戏阶段：<?php echo $step[$row->product_step];?></span> 
								<span style=" margin:0 20px 0 20px;">完成度：<?php echo $row->product_step_percent;?>%</span> 
								<span><a class="conlist_a2 collection_task pointer" rel="<?php echo  $row->task_uuid;?>" link="<?php echo uri_string();?>"></a></span>
							</div>
							<div class="clear"></div>
							<div>合作指数：星星等级</div>
							<dl>
								<dt>合作信息：</dt>
								<dd>合作类型：<?php if('4' === $row->financing){echo '异业合作';}elseif('3' === $row->financing){echo '线下活动';}elseif('2' === $row->financing){echo '媒体合作';}elseif('1' === $row->financing){echo '广告投放';}else{echo '方案整包';}?></dd>
								<dd>宣传预算：￥<?php echo $row->amount;?></dd>
								<dd>合作对象数量：<?php echo $row->partner_num;?>人</dd>
								<dd>合作有效期：<?php echo date('Y-m-d',$row->end_time);?></dd>
							</dl>
						<?php
						}
						if('11' === $row->task_target_id)
						{
						?>
							<div class="coliat_card_span">
								<span>游戏阶段：<?php echo $step[$row->product_step];?></span> 
								<span style=" margin:0 20px 0 20px;">完成度：<?php echo $row->product_step_percent;?>%</span> 
								<span><a class="conlist_a2 collection_task pointer" rel="<?php echo  $row->task_uuid;?>" link="<?php echo uri_string();?>"></a></span>
							</div>
							<div class="clear"></div>
							<div>合作指数：星星等级</div>
							<dl>
								<dt>合作信息：</dt>
								<dd>外包预算：￥<?php echo $row->amount;?></dd>
								<dd>音乐风格：<?php echo $row->styles;?></dd>
								<dd>合作对象数量：<?php echo $row->partner_num;?>人</dd>
								<dd><?php if(!$row->cycle){echo '完成时间：限定至'.date('m-d',$row->limit_time);}else{echo '限定时间：'.$row->cycle.'天';}?></dd>
							</dl>
						<?php
						}
						if('12' === $row->task_target_id)
						{
						?>
							<div class="coliat_card_span">
								<span>游戏阶段：<?php echo $step[$row->product_step];?></span> 
								<span style=" margin:0 20px 0 20px;">完成度：<?php echo $row->product_step_percent;?>%</span> 
								<span><a class="conlist_a2 collection_task pointer" rel="<?php echo  $row->task_uuid;?>" link="<?php echo uri_string();?>"></a></span>
							</div>
							<div class="clear"></div>
							<div>合作指数：星星等级</div>
							<dl>
								<dt>合作信息：</dt>
								<dd>外包预算：￥<?php echo $row->amount;?></dd>
								<dd>
									网站类型：
									<?php
										if(FALSE !== strpos($row->styles,','))
										{
											$styles = explode(',',$row->styles);
											foreach($styles as $kv)
											{
												if('2' === $kv)
												{
													echo '其他,';
												}
												elseif('1' === $kv)
												{
													echo '产品网站,';
												}
												else
												{
													echo '其他';														
												}
											}
										}
										else
										{
											if('2' === $row->styles)
											{
												echo '其他';
											}
											elseif('1' === $row->styles)
											{
												echo '产品网站';
											}
											else
											{
												echo '其他';														
											}
										
										}
									?>
								</dd>
								<dd>合作对象数量：<?php echo $row->partner_num;?>人</dd>
								<dd><?php if(!$row->cycle){echo '完成时间：限定至'.date('m-d',$row->limit_time);}else{echo '限定时间：'.$row->cycle.'天';}?></dd>
							</dl>
						<?php
						}
						if('13' === $row->task_target_id)
						{
						?>
							<div class="coliat_card_span">
								<span>游戏阶段：<?php echo $step[$row->product_step];?></span> 
								<span style=" margin:0 20px 0 20px;">完成度：<?php echo $row->product_step_percent;?>%</span> 
								<span><a class="conlist_a2 collection_task pointer" rel="<?php echo  $row->task_uuid;?>" link="<?php echo uri_string();?>"></a></span>
							</div>
							<div class="clear"></div>
							<div>合作指数：星星等级</div>
							<dl>
								<dt>合作信息：</dt>
								<dd>外包预算：￥<?php echo $row->amount;?></dd>
								<dd>
									<?php
										if(FALSE !== strpos($row->requires,','))
										{
											$requires = explode(',',$row->requires);
											foreach($requires as $kv)
											{
												if('1' === $kv)
												{
													echo '公司验证,';
												}
												else
												{
													echo '本地';														
												}
											}
										}
										else
										{
											if('1' === $row->requires)
											{
												echo '公司验证,';
											}
											else
											{
												echo '本地';														
											}
										
										}
									?>
								</dd>
								<dd>合作对象数量：<?php echo $row->partner_num;?>人</dd>
								<dd><?php if(!$row->cycle){echo '完成时间：限定至'.date('m-d',$row->limit_time);}else{echo '限定时间：'.$row->cycle.'天';}?></dd>
							</dl>
						<?php
						}
						if('14' === $row->task_target_id)
						{
						?>
							<div class="coliat_card_span">
								<span>游戏阶段：<?php echo $step[$row->product_step];?></span> 
								<span style=" margin:0 20px 0 20px;">完成度：<?php echo $row->product_step_percent;?>%</span> 
								<span><a class="conlist_a2 collection_task pointer" rel="<?php echo  $row->task_uuid;?>" link="<?php echo uri_string();?>"></a></span>
							</div>
							<div class="clear"></div>
							<div>合作指数：星星等级</div>
							<dl>
								<dt>合作信息：</dt>
								<dd>外包预算：￥<?php echo $row->amount;?></dd>
								<dd>测试要求：<?php if('2' === $row->styles){echo '其他';}elseif('1' === $row->styles){echo '外派';}else{echo '测试报告';}?></dd>
								<dd>合作对象数量：<?php echo $row->partner_num;?>人</dd>
								<dd><?php if(!$row->cycle){echo '完成时间：限定至'.date('m-d',$row->limit_time);}else{echo '限定时间：'.$row->cycle.'天';}?></dd>
							</dl>
						<?php
						}
						if('15' === $row->task_target_id)
						{
						?>
							<div class="coliat_card_span">
								<span>游戏阶段：<?php echo $step[$row->product_step];?></span> 
								<span style=" margin:0 20px 0 20px;">完成度：<?php echo $row->product_step_percent;?>%</span> 
								<span><a class="conlist_a2 collection_task pointer" rel="<?php echo  $row->task_uuid;?>" link="<?php echo uri_string();?>"></a></span>
							</div>
							<div class="clear"></div>
							<div>合作指数：星星等级</div>
							<dl>
								<dt>合作信息：</dt>
								<dd>外包预算：￥<?php echo $row->amount;?></dd>
								<dd>技术要求：<?php if('2' === $row->financing){echo 'Flash';}elseif('1' === $row->financing){echo 'U3D';}else{echo 'Cocos';}?></dd>
								<dd>合作对象数量：<?php echo $row->partner_num;?>人</dd>
								<dd><?php if(!$row->cycle){echo '完成时间：限定至'.date('m-d',$row->limit_time);}else{echo '限定时间：'.$row->cycle.'天';}?></dd>
							</dl>
						<?php
						}
						if(isset($user[$row->uuid]))
						{
						?>
						<div class="colist_card_a"> 
							<div class="card_aleft">
								<ul>
								  <li><img src="<?php if($user[$row->uuid]->user_pic){echo static_url('uploadfile/image/user/'.$user[$row->uuid]->user_pic);}else{echo static_url('public/images/cardd.jpg');}?>" height="80" width="80"></li>
								  <li><a href="<?php echo site_url('/user/card');?>">修改名片</a></li>
								</ul>
						   </div>
						   <div class="card_aright">
								<div><?php echo $user[$row->uuid]->nickname;?>  /  <?php echo $user[$row->uuid]->job;?></div>
								<div>公司：<?php echo $user[$row->uuid]->company;?></div>
								<div>手机：<?php echo $user[$row->uuid]->mobile;?>  </div>
								<div>Q Q：<?php echo $user[$row->uuid]->qq;?>  </div>
								<div>邮箱：<?php echo $user[$row->uuid]->username;?> </div>
						   </div>
						   <div class="clear"></div> 
						</div>
						<?php
						}
						?>
					 </div>
			 <?php
					}
				}
			 ?>
        </div>
        <!--right end-->
        <div class="clear"></div>
	</div>
</div>