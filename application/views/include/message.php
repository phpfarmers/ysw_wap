<style type="text/css">
#timer{color:#FF0000;font-weight:bold;}
</style>
<div class="main">
	<div class="page">
		<div class="login">
        	<div class="message">
            	<div class="message_title"><img src="<?php echo static_url('public/images').'/'.$img;?>"/><h2><?php echo $title ; ?></h2></div>
                <div class="message_content"><p><?php echo $message ; ?></p>
                <a href="<?php echo $url_1 ; ?>" <?php echo $target_1 ;?>><?php echo $where_1 ; ?></a><?php if($where_2 != '' && $url_2 != ''){?><a href="<?php echo $url_2 ; ?>" <?php echo $target_2 ;?>><?php echo $where_2 ; ?></a><?php }?>
                </div>
            </div>
		</div>
	</div>
</div>
<script type='text/javascript'>
var second = 5;
var show = document.getElementById('timer');
if(show != null)
{
	setInterval(function(){
		show.innerHTML = second - 1;
		second--;
		if( second <= 0 ){
			window.location.href = '<?php echo $url_1 ?>';
		}
	},1000);
}
</script>