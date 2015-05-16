   <?php if($num <= 4):?>
   <div class="card_right">
   <?php else:?>
   <div class="card_right card_rt1">
   <?php endif;?>
		<dl>
			<?php
			echo '<dt>';
			if(in_array('first_name',$str))
			{
				if(!empty($card->realname))
				{
					if(iconv_strlen($card->realname,"UTF-8")<=3)
					{
						$j = iconv_strlen($card->realname,"UTF-8")-1;
						echo cut_str($card->realname,1,'');
						echo '<strong>';
						for($i=0;$i < $j;$i++)
						{
							echo '*';
						}
						echo '</strong>';
					}
					else
					{
						$j = iconv_strlen($card->realname,"UTF-8")-2;
						echo cut_str($card->realname,2,'');
						echo '<strong>';
						for($i=0;$i < $j;$i++)
						{
							echo '*';
						}
						echo '</strong>';
					}
				}
				else
				{
					echo '姓<strong>*</strong>';
				}
			}
			else
			{
				if(in_array('realname',$str))
				{
					if(!empty($card->realname))
					{
						echo $card->realname;
					}
					else
					{
						echo '姓名';
					}
				}
				elseif(in_array('nickname',$str))
				{
					if(!empty($card->nickname))
					{
						echo $card->nickname;
					}
					else
					{
						echo '昵称';
					}
				}
				else
				{
					echo '姓名或昵称';
				}
			}

			//职位
			if(in_array('job',$str))
			{
				echo '<span> / ';
				if(!empty($card->employee_position))
				{
					echo $card->employee_position;
				}
				else
				{
					echo ' 职位 ';
				}
				echo '</span></dt>';
			}
			
			//公司
			if(in_array('company',$str))
			{
				echo '<dd>公司：';
				if(!empty($card->company_name))
				{
					echo $card->company_name;
				}
				else
				{
					echo ' - ';
				}
				echo '</dd>';
			}

			//手机
			if(in_array('mobile',$str))
			{
				echo '<dd class="card_rt2">手机：';
				if(!empty($card->mobile))
				{
					echo $card->mobile;
				}
				else
				{
					echo ' - ';
				}
				echo '</dd>';
			}

			//QQ
			if(in_array('qq',$str))
			{
				echo '<dd class="card_rt2">Q Q：';
				if(!empty($card->qq))
				{
					echo $card->qq;
				}
				else
				{
					echo ' - ';
				}
				echo '</dd>';
			}
			echo '<div class="clear"></div>';

			//邮箱
			if(in_array('email',$str))
			{
				echo '<dd>邮箱：';
				if(!empty($card->email))
				{
					echo $card->email;
				}
				else
				{
					echo ' - ';
				}
				echo '</dd>';
			}

			//微信
			if(in_array('weixin',$str))
			{
				echo '<dd>微信：';
				if(!empty($card->weixin))
				{
					echo $card->weixin;
				}
				else
				{
					echo ' - ';
				}
				echo '</dd>';
			}
			?>
		</dl>
   </div>