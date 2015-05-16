<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check extends MY_Controller {


	public function __construct()
	{
		parent::__construct();
	}

	//查询公司列表
	public function check_company_list($str)
	{
		$company_name = urldecode($str);
		if(strlen($company_name) > 0) {
			$this->load->model("check_model");
			if($this->check_model->company_name_list($company_name,UUID))
			{
				echo '<ul>';
				foreach ($this->check_model->company_name_list($company_name,UUID) as $row)
				{
					if($row['checked']=='0')
					{
						echo '<li onClick="fill(\''.$row['company_name'].'\',\''.$row['company_uuid'].'\');">'.$row['company_name'].' (未审核)</li>';
					}
					else
					{
						echo '<li onClick="fill(\''.$row['company_name'].'\',\''.$row['company_uuid'].'\');">'.$row['company_name'].'</li>';
					}
				}
				echo '</ul>';
			}
		}
	}

	//返回公司详细信息
	public function check_company_info($company_uuid = '')
	{
		if(strlen($company_uuid) > 0) {
			$this->load->model("check_model");
			$data = $this->check_model->company_info($company_uuid);
		}
		else
		{
			$data = array(
				'company_uuid' => '',
				'company_name' => '',
				'company_pic' => '',
				'company_type' => '',
				'company_size' => '',
				'province' => 25,
				'city' => 2703,
				'company_desc' => '',
				'company_address' => '',
				'company_web' => '',	
				'company_phone' => '',
				'company_email' => ''
			);
		}
		//读取所在区域
		$this->load->model('region_model');
		$data['provinces'] = $this->region_model->provinces();
		$data['citys'] = $this->region_model->children_of($data['province']);

		//游戏类型
		$this->load->model('company_model');
		$list = $this->company_model->company_type();
		$this->load->helper('myfunction');
		$result = array();
		if($list){
			foreach($list as $k=>$v)
			{
				$result[$v['id']]  = $v ;
			}
		}
		$data['company_types'] = comment($result,'id','parent','childs');
		$this->load->view('user/check_company_info',$data);
	}

	//查询已审核和我添加未删除的产品列表
	public function check_product_list($str)
	{
		$product_name = urldecode($str);
		if(strlen($product_name) > 0) {
			$this->load->model("check_model");
			if($this->check_model->product_name_list($product_name,UUID))
			{
				echo '<ul>';
				foreach ($this->check_model->product_name_list($product_name,UUID) as $row){
					echo '<li onClick="fill(\''.$row['product_name'].'\',\''.$row['product_uuid'].'\');">'.$row['product_name'].' - '.$row['company_name'].'</li>';
				}
				echo '</ul>';
			}
		}
	}

	//返回公司详细信息
	public function check_product_info($product_uuid = '')
	{
		//echo $product_uuid;
		$this->load->model("check_model");
		$product_info = $this->check_model->linked_product_info($product_uuid);
		if(!$product_info['product_icon'])
		{
			$product_info['product_icon'] = static_url('public/images/card.jpg');
		}
		echo '<dl>
				<dd><img src="'.static_url('uploadfile/image/product/'.$product_info['product_icon']).'" width="80" height="80"></dd>
				<dd class="dem_a">'.$product_info['product_name'].'<p class="dem_a1">'.$product_info['company_name'].'</p></dd>
				<dd class="dem_b"><input type="button" value="重新选择游戏" class="user_submit" onClick="reselect()"/></dd>
				<div class="clear"></div>
			</dl>
			<div class="clear"></div>
			<input type="hidden" id="product_uuid" name="product_uuid" value="'.$product_info['product_uuid'].'"/>
			<input type="hidden" id="company_uuid" name="company_uuid" value="'.$product_info['company_uuid'].'"/>
			';
	}

	public function reselect_product()
	{
		echo '
			<div class="demand_p">
				<div><label><input class="dem_input" type="text" name="product" value="" id="str" onkeyup="lookup(this.value);" onmouseout="hove()" onblur="move(value)" placeholder="请输入游戏名称，并在下拉菜单中选择" original-title="" /><a href="javascript:;" id="linked" class="demand_a" onClick="show(\'product_uuid\')">确认选择</a></label> </div>
				<div class="clear"></div>
				<div class="demand_d"><span>*</span> 若为空，则表示您将要发布的合作没有产品，若没有您想要的产品信息，请<a href="'.base_url('user/add_product').'">添加新产品</a></div>
				<input type="hidden" id="product_uuid" name="product_uuid" value=""/>
				<div class="autobox" id="auto" style="display:none;">
					<div class="autolist" id="autolist">
					</div>
				</div>
			</div>
		';
	}

	//查询添加的公司是否存在
	public function check_company($str)
	{
		$company_name = urldecode($str);
		$this->load->model("check_model");
		$num = $this->check_model->Check_company($company_name);
		if($num >= 1)
		{
			echo $num;
		}
	}

}
