<dl>
	<dt>结束合作</dt>
	<dd><a href="javascript:void(0);" onclick="closeBg();"><img src="<?php echo static_url('public/images/lace/cuo.gif');?>"></a></dd>
</dl>
<div class="tabPanel2">
	<ul class="tab">
		<li class="hit2"><a href="javascript:void(0);">重点关注</a></li>
		<li><a href="javascript:void(0);">显示全部</a></li>
	</ul>
	<div class="panes2">
		<div class="pane2" style="display:block;">
			<?php
			echo form_open('cooperation/task_ending',array('id' =>'myform1'));
			echo '<input type="hidden" name="task_uuid" value="'.$task_uuid.'">';
			$i = 0;
			foreach($lists as $row)
			{
				if($row->attention == '1')
				{
					$i++;
					if($i % 2 == '0')
					{
						echo '<ul class="pane_ul">';
					}
					else
					{
						echo '<ul>';
					}
					echo '<li><input name="create_uuid[]" type="checkbox" value="'.$row->create_uuid.'"/> '.$row->nickname.'</li>';
					if($row->province !='' && $row->city !='')
					{
						echo '<li>'.$region[$row->province].'-'.$region[$row->city].'</li>';
					}
					else
					{
						echo '<li>未填写</li>';
					}
					echo '<li class="sc_pane sc_pane_currer"><a href="javascript:void(0);">已关注</a></li>';
					echo '</ul>';
				}
			}
			echo form_close();
			?>
		</div>
		<div class="pane2" style=" display:none;">
			<?php
			echo form_open('cooperation/task_ending',array('id' =>'myform2'));
			echo '<input type="hidden" name="task_uuid" value="'.$task_uuid.'">';
			$j = 0;
			foreach($lists as $row)
			{
				$j++;
				if($j % 2 == '0')
				{
					echo '<ul class="pane_ul">';
				}
				else
				{
					echo '<ul>';
				}
				echo '<li><input name="create_uuid[]" type="checkbox" value="'.$row->create_uuid.'"/> '.$row->nickname.'</li>';
				if($row->province !='' && $row->city !='')
				{
					echo '<li>'.$region[$row->province].'-'.$region[$row->city].'</li>';
				}
				else
				{
					echo '<li>未填写</li>';
				}
				if($row->attention == '1')
				{
					echo '<li class="sc_pane sc_pane_currer"><a href="javascript:void(0);">已关注</a></li>';
				}
				else
				{
					echo '<li class="sc_pane"><a href="javascript:void(0);">未关注</a></li>';
				}
				echo '</ul>';
			}
			echo form_close();
			?>
		</div>
	</div>
	<div class="clear"></div>
	<div class="cooplist_pro_a1 pan_que"><div class="submit"><a class="submit_b" id="submit" rel="myform1" href="javascript:void(0);" style="display:block;">确定合作</a>
	<a class="submit_b" id="submit" rel="myform2" href="javascript:void(0);" style="display:none;">确定合作</a></div><p>合作成功后，您与您的合作伙伴将获得+1威望奖励</p></div>
</div>
<script type="text/javascript">
$(function(){	
	$('.tab li').click(function(){
		$('.pane2 li').find('input').removeAttr("checked");
		$(this).addClass('hit2').siblings().removeClass('hit2');
		$('.panes2>div:eq('+$(this).index()+')').show().siblings().hide();
		$('.submit>a:eq('+$(this).index()+')').show().siblings().hide();
	})
})

$(document).ready(function(){
	//判断合作数量
	var partner_num = <?php echo $partner_num;?>;
	$('input[type=checkbox]').click(function()
	{
		if(partner_num == 0)
		{
			if($("input[type='checkbox']:checked").length > 1)
			{
				$(this).removeAttr("checked");
				alert("此合作最多只能选择1个合作对象！");
				return false;
			}
		}
	});
	//结束合作
	$('.submit_b').click(function(){
		if($("input[type='checkbox']:checked").length <= 0)
		{
			alert("请先选择合作对象！");
			return false;
		}
		else
		{
			var sid = $(this).attr('rel');
			document.getElementById(sid).submit()
		}
	});
});
</script>