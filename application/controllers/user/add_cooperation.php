<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_cooperation extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->database();
		if (!$this->is_login())
		{
			@session_start();
			$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
			redirect(site_url('user/login'), 'refresh');
		}
		$this->load->model('cooperation_model');
	}

	public function index($product_uuid = '0',$task_uuid = '')
	{
		//判断会员是否设置名片
		$this->load->model('card_model');
		$data['my_card'] = $this->card_model->my_card(UUID);

		$data['web_title'] = '合作-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$data['task_uuid'] = $task_uuid;
		$data['product_uuid'] = $product_uuid;
		if($product_uuid != '0')
		{
			$data['product_info'] = $this->cooperation_model->product_info($product_uuid);
		}

		//读取form表单的值
		$title = $this->input->post('title', TRUE); //合作标题
		$product_uuid = $this->input->post('product_uuid', TRUE); //产品uuid
		$product_step = $this->input->post('product_step', TRUE); //游戏阶段
		if($this->input->post('task_target_id_1', TRUE))
		{
			$task_target_id = $this->input->post('task_target_id_1', TRUE); //需求目标
		}
		else
		{
			$task_target_id = $this->input->post('task_target_id', TRUE); //需求目标
		}
		$product_step_percent = $this->input->post('product_step_percent', TRUE); //产品阶段

		if($this->input->post('area', TRUE))
		{
			$area = implode(',', $this->input->post('area', TRUE));  //合作区域
		}
		else
		{
			$area = $this->input->post('area', TRUE);  //合作区域
		}
		$info = $this->input->post('info', TRUE); //说明
		$start_year = $this->input->post('start_year', TRUE);
		$start_mouth = $this->input->post('start_mouth', TRUE);
		$start_day = $this->input->post('start_day', TRUE);
		$start_time = strtotime($start_year.'-'.$start_mouth.'-'.$start_day); //宣传时间
		$end_year = $this->input->post('end_year', TRUE);
		$end_mouth = $this->input->post('end_mouth', TRUE);
		$end_day = $this->input->post('end_day', TRUE);
		$end_time = strtotime($end_year.'-'.$end_mouth.'-'.$end_day); //合作有效期
		$team_step = $this->input->post('team_step', TRUE);  //团队阶段
		$amount = $this->input->post('amount', TRUE);  //金额
		$stock = $this->input->post('stock', TRUE); //转让股权

		if($this->input->post('times', TRUE)=='0')
		{
			if($this->input->post('cycle', TRUE)!='')
			{
				$cycle = $this->input->post('cycle', TRUE);
			}
			else
			{
				$cycle = '0';
			}
			$limit_time = '0';
		}
		else if($this->input->post('times', TRUE)=='1')
		{
			$cycle = '0';
			if($this->input->post('limit_time', TRUE)!='')
			{
				$limit_time = strtotime($this->input->post('limit_time', TRUE));
			}
			else
			{
				$limit_time = '0';
			}
		}

		//echo $cycle.' = '.$limit_time;

		/*if($task_target_id==4)
		{
			$cycle = $this->input->post('cycle', TRUE); //周期
			$limit_time = '';
		}
		else
		{
			if($this->input->post('times', TRUE)==0)
			{
				$cycle = $this->input->post('cycle', TRUE); //周期
				$limit_time = '';
			}
			else if($this->input->post('times', TRUE)==1)
			{
				$cycle = '';
				$limit_time = strtotime($this->input->post('limit_time', TRUE)); //限制时间
			}
			else
			{
				$cycle = '';
				$limit_time = '';
			}
		}*/
		$prospectus = $this->input->post('prospectus', TRUE); //商业计划书
		$financing = $this->input->post('financing', TRUE); //合作模式
		$partner_num = $this->input->post('partner_num', TRUE); //合作数量
		if(is_array($this->input->post('platform', TRUE)))
		{
			$platform = implode(',', $this->input->post('platform', TRUE));  //代理平台
		}
		else
		{
			$platform = $this->input->post('platform', TRUE);  //代理平台
		}
		if(is_array($this->input->post('requires', TRUE)))
		{
			$requires = implode(',', $this->input->post('requires', TRUE));  //合作公司要求
		}
		else
		{
			$requires = FALSE !== $this->input->post('requires', TRUE)?$this->input->post('requires', TRUE):'';  //合作公司要求
		}
		if($task_target_id==5 || $task_target_id==11)
		{
			$styles = $this->input->post('styles', TRUE);
		}
		else
		{
			//var_dump(is_array($this->input->post('styles', TRUE)));exit;
			if(is_array($this->input->post('styles', TRUE)))
			{
				$styles = implode(',', $this->input->post('styles', TRUE));  //美术风格
			}
			else
			{
				$styles = $this->input->post('styles', TRUE);  //美术风格
			}
		}
		$serialize_key = $this->input->post('serialize_key', TRUE);
		$serialize_value = $this->input->post('serialize_value', TRUE);

		$content_serialize = '';
		if($serialize_key && $serialize_value)
		{
			$content_arr = array();
			for($i=0;$i<count($serialize_key);$i++)
			{
				if($serialize_key[$i] && trim($serialize_key[$i]) && $serialize_value[$i] && trim($serialize_value[$i]))
				{
					$content_arr[$serialize_key[$i]] = $serialize_value[$i];
				}
			}
			if($content_arr)
			{
				$content_serialize = serialize($content_arr);
			}				
		}

		/*if(!empty($serialize_key) && !empty($serialize_value))
		{
			$serialize_key = array_filter($serialize_key);
			$serialize_value = array_filter($serialize_value);
			$content_serialize = serialize(array_combine($serialize_key, $serialize_value));
		}
		else
		{
			$content_serialize = '';
		}*/

		if(is_array($this->input->post('partner_type', TRUE)))
		{
			$partner_type = implode(',', $this->input->post('partner_type', TRUE));  //合作类型
		}
		else
		{
			$partner_type = $this->input->post('partner_type', TRUE);  //合作类型
		}

		if(is_array($this->input->post('partner_method', TRUE)))
		{
			$partner_method = implode(',', $this->input->post('partner_method', TRUE));  //合作方式
		}
		else
		{
			$partner_method = $this->input->post('partner_method', TRUE);  //合作方式
		}

		// 读取合作需求
		$data['target'] = $this->cooperation_model->product_target();

		/* 验证表单 */
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title','合作标题','trim|required');
		$this->form_validation->set_rules('task_target_id','需求目标','required');
		if($task_target_id == 4)
		{
			$this->form_validation->set_rules('amount','融资金额','required');
			$this->form_validation->set_rules('stock','出让股权','required');
			$this->form_validation->set_rules('financing','融资阶段','required');
		}

		if ($this->form_validation->run() == FALSE)
		{
			
			if($task_uuid !='')
			{
				// 读取合作详细信息
				$data['info'] = $this->cooperation_model->cooperation_info($task_uuid);
			}
			else
			{
				$data['info'] = array(
					'title'=>'',
					'task_uuid'=>'',
					'product_uuid'=>'',
					'product_step'=>'0',
					'parent' =>'0',
					'task_target_id'=>'0',
					'product_step_percent'=>'',
					'area'=>'',
					'info'=>'',
					'start_time'=>'',
					'end_time'=> strtotime(date('Y-m-d',strtotime('+1months'))),
					'team_step'=>'',
					'amount'=>'',
					'stock'=>'',
					'cycle'=>'',
					'limit_time'=>'',
					'prospectus'=>'',
					'financing'=>'',
					'partner_num'=>'',
					'platform'=>'',
					'requires'=>'',
					'styles'=>'',
					'content_serialize'=>'',
					'partner_type'=>'',
					'partner_method'=>''
				);
			}
			$this->load->view('include/header',$data);
			$this->load->view('user/add_cooperation',$data);
			$this->load->view('include/footer',$data);
		}
		else
		{
			if($task_uuid !='')
			{
				$data_form = array(
					'uuid' => UUID,
					'title'=>$title,
					'product_uuid' => $product_uuid,
					'product_step' => $product_step,
					'task_target_id' => $task_target_id,
					'product_step_percent' => $product_step_percent,
					'area' => $area,
					'info' => $info,
					'start_time' => $start_time,
					'end_time' => $end_time,
					'team_step' => $team_step,
					'amount' => $amount,
					'stock' => $stock,
					'cycle' => $cycle,
					'prospectus' => $prospectus,
					'financing' => $financing,
					'partner_num' => $partner_num,
					'platform' => $platform,
					'requires' => $requires,
					'styles' => $styles,
					'status' => '1',
					'checked' => '0',
					'content_serialize' => $content_serialize,
					'partner_type' => $partner_type,
					'partner_method' => $partner_method,
					'limit_time' => $limit_time,
					'updater' => '1',
					'update_uuid' => UUID
				);
				$this->cooperation_model->update_cooperation($data_form,$task_uuid);
			}
			else
			{
				//当前表中编号最大值
				$this->load->model('sn_model');
				$sn = $this->sn_model->sn('task');

				//task_uuid
				$sql = "select uuid() uuid";
				$q = $this->db->query($sql)->row();
				$task_uuid = $q->uuid;

				$data_form = array(
					'task_uuid' => $task_uuid,
					'title'=>$title,
					'uuid' => UUID,
					'product_uuid' => $product_uuid,
					'product_step' => $product_step,
					'task_target_id' => $task_target_id,
					'product_step_percent' => $product_step_percent,
					'area' => $area,
					'info' => $info,
					'start_time' => $start_time,
					'end_time' => $end_time,
					'team_step' => $team_step,
					'amount' => $amount,
					'stock' => $stock,
					'cycle' => $cycle,
					'prospectus' => $prospectus,
					'financing' => $financing,
					'partner_num' => $partner_num,
					'platform' => $platform,
					'requires' => $requires,
					'styles' => $styles,
					'status' => '1',
					'checked' => '0',
					'content_serialize' => $content_serialize,
					'partner_type' => $partner_type,
					'partner_method' => $partner_method,
					'limit_time' => $limit_time,
					'create_time' => strtotime(date("Y-m-d H:i:s")),
					'create_ip' => $this->input->ip_address(),
					'sn' => $sn
				);
				//print_r($data_form);exit;
				$this->cooperation_model->insert_cooperation($data_form);
			}

			if($task_uuid !='')
			{
				$data['title'] = '编辑合作信息已成功';
				$data['message'] = '编辑合作信息已成功！';
			}
			else
			{
				$data['title'] = '发布合作信息已成功';
				$data['message'] = '发布合作信息已成功！';
			}
			$data['img'] = 'true.png';
			$data['where_1'] = '我发布的合作';
			$data['url_1'] = site_url('user/cooperation');
			$data['target_1']  = '';
			$data['where_2'] = '网站首页';
			$data['url_2'] = site_url('');
			$data['target_2']  = '';
			$this->load->view('include/header',$data);
			$this->load->view('include/message',$data);
			$this->load->view('include/footer',$data);
		}

	}

	//返回相应的需求目标
	public function check_target($tid)
	{
		$tid = base64_decode(rawurldecode($tid));
		$tid = explode(',',$tid);

		//一级需求目标
		$target = $this->cooperation_model->product_target($tid);
		echo '<div class="user_form_line" style="margin-bottom:0px;">';
		echo '<span class="with_120"><em>*</em>需求目标：</span>';
		echo '<span><input name="target_id" id="target_id" tid="'.$target[0]['id'].'" sid="'.urlencode(base64_encode($target[0]['id'])).'" type="hidden" /></span>';
		if($target)
		{
			echo "<span>";
			foreach ($target as $row)
			{
				echo '<label><input type="radio" name="task_target_id" onclick="show_target(id)" id="show_'.$row['id'].'" sid="'.urlencode(base64_encode($row['id'])).'" value="'.$row['id'].'" > '.$row['name'].'</label>';
			}
			echo "</span>";
		}
		echo '</div>';
	}

	//返回相应的form表单
	public function check_show($sid='',$task_uuid='',$target_id='')
	{
		$data['sid'] = $sid;
		$task_uuid = base64_decode(rawurldecode($task_uuid));
		//echo $data['sid'].'/'.$task_uuid;exit;

		// 读取项目阶段
		$data['step'] = $this->cooperation_model->product_step();

		//平台类型
		$platform = $this->cooperation_model->platform_step();
		$this->load->helper('myfunction');
		$result = array();
		if($platform){
			foreach($platform as $k=>$v){
				$result[$v['id']]  = $v ;
			}
		}
		$plat = comment($result,'id','parent','childs');
		foreach($plat as $rows)
		{
			if(isset($rows['childs']))
			{
				foreach($rows['childs'] as $row)
				{
					$data['platform'][$row['id']] = $row['platform_name'];
				}
			}
			else
			{
				$data['platform'][$rows['id']] = $rows['platform_name'];
			}
		}

		//读取/默认合作信息
		if($task_uuid !='' && $target_id == $data['sid'])
		{
			$data['info'] = $this->cooperation_model->cooperation_info($task_uuid);
		}
		else
		{
			$data['info'] = array(
				'task_uuid'=>'',
				'product_uuid'=>'',
				'product_step'=>'0',
				'parent' =>'0',
				'task_target_id'=>'0',
				'product_step_percent'=>'',
				'area'=>'',
				'info'=>'',
				'start_time'=>'',
				'end_time'=> strtotime(date('Y-m-d',strtotime('+1months'))),
				'team_step'=>'',
				'amount'=>'',
				'stock'=>'',
				'cycle'=>'',
				'limit_time'=>'',
				'prospectus'=>'',
				'financing'=>'',
				'partner_num'=>'',
				'platform'=>'',
				'requires'=>'',
				'styles'=>'',
				'content_serialize'=>'',
				'partner_type'=>'',
				'partner_method'=>''
			);
		}

		//二级需求目标
		$data['grade'] = $this->cooperation_model->target_grade($data['sid']);

		//读取所对应的表单
		$this->load->view('user/check_form',$data);
	}

	//返回二级需求相应的form表单
	public function check_show_from($sid='',$task_uuid='',$target_id='')
	{
		$data['sid'] = base64_decode(rawurldecode($sid));
		$task_uuid = base64_decode(rawurldecode($task_uuid));
		//echo $data['sid'];exit;

		//读取/默认合作信息
		if($task_uuid !='' && $target_id == $data['sid'])
		{
			$data['info'] = $this->cooperation_model->cooperation_info($task_uuid);
		}
		else
		{
			$data['info'] = array(
				'task_uuid'=>'',
				'product_uuid'=>'',
				'product_step'=>'0',
				'parent' =>'0',
				'task_target_id'=>'0',
				'product_step_percent'=>'',
				'area'=>'',
				'info'=>'',
				'start_time'=>'',
				'end_time'=> strtotime(date('Y-m-d',strtotime('+1months'))),
				'team_step'=>'',
				'amount'=>'',
				'stock'=>'',
				'cycle'=>'',
				'limit_time'=>'',
				'prospectus'=>'',
				'financing'=>'',
				'partner_num'=>'',
				'platform'=>'',
				'requires'=>'',
				'styles'=>'',
				'content_serialize'=>'',
				'partner_type'=>'',
				'partner_method'=>''
			);
		}

		//读取所对应的表单
		$this->load->view('user/check_form',$data);
	}

	//载入名片提示内容
	public function load()
	{
		echo '
		<dl>
			<dt></dt>
			<dd><a href="javascript:;" onclick="closeBg();"><img src="'.static_url('public/images/lace/cuo.gif').'"></a></dd>
		</dl>
		<ul class="dia_start">
			<li>
				<h5>您还没有生成名片，其他用户将不能看到您的联系方式</h5>
				<p>建议您完善"账户资料"、填写"我的公司"、生成"个人名片"</p>
			</li>
			<li><a href="'.site_url('user/card').'" class="cooplist_m">立即前往</a> <a href="javascript:;" onclick="closeBg();" class="cooplist_m1">稍后前往</a></li>
		</ul>
		';
	}
}