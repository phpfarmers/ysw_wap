<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ad {

	/* 热门合作 */
	public function _task_ad()
	{
		echo '
		<div class="coop_newp">
			<div class="coop_bigt">
			   <ul>
				   <li><a href="'.site_url('data/add_data').'" target="_blank"><img src="'.static_url('public/images/big_tu/big1.jpg').'" /></a></li>
				   <li><a href="'.site_url('information/index/category/7').'" target="_blank"><img src="'.static_url('public/images/big_tu/big2.jpg').'" /></a></li>
				   <li><a href="'.site_url('trust').'" target="_blank"><img src="'.static_url('public/images/big_tu/big3.jpg').'" /></a></li>
			   </ul>
			</div>
		</div>
		';
	}

}