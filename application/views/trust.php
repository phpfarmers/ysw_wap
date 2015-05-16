<div class="main">
	<div class="page1">
       <!--left start-->
    	<div class="ft entrust_lf">
            <div class="entr_wt">
        			<h3>快速解决</h3>
                    <a href="JavaScript:void(0);" class="dialog"><input type="button" value="我要委托" name="weituo" style="cursor: pointer;"/></a>
                    <div class="entr_jiao"><img src="<?php echo static_url('public/images/hsj.gif');?>" /></div>
            </div>
			<?php $this->product->_new_product($new,$type);?>
			<?php $this->task->_hot_task($hot);?>
			<?php $this->ad->_task_ad();?>
        </div>
        <!--left end--> 
        <!--right start-->
        <div class="gt entrust_gt">
              <div class="new">
                    <div class="new_nav new_red">
						   <div class="new_nav_l">
							   <span><img src="<?php echo static_url('public/images/home.gif');?>"></span> 
							   <span><a href="<?php echo site_url();?>">首页</a></span> 
							   <span> > </span>
							   <span style="color:#333">所有委托</span> 
						   </div>
                           <div class="clear"></div>
                        </div>
                        <!--二nav start-->
                        <div class="er_nav">
                            <div class="er_xuan">
                            	<div class="ft er_xuan_a"><span>您已选择：</span></div>
                                <ul class="ft er_nav_ul">
									<?php
									foreach($select as $key=>$value)
									{
										//平台类型
										if($key=='plat')
										{
											foreach($plat as $key_p=>$value_p)
											{
												if($value == $key_p)
												{
													if(in_array('plat_t',$sort))
													{
														echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>平台类型：'.$value_p.'<a href="'.str_replace('/plat_t/'.$select['plat_t'],'',str_replace('/'.$key.'/'.$value,'',$url)).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
													}
													else
													{
														echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>平台类型：'.$value_p.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
													}
												}
											}
										}
										//平台类型(二级)
										if($key=='plat_t')
										{
											foreach($plat_t as $key_t=>$value_t)
											{
												if($value == $key_t)
												{
													echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>'.$plat[$select['plat']].'：'.$value_t.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
												}
											}
										}
										//合作类型
										if($key=='target')
										{
											foreach($target as $key_t=>$value_t)
											{
												if($value == $key_t)
												{
													if(in_array('target_t',$sort))
													{
														echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>合作类型：'.$value_t.'<a href="'.str_replace('/target_t/'.$select['target_t'],'',str_replace('/'.$key.'/'.$value,'',$url)).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
													}
													else
													{
														echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>合作类型：'.$value_t.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
													}
												}
											}
										}
										//合作类型(二级)
										if($key=='target_t')
										{
											foreach($target_t as $key_t=>$value_t)
											{
												if($value == $key_t)
												{
													echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>'.$target[$select['target']].'：'.$value_t.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
												}
											}
										}
										//项目阶段
										if($key=='product_step')
										{
											foreach($product_step as $key_t=>$value_t)
											{
												if($value == $key_t)
												{
													echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>项目阶段:'.$value_t.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
												}
											}
										}
										//radio1
										if($key=='radio1')
										{
											foreach($radio1 as $key_r=>$value_r)
											{
												if($value == $key_r)
												{
													echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>项目类型：'.$value_r.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
												}
											}
										}
										//radio2
										if($key=='radio2')
										{
											foreach($radio2 as $key_r=>$value_r)
											{
												if($value == $key_r)
												{
													echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>项目类型：'.$value_r.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
												}
											}
										}
										//checkbox
										if($key=='checkbox')
										{
											$arr = array_filter(explode('-',$value));
											$str = '';
											$i = 0;
											foreach($arr as $v)
											{
												$i++;
												if($i < count($arr))
												{
													$str = $str.''.$checkbox[$v].',';
												}
												else
												{
													$str = $str.''.$checkbox[$v];
												}
											}
											echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>项目类型：'.$str.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
										}
										//所属地区
										if($key=='region')
										{
											$arr = array_filter(explode('-',$value));
											if(count($arr) > 1)
											{
												foreach($region_t as $key_t=>$value_t)
												{
													if($value_t == $value)
													{
														echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>地区：'.$key_t.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
													}
												}
											}
											else
											{
												$str = '';
												$i = 0;
												foreach($arr as $v)
												{
													$i++;
													if($i < count($arr))
													{
														$str = $str.''.$region_all[$v].',';
													}
													else
													{
														$str = $str.''.$region_all[$v];
													}
												}
												echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>地区：'.$str.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
											}
										}
									}
									?>
								    <li class="er_xuan_b"><a href="<?php echo site_url('trust');?>">重新筛选条件</a></li>
                                    <div class="clear"></div>
                                </ul>
                                <div class="clear"></div>
							</div>
							<?php if(!in_array('plat',$sort)):?>
                            <dl>
                                <dt>平台类型：</dt>
                                <dd>
									<?php
									foreach($plat as $key=>$value)
									{
										if(in_array('page',$sort))
										{
											echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/plat/'.$key.'">'.$value.'</a>';
										}
										else
										{
											echo '<a href="'.$url.'/plat/'.$key.'">'.$value.'</a>';
										}
									}
									?>
                                </dd>  
                            </dl>
							<?php endif;?>
							<?php
							if(!in_array('plat_t',$sort))
							{
								if(!empty($plat_t))
								{
									echo '<dl><dt>'.$plat[$select['plat']].'：</dt><dd>';
									foreach($plat_t as $key=>$value)
									{
										if(in_array('page',$sort))
										{
											echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/plat_t/'.$key.'">'.$value.'</a>';
										}
										else
										{
											echo '<a href="'.$url.'/plat_t/'.$key.'">'.$value.'</a>';
										}
									}
									echo '</dd></dl>';
								}
							}
							?>
							<?php if(!in_array('target',$sort)):?>
                            <dl>
                                <dt>合作类型：</dt>
                                <dd>
									<?php
									foreach($target as $key=>$value)
									{
										if(in_array('page',$sort))
										{
											echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/target/'.$key.'">'.$value.'</a>';
										}
										else
										{
											echo '<a href="'.$url.'/target/'.$key.'">'.$value.'</a>';
										}
									}
									?>
                                </dd>  
                            </dl>
							<?php endif;?>
							<?php if(in_array('target',$sort) && $select['target'] == '4'):?>
								<?php if(!in_array('product_step',$sort)):?>
								<dl>
									<dt>项目阶段：</dt>
									<dd>
										<?php
										foreach($product_step as $key=>$value)
										{
											if(in_array('page',$sort))
											{
												echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/product_step/'.$key.'">'.$value.'</a>';
											}
											else
											{
												echo '<a href="'.$url.'/product_step/'.$key.'">'.$value.'</a>';
											}
										}
										?>
									</dd>  
								</dl>
								<?php endif;?>
							<?php endif;?>
							<?php
							if(!in_array('target_t',$sort))
							{
								if(!empty($target_t))
								{
									echo '<dl><dt>'.$target[$select['target']].'：</dt><dd>';
									foreach($target_t as $key=>$value)
									{
										if(in_array('page',$sort))
										{
											echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/target_t/'.$key.'">'.$value.'</a>';
										}
										else
										{
											echo '<a href="'.$url.'/target_t/'.$key.'">'.$value.'</a>';
										}
									}
									echo '</dd></dl>';
								}
							}
							?>
							<?php if(!in_array('radio1',$sort) || !in_array('radio2',$sort) || !in_array('checkbox',$sort)):?>
                            <div class="er_attrid wrapper" <?php if($select['display'] == 'block'){echo 'sytle="display:block;"';}else{echo 'style="display:none;"';}?>>
                                <div class="er_nav_pt">项目类型：</div>
                                <div class="ft er_nav_py">
									<?php if(!in_array('radio1',$sort)):?>
                                	<div class="er_nav_py1">
										<?php
										foreach($radio1 as $key=>$value)
										{
											if(in_array('page',$sort))
											{
												echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/radio1/'.$key.'">'.$value.'</a>';
											}
											else
											{
												echo '<a href="'.$url.'/radio1/'.$key.'">'.$value.'</a>';
											}
										}
										?>
                                    </div>
									<?php endif;?>
									<?php if(!in_array('radio2',$sort)):?>
                                    <div class="er_nav_py1">
										<?php
										foreach($radio2 as $key=>$value)
										{
											if(in_array('page',$sort))
											{
												echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/radio2/'.$key.'">'.$value.'</a>';
											}
											else
											{
												echo '<a href="'.$url.'/radio2/'.$key.'">'.$value.'</a>';
											}
										}
										?>
                                    </div>
									<div class="clear"></div>
									<?php endif;?>
									<?php if(!in_array('checkbox',$sort)):?>
                                    <div class="er_nav_py1 er_nav_a er_nav_off" style="position: relative;">
										<?php
										foreach($checkbox as $key=>$value)
										{
											if(in_array('page',$sort))
											{
												echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/checkbox/'.$key.'">'.$value.'</a>';
											}
											else
											{
												echo '<a href="'.$url.'/checkbox/'.$key.'">'.$value.'</a>';
											}
										}
										?> 
                                        <div class="clear"></div>
										<?php if(!in_array('checkbox',$sort)):?>
										<div class="btn"><i class="moreSleBtn" title="多选" style="bottom:0px;top:15px;"></i></div>
										<?php endif;?>
                                    </div>
									<div class="er_nav_py1 er_nav_a er_nav_on" style="display:none;">
										<?php
										foreach($checkbox as $key=>$value)
										{
											echo '<label><input type="checkbox" name="product_type" value="'.$key.'"/><em style="padding-left:6px;">'.$value.'</em></label>';
										}
										?>
										<div class="clear"></div>
                                        <div class="er_nav_py2"><a href="javascript:void(0);" class="submit">确定</a> <a href="javascript:void(0);" class="cancel">取消</a></div>
									</div>
									<?php endif;?>
                                </div> 
                            </div>
							<div class="er_more"><span class="zk"><?php if($select['display'] == 'none'){echo '更多选项（项目类型）';}else{echo '收起';}?></span></div>
							<?php endif;?>
                            <div class="clear"></div>
                        </div>
                        <!--二nav end-->
                        <!--hezuo  start-->
                        <div class="coopcon">
                           <div class="coop_hz">
                                 <div class="coop_hz_x">
									<?php
									if(in_array('order',$sort))
									{
										if($select['order'] == 'complex-desc')
										{
											echo '<span><a href="javascript:void(0);" class="curr" title="综合排序">综合 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span><a href="'.str_replace('/order/complex-desc','',$url).'/order/open_time-desc" title="最新发布">发布时间 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span><a href="'.str_replace('/order/complex-desc','',$url).'/order/intents-desc" title="从最多到最少">合作意向 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span class="coop_zh_s"><a href="'.str_replace('/order/complex-desc','',$url).'/order/amount-desc" title="从最高到最少">价格 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
										}
										else if($select['order'] == 'open_time-desc')
										{
											echo '<span><a href="'.str_replace('/order/open_time-desc','',$url).'/order/complex-desc" title="综合排序">综合 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span><a href="javascript:void(0);" class="curr" title="最新发布">发布时间 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span><a href="'.str_replace('/order/open_time-desc','',$url).'/order/intents-desc" title="从最多到最少">合作意向 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span class="coop_zh_s"><a href="'.str_replace('/order/open_time-desc','',$url).'/order/amount-desc" title="从最高到最少">价格 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
										}
										else if($select['order'] == 'intents-desc')
										{
											echo '<span><a href="'.str_replace('/order/intents-desc','',$url).'/order/complex-desc" title="综合排序">综合 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span><a href="'.str_replace('/order/intents-desc','',$url).'/order/open_time-desc" title="最新发布">发布时间 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span><a href="javascript:void(0);" class="curr" title="从最多到最少">合作意向 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span class="coop_zh_s"><a href="'.str_replace('/order/intents-desc','',$url).'/order/amount-desc" title="从最高到最少">价格 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
										}
										else if($select['order'] == 'amount-desc')
										{
											echo '<span><a href="'.str_replace('/order/amount-desc','',$url).'/order/complex-desc" title="综合排序">综合 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span><a href="'.str_replace('/order/amount-desc','',$url).'/order/open_time-desc" title="最新发布">发布时间 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span><a href="'.str_replace('/order/amount-desc','',$url).'/order/intents-desc" title="从最多到最少">合作意向 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span class="coop_zh_s"><a href="javascript:void(0);" class="curr" title="从最高到最少">价格 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
										}
										else
										{
											echo '<span><a href="javascript:void(0);" class="curr" title="综合排序">综合 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span><a href="'.$url.'/order/open_time-desc" title="最新发布">发布时间 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span><a href="'.$url.'/order/intents-desc" title="从最多到最少">合作意向 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
											echo '<span class="coop_zh_s"><a href="'.$url.'/order/amount-desc" title="从最高到最少">价格 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
										}
									}
									else
									{
										echo '<span><a href="javascript:void(0);" class="curr" title="综合排序">综合 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
										echo '<span><a href="'.$url.'/order/open_time-desc" title="最新发布">发布时间 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
										echo '<span><a href="'.$url.'/order/intents-desc" title="从最多到最少">合作意向 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
										echo '<span class="coop_zh_s"><a href="'.$url.'/order/amount-desc" title="从最高到最少">价格 <img src="'.static_url('public/images/lace/jiant.png').'"></a></span>';
									}
									?>
                                 </div>
								 <div class="coop_hz_q">
                                        <ul class="topmenu" id="jq_topmenu">
                                            <li class="webnav" style="background:none">
                                                <strong class="icon_arr"><a href="user/login"> 所有地区 </a></strong>
                                                <div class="jq_hidebox">
                                                   <dl>
														<?php
														//IP定位城市
														if($city)
														{
															echo '<dt>同城： <span>';
															if(in_array('region',$sort))
															{
																echo '<a href="'.str_replace('/region/'.$select['region'],'',str_replace('/page/'.$select['page'],'',$url)).'/region/'.$city_id.'">'.$city.'</a>';
															}
															else
															{
																echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/region/'.$city_id.'">'.$city.'</a>';
															}
															echo '</span></dt>';
														}
														//推荐区域
														if($region_t)
														{
															echo '<dd>';
															foreach($region_t as $key_t=>$value_t)
															{
																if(in_array('region',$sort))
																{
																	echo '<a href="'.str_replace('/region/'.$select['region'],'',str_replace('/page/'.$select['page'],'',$url)).'/region/'.$value_t.'">'.$key_t.'</a>';
																}
																else
																{
																	echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/region/'.$value_t.'">'.$key_t.'</a>';
																}
																
															}
															echo '</dd>';
														}
														//热门城市
														if($region_h)
														{
															echo '<dd>';
															foreach($region_h as $key_h=>$value_h)
															{
																if(in_array('region',$sort))
																{
																	echo '<a href="'.str_replace('/region/'.$select['region'],'',str_replace('/page/'.$select['page'],'',$url)).'/region/'.$key_h.'">'.$value_h.'</a>';
																}
																else
																{
																	echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/region/'.$key_h.'">'.$value_h.'</a>';
																}
															}
															echo '</dd>';
														}
														// 所有城市
														if($region)
														{
															echo '<dd class="no_bord">';
															foreach($region as $key=>$value)
															{
																if(in_array('region',$sort))
																{
																	echo '<a href="'.str_replace('/region/'.$select['region'],'',str_replace('/page/'.$select['page'],'',$url)).'/region/'.$key.'">'.$value.'</a>';
																}
																else
																{
																	echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/region/'.$key.'">'.$value.'</a>';
																}
															}
															echo '</dd>';
														}
														echo '<div class="clear"></div>';
														?>
                                                   </dl>
                                                </div>
                                            </li>
                                        </ul>
                                 </div>
                           </div>
                   		   <div class="clear"></div>
						   <?php foreach($lists as $row):?>
						   <div class="coop_nr">
								<div class="ft coop_nr_a">
								   <div class="mb coop_nr_a1"><a href="<?php echo site_url('cooperation/show/'.$row->task_uuid);?>" title="<?php echo $row->title;?>" target="_blank"><?php echo $row->title;?></a></div>
								   <div class="coop_nr_a2"><span><?php echo $row->views;?>人浏览</span>  |  <span class="cs"><?php echo $row->intents;?></span> 人有意向</div>
								</div>
								<div class="ft coop_nr_b">
									<div class="mb"><?php echo $row->name;?></div>
									<div><span class="cs"><?php if($row->amount!='0'){echo '￥'.$row->amount;}else{echo '商议';}?></span></div>
								</div>
								<div class="ft coop_nr_c">
									<div class="mb"><?php echo date('Y-m-d',$row->open_time);?> 发布</div>
									<div>
									<?php
									for($i=1;$i<=$row->stars;$i++)
									{
										echo '<img src="'.static_url('public/images/lace/xx.png').'">';
									}
									for($j=1;$j<=5-$row->stars;$j++ )
									{
										echo '<img src="'.static_url('public/images/lace/huixx.png').'">';
									}
									?>
									</div>
								</div>
								<div class="ft coop_nr_d">
									<div class="mb1">
									<?php
									if(empty($row->end_time))
									{
										$time = $row->open_time + 86400*$row->cycle;
									}
									else
									{
										$time = $row->end_time;
									}
									$times = $time - strtotime(date("Y-m-d H:i:s"));
									if($times > '0')
									{
										echo '<span class="cs">'.round($times/86400).'</span> 天后任务截止';
									}
									else
									{
										echo '<span style="padding-right:18px;">已结束</span>';
									}
									?>
									</div>
									<div class="sc" style=" display:none;" rel="<?php echo $row->task_uuid;?>"><a href="javascript:void(0);">收藏</a></div>
								</div>
								<div class="clear"></div>
						   </div>
						   <div class="clear"></div>
						   <?php endforeach;?>
                       </div>
                       <!--hezuo  end-->
                  </div>
                  <div class="clear"></div>
                  <!--分页 开始-->
                  <div style="width:920px;height:44px;text-align:center;margin:0 auto; margin-top:20px; margin-bottom:30px;float:left;">
					 <?php echo $this->pagination->create_links(); ?>			
				  </div>
                  <!--分页 结束-->
            </div>
        <!--right end--> 
        
	</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	//弹出对话框
	$('.dialog').click(function() {
		var uuid = '<?php echo UUID;?>';
		if(uuid == '')
		{
			window.location.href = '<?php echo site_url('trust/redirect');?>';
		}
		else
		{
			$.get("<?php echo site_url('trust/load_trust')?>",function(data){
				if(data.length >0)
				{
					$('#dialog').html(data);
					showBg('dialog','dialog_content')
				}
			});
		}
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	//更多选项展开/收起
	$(".er_more").click(function() {
		var display = '<?php echo $select['display'];?>';
		var url = '<?php echo str_replace('/display/none','',str_replace('/display/block','',$url));?>';
		if(display == 'block')
		{
			$(".wrapper").slideToggle(function(){
				location.href = url+'/display/none';
			});
			$('.zk').html('更多选项（项目类型）');
		}
		else
		{
			$(".wrapper").slideToggle(function(){
				location.href = url+'/display/block';
			});
			$('.zk').html('收起');
		}
	});

	//展开多选效果
	$('.btn').click(function(){
		var display = $(this).css('display');
		if(display == 'block')
		{
			$('.er_nav_off').hide();
			$('.er_nav_on').show();
			$(this).hide();
		}
	});

	//取消多选效果
	$('.cancel').click(function(){
		$('.er_nav_off').show();
		$('.er_nav_on').hide();
		$('.btn').show();
	});

	//提交多选属性
	$('.submit').click(function(){
		var url = '<?php echo $url;?>';
		var str='';
		$(".er_nav_on label input[type=checkbox]").each(function(){
			if(this.checked){
				str += $(this).val()+'-';
			}
		});
		location.href = url +'/checkbox/'+ str;
		$('.btn').hide();
	});

	//打开页面判断是否选择有属性
	$('.er_xuan').each(function(){
		if($(this).find('.on').length=='0')
		{
			$('.er_xuan').hide();
		}
	});

	//合作收藏
	$('.sc').click(function(){
		var uuid ='<?php echo UUID?>';
		//alert(uuid);
		if($.trim(uuid).length != 0)
		{
			var task_uuid = $(this).attr('rel');
			$.get("<?php echo site_url('cooperation/collect')?>"+'/'+task_uuid,function(data){
				if(data == 'true')
				{
					alert('成功添加收藏！');
				}
				else
				{
					alert('不可重复收藏！');
				}
			});
		}
		else
		{
			alert('登录之后才可以收藏次合作！');
		}
	});

	//列表鼠标移过变化背景颜色、显示收藏按钮
	$(".coop_nr").hover(function(){
		$(this).find(".sc").show();
		$(this).addClass("coo_lbj");
	},function(){
		$(".coop_nr .sc").hide();
		$(".coop_nr").removeClass("coo_lbj");
	});

});
</script>