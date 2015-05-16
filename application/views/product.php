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
							   <span style="color:#333">所有产品</span>
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
									//是否单机
									if($key=='single_type')
									{
										if($value == '0')
										{
											echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>是否单机：否<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
										}
										else
										{
											echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>是否单机：是<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
										}
									}
									//游戏类型
									if($key=='plat')
									{
										foreach($plat as $key_p=>$value_p)
										{
											if($value == $key_p)
											{
												if(in_array('plat_t',$sort))
												{
													echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>游戏平台：'.$value_p.'<a href="'.str_replace('/plat_t/'.$select['plat_t'],'',str_replace('/'.$key.'/'.$value,'',$url)).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
												}
												else
												{
													echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>游戏平台：'.$value_p.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
												}
											}
										}
									}
									//游戏类型(二级)
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
									//radio1
									if($key=='radio1')
									{
										foreach($radio1 as $key_r=>$value_r)
										{
											if($value == $key_r)
											{
												echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>游戏类型：'.$value_r.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
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
												echo '<li class="on" data_url="'.$key.'/'.$value.'"><span>游戏类型：'.$value_r.'<a href="'.str_replace('/'.$key.'/'.$value,'',$url).'"><img src="'. static_url('public/images/lace/cha.gif').'" /></a></span></li>';
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
								}
								?>
								<li class="er_xuan_b"><a href="<?php echo site_url('products');?>">重新筛选条件</a></li>
								<div class="clear"></div>
							</ul>
							<div class="clear"></div>
						</div>
						  <?php if(!in_array('single_type',$sort)):?>
                          <dl>
                                <dt>是否单机：</dt>
								<?php if(in_array('page',$sort)):?>
									<dd><a href="<?php echo str_replace('/page/'.$select['page'],'',$url).'/single_type/0';?>" class="er_a">否</a></dd>  
									<dd><a href="<?php echo str_replace('/page/'.$select['page'],'',$url).'/single_type/1';?>">是</a></dd>
								<?php else:?>
									<dd><a href="<?php echo $url.'/single_type/0';?>" class="er_a">否</a></dd>  
									<dd><a href="<?php echo $url.'/single_type/1';?>">是</a></dd>
								<?php endif;?>
                            </dl>
							<?php endif;?>
							<?php if(!in_array('plat',$sort)):?>
                            <dl>
                                <dt>游戏平台：</dt>
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
							<?php if(!in_array('radio1',$sort) || !in_array('radio2',$sort) || !in_array('checkbox',$sort)):?>
                            <div class="er_attrid wrapper" <?php if($select['display'] == 'block'){echo 'sytle="display:block;"';}else{echo 'style="display:none;"';}?>>
                                <div class="er_nav_pt">游戏类型：</div>
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
                     <div class="coopcon">
                        <div class="coop_hz">
                            <div class="ft coop_hsou">为您找到 <span><?php echo $total;?></span> 个产品</div>
                            <div class="gt coop_cp_a">
                                <!--<span class="coop_hz_q coop_cp_a2"><a href="#">所有地区</a></span>-->
                                <span><a href="<?php echo str_replace('/order/create_time-desc','',$url).'/order/create_time-desc';?>" class="asc">最新</a></span><!-- | <span><a href="#">最火</a></span>-->
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                        <div class="newcoop">
								<?php foreach($products as $row):?>
                                <dl>
                                    <dt><a href="<?php echo site_url('products/show/'.$row->product_uuid);?>" target="_blank"><img src="<?php if($row->product_icon){echo static_url('uploadfile/image/product/'.$row->product_icon);}else{echo static_url('public/images/small_tu/hui.jpg');}?>" width="180" height="180"></a></dt>
                                    <dd class="newcon_aa"><a href="<?php echo site_url('products/show/'.$row->product_uuid);?>" target="_blank"><?php echo cut_str($row->product_name,6,'…');?></a><?php if($row->checked == 0){echo '<em style="color:#f00;margin-left:5px;font-size:12px;">(未审核)</em>';}?></dd>
                                    <dd style="width:150px;display:block;overflow:hidden;white-space:nowrap;-o-text-overflow: ellipsis;text-overflow:ellipsis;">类型：<?php
									$arr_types = array_filter(explode(',',$row->radio1.','.$row->radio2.','.$row->product_type));
									$arr_type = array_slice($arr_types,0,3);
									$m = 0;
									foreach($arr_type as $value)
									{
										$m++;
										echo $type[$value];
										if($m<count($arr_type))
										{
											echo '、';
										}
									}
									if(count($arr_types)>3)
									{
										echo '...';
									}
									?></dd>
                                    <dd style="width:150px;display:block;overflow:hidden;white-space:nowrap;-o-text-overflow: ellipsis;text-overflow:ellipsis;">平台：<?php
									$platforms = array_filter(explode(',',$row->product_platform));
									$product_platform = array_slice($platforms,0,2);
									$n = 0;
									foreach($product_platform as $value)
									{
										$n++;
										echo $platform[$value];
										if($n<count($product_platform))
										{
											echo '、';
										}
									}
									if(count($platforms)>2)
									{
										echo '...';
									}
									?></dd>
                                </dl>
								<?php endforeach;?>
                                <div class="clear"></div>
                        </div>
                     </div>
                </div>
                <div class="clear"></div>
                <!--分页 开始-->
                <div style="width:920px;height:44px;text-align:center;margin:0 auto; margin-top:20px; margin-bottom:30px;float:left;">
				     <?php echo $this->pagination->create_links(); ?>				
             </div>
             <!--分页 结束-->
            </div>
            <!--left end--> 
            <!--right start-->
            <div class="coop_rt"> 
                <div class="release"><a href="<?php echo site_url('user/add_cooperation');?>" target="_blank"><span class="pub1_tu"></span><p class="rel_pp">添加产品</p></a></div>
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

});
</script>