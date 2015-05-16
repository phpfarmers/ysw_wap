    <div class="main">
        <div class="page1">
           <!--left start-->
            <div class="coop_lf">
                <div class="new">
                    <div class="new_nav">
						   <div class="new_nav_l">
							   <span><img src="<?php echo static_url('public/images/home.gif');?>"></span> 
							   <span><a href="<?php echo site_url();?>">首页</a></span> 
							   <span> > </span>
							   <span style=" color:#333">所有公司</span>
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
										//公司类型
										if($key=='type')
										{
											foreach($company_type as $key_p=>$value_p)
											{
												if($value == $key_p)
												{
													if(in_array('type_t',$sort))
													{
														echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>公司类型：'.$value_p.'<a href="'.str_replace('/type_t/'.$select['type_t'],'',str_replace('/'.$key.'/'.$value,'',$url)).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
													}
													else
													{
														echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>公司类型：'.$value_p.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
													}
												}
											}
										}
										//公司类型(二级)
										if($key=='type_t')
										{
											foreach($type_t as $key_t=>$value_t)
											{
												if($value == $key_t)
												{
													echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>'.$company_type[$select['type']].'：'.$value_t.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
												}
											}
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
									<li class="er_xuan_b"><a href="<?php echo site_url('company');?>">重新筛选条件</a></li>
									<div class="clear"></div>
								</ul>
								<div class="clear"></div>
							</div>

							<?php if(!in_array('type',$sort)):?>
                            <dl>
                                <dt>公司类型：</dt>
                                <dd>
								<?php 
								foreach($company_type as $key=>$value)
								{
									echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/type/'.$key.'">'.$value.'</a>';
								}
								?></dd>
                            </dl>
							<?php endif;?>
							<?php
							if(!in_array('type_t',$sort))
							{
								if(!empty($type_t))
								{
									echo '<dl><dt>'.$company_type[$select['type']].'：</dt><dd>';
									foreach($type_t as $key=>$value)
									{
										if(in_array('page',$sort))
										{
											echo '<a href="'.str_replace('/page/'.$select['page'],'',$url).'/type_t/'.$key.'">'.$value.'</a>';
										}
										else
										{
											echo '<a href="'.$url.'/type_t/'.$key.'">'.$value.'</a>';
										}
									}
									echo '</dd></dl>';
								}
							}
							?>
                            <div class="clear"></div>
                     </div>
                    <!--二nav end-->
                    <div class="coopcon">
                        <div class="coop_hz">
                            <div class="ft coop_hsou">为您找到 <span><?php echo $total;?></span> 家公司</div>
                            <div class="gt coop_cp_a">
								<div class="coop_hz_q" style="margin-right:0px;">
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
                                <!--<span><a href="<?php echo str_replace('/order/create_time-desc','',$url).'/order/create_time-desc';?>" class="asc">最新</a> | <span><a href="#">最火</a></span>-->
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                        <div class="new_company">
                            <ul>
								<?php foreach($lists as $row):?>
                                <li>
                                    <div class="ft new_company_a"><a href="<?php echo site_url('company/show/'.$row->company_uuid);?>"><img src="<?php if($row->company_pic){echo static_url('uploadfile/image/company/'.$row->company_pic);}else{echo static_url('public/images/small_tu/hui.jpg');}?>" width="120" height="120"></a></div>
                                    <div class="gt new_company_b">
                                        <h3><a href="<?php echo site_url('company/show/'.$row->company_uuid);?>" target="_blank"><?php echo $row->company_name;?></a><?php if($row->checked == 0){echo '<em style="color:#f00;margin-left:5px;font-size:12px;">(未审核)</em>';}?></h3>
                                        <div class="new_company_c">地点：<span><?php echo $region_all[$row->province].' '.$region_all[$row->city];?></span></div>
                                        <div class="new_company_c">简介：<span><?php echo cut_str($row->company_desc,108,'...');?></span> <a href="<?php echo site_url('company/show/'.$row->company_uuid);?>" target="_blank">[查看详细]</a></div>
                                    </div>
                                </li>
								<?php endforeach;?>
                            </ul> 
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <!--分页 开始-->
                <div style="width:920px;height:44px;text-align:center;margin:0 auto; margin-top:25px; margin-bottom:25px;float:left;">
					<?php echo $this->pagination->create_links(); ?>				
             </div>
             <!--分页 结束-->
            </div>
            <!--left end--> 
            <!--right start-->
            <div class="coop_rt"> 
                <div class="release"><a href="<?php echo site_url('company/add_company');?>" target="_blank"><span class="pub1_tu"></span><p class="rel_pp">公司入驻</p></a></div>
				<?php $this->product->_new_product($new,$type);?>
				<?php $this->task->_hot_task($hot);?>                
            </div>
            <!--right end-->
            <div class="clear"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	//打开页面判断是否选择有属性
	$('.er_xuan').each(function(){
		if($(this).find('.on').length=='0')
		{
			$('.er_xuan').hide();
		}
	});
});
</script>