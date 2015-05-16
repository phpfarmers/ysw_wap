<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cooperation extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->lang->load('task');
		$this->load->model('task_model');
		$this->load->model('product_model');
	}

	public function index()
	{
		$this->output->cache($this->config->config['cache_time']/60);
		$this->_list();
	}

	protected function _list()
	{

		
		/**
		 * url组合规则
		 * class/function/step/type/platform/area/target/keywords/orderby/page
		 * 类型 type 组合规则 radio1-radio2-checkbox1_checkbox2....
		 */
		$this->load->model('step_model');
		$this->load->model('producttype_model');
		$this->load->model('platform_model');
		$this->load->model('target_model');
		$this->load->model('company_model');
		$this->load->model('area_model');
		$this->load->helper('text');
		$this->load->helper('array');
		$this->load->helper('myfunction');
		//组装url
		$segment = array('radio1','radio2','type','pplatform','platform','area','target','keywords','orderby','page_size');//定义取值范围
		$arr_segment = 'index' === $this->uri->segment(2)?$this->uri->uri_to_assoc(3,$segment):$this->uri->uri_to_assoc(2,$segment);//获取分段
		if($this->input->post() && !$this->input->post('all',TRUE))
		{
			$arr_segment = $this->input->post(NULL,TRUE);
			if($t = $this->input->post('type',TRUE))
			{
				$str = "";
				$j = count($t);
				if($j>0)
				{
					for($i=0;$i<$j;$i++)
					{
						$str .= $t[$i].'_';
					}
					$str = trim($str,'_');
				}
				else
				{
					$str = $t;
				}
				$arr_segment['type'] = $str;
			}

		}
		$anchor_link = site_url('cooperation/index').'/'.$this->uri->assoc_to_uri(elements($segment,$arr_segment,0));//url组装结果
		$data['segment'] = elements($segment,$arr_segment);
		//设置不同筛选链接
		$data['radio1_link'] = site_url('cooperation/index').'/'.$this->uri->assoc_to_uri(elements(array('radio2','type','pplatform','platform','area','target','keywords','orderby'),$arr_segment,0));
		$data['radio2_link'] = site_url('cooperation/index').'/'.$this->uri->assoc_to_uri(elements(array('radio1','type','pplatform','platform','area','target','keywords','orderby'),$arr_segment,0));
		$data['type_link'] = site_url('cooperation/index').'/'.$this->uri->assoc_to_uri(elements(array('radio1','radio2','pplatform','platform','area','target','keywords','orderby'),$arr_segment,0));
		$data['platform_link'] = site_url('cooperation/index').'/'.$this->uri->assoc_to_uri(elements(array('radio1','radio2','type','pplatform','area','target','keywords','orderby'),$arr_segment,0));
		$data['pplatform_link'] = site_url('cooperation/index').'/'.$this->uri->assoc_to_uri(elements(array('radio1','radio2','type','platform','area','target','keywords','orderby'),$arr_segment,0));
		$data['area_link'] = site_url('cooperation/index').'/'.$this->uri->assoc_to_uri(elements(array('radio1','radio2','type','pplatform','platform','target','keywords','orderby'),$arr_segment,0));
		$data['target_link'] = site_url('cooperation/index').'/'.$this->uri->assoc_to_uri(elements(array('radio1','radio2','type','pplatform','platform','area','keywords','orderby'),$arr_segment,0));
		$data['keywords_link'] = site_url('cooperation/index').'/'.$this->uri->assoc_to_uri(elements(array('radio1','radio2','type','pplatform','platform','area','target','orderby'),$arr_segment,0));
		$data['orderby_link'] = site_url('cooperation/index').'/'.$this->uri->assoc_to_uri(elements(array('radio1','radio2','type','pplatform','platform','area','target','keywords','page_size'),$arr_segment,0));
		$data['orderby_link'] =	anchor_url($data['orderby_link'], $anchor = array('hot','new','intents','amount'),$data['segment']['orderby']);//组装url
		$data['page_link'] = site_url('cooperation/index').'/'.$this->uri->assoc_to_uri(elements(array('radio1','radio2','type','pplatform','platform','area','target','keywords','orderby'),$arr_segment,0));
		
		//组装查询条件
		$where = $order_by = '';
		//product table
		$type_id = isset($arr_segment['type'])?$arr_segment['type']:0;
		$radio2_id = isset($arr_segment['radio2'])?intval($arr_segment['radio2']):0;
		$radio1_id = isset($arr_segment['radio1'])?intval($arr_segment['radio1']):0;
		$platform_id = isset($arr_segment['platform'])?intval($arr_segment['platform']):0;
		$pplatform_id = isset($arr_segment['pplatform'])?intval($arr_segment['pplatform']):0;
		$product_uuid = $this->_get_product_id($type_id,$pplatform_id,$radio1_id,$radio2_id);//取得符合条件product_uuid
		$true = TRUE;//判断有无查询条件结果
		if('all' !==$product_uuid)
		{
			if($product_uuid)
			{
				$where = 'ysw_task.product_uuid in ('.array2str($product_uuid).')';//正常查询product_uuid
			}
			else
			{
				$where = "ysw_task.id = 0";//无product_uuid错误
				$true = FALSE;
			}
		}
		$data['keywords'] = $keywords = isset($arr_segment['keywords'])?$arr_segment['keywords']:'';
		/*
		//待定搜索产品  暂时不用
		if($keywords && $true)
		{
			$keywords_id = $this->_get_product_by_key($keywords,$product_uuid);
			if($keywords_id)
			{
				$where .= $where?' and ysw_task.product_uuid in ('.array2str($keywords_id).')':'ysw_task.product_uuid in ('.array2str($keywords_id).')';//正常查询product_uuid
			}
			else
			{
				$where = "ysw_task.id = 0";//无product_uuid错误
				$true = FALSE;
			}
		}
		*/

		//task table
		$step_id = isset($arr_segment['step']) && $arr_segment['step']?intval($arr_segment['step']):0;
		/*暂时不用
		if($step_id)
			$where = $where?$where.' and ysw_task.product_step = '.$step_id: 'ysw_task.product_step = '.$step_id;
		
		$area_id = $arr_segment['area']?$arr_segment['area']:0;
		if($area_id)
		{
			$where = $where?$where.' and ysw_task.area = '.$area_id: 'ysw_task.area = '.$area_id;	
		}
		*/
		$target_id = isset($arr_segment['target'])?$arr_segment['target']:'0_0';
		if($true)
		{
			$get_target_id = $this->_get_target_id($target_id);
			if('all' !== $get_target_id && $get_target_id)
			{
				$where = $where?$where.' and ysw_task.task_target_id in ('.array2str($get_target_id).')': 'ysw_task.task_target_id in ('.array2str($get_target_id).')';
			}

			if($keywords)
				$where = $where?$where.' and ysw_task.title like "%'.$keywords.'%"': 'ysw_task.title like "%'.$keywords.'%"';
		}
		$where = $where?$where.' and ysw_task.status = 1 and ysw_task.checked = 1': 'ysw_task.status = 1 and ysw_task.checked = 1';
		//$where = $where?$where.' and ysw_task.task_target_id != 4': 'ysw_task.task_target_id != 4';//jeff 2014/12/16 去投资
		//$where = $where?$where.' and ysw_task.product_step != 1': 'ysw_task.product_step != 1';//jeff 2014/12/16 去立项
		if($platform_id)
			$where = $where?$where.' and find_in_set('.$platform_id.',ysw_task.platform)': 'find_in_set('.$platform_id.',ysw_task.platform)';//jeff 2014/12/16 去立项
		
		
		//order by
		$orderby = isset($arr_segment['orderby'])?$arr_segment['orderby']:0;
		if($orderby)
			$order_by = $this->_order_by($orderby,array('open_time','recommend','intents','amount'));

		//page_num
		$pagesize = isset($arr_segment['page_size'])?intval($arr_segment['page_size']):0;
		
		//分页
		$this->load->library('pagination');
		$config['base_url'] = $data['page_link'].'/page_size/';
		
		$config['my_segment'] = $pagesize;
		$config['per_page'] = $this->pagination->per_page;
		$query_data = $this->task_model->lists($pagesize,$config['per_page'],$where,$order_by,array('product_uuid','task_target_id'));
		$data['data'] = $query_data['data'];
		$data['anchor_link'] = $anchor_link;

		if(isset($query_data['product_uuids']) && $query_data['product_uuids'])
		{
			$get_name_array = $this->product_model->get_name_array('product_uuid',$query_data['product_uuids'],array('company_uuid'=>'company_uuid','product_icon'=>'product_icon'));
			$data['product_name'] = isset($get_name_array['product_uuid'])?$get_name_array['product_uuid']:'';//取集合产品product_uuid=>product_name
			$data['product2company'] = isset($get_name_array['company_uuid'])?$get_name_array['company_uuid']:'';//取集合product_uuid=>company_uuid
			$data['product_icon'] = isset($get_name_array['product_icon'])?$get_name_array['product_icon']:'';//取集合product_uuid=>company_uuid
			$data['company_name'] = $this->company_model->get_names($data['product2company']);//取集合公司名company_uuid=>company_name				
		}
		
		//组装筛选器		
		$targets = '';
		$step_list = $type_list = $area_list = $target_list = $platform_list = $platform_list_arr = array();
		/*
		$steps = $this->step_model->lists("id != 1");
		$data['step_list'] = $steps['data'];
		$data['step_name'] = $steps['name'];
		$targets = $steps['targets'];//取step绑定target集体
		$data['target_in'] = $this->_target_in($targets,$step_id);//取符合当前条件的target_id集合
		$data['step_in'] = $this->_step_in($targets,$target_id);//取符合当前条件的step_id集合
		*/
		$type_list = $this->producttype_model->lists('*',array('status'=>0));
		if($type_list)
		{
			foreach($type_list as $k=>$v)
			{
				$data['type_list'][$v->input_name][] = array('name'=>$v->type_name,'id'=>$v->id);
			}
		}
		$platform_list = $this->platform_model->lists('',"order asc");
		if($platform_list)
		{
			foreach($platform_list as $k=>$v)
			{
				$platform_list_arr[$v->parent][$v->id] = $v->platform_name;
			}
		}
		$data['platform_list'] = $platform_list_arr;
		$data['area_list'] = $this->area_model->get_name('id');

		$data_target = $this->target_model->lists();
		$datas_targets = $this->_get_targets($data_target);
		$data['target_name'] = $datas_targets['name'];
		$data['target_list'] = $datas_targets['data'];
		
		$data['total'] = $query_data['total_rows'];//总合作数
		$config['total_rows'] = $query_data['page_rows'];//分组后个数，用于分页
		$this->pagination->initialize($config);
		
		$data['web_title'] = '合作-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$data['headerh2'] = lang('Cooperation');
		$this->load->view('include/header',$data);
		$this->load->view('cooperation',$data);
		$this->load->view('include/footer',$data);
	}

	//合作收藏
	public function collect($task_uuid)
	{
		//echo $task_uuid;
		//查询是否已收藏
		$collect_num = $this->task_model->collect_num($task_uuid,UUID);
		//echo $collect_num;
		if($this->task_model->collect_num($task_uuid,UUID) > 0)
		{
			echo 'false';
		}
		else
		{
			$sql = "select uuid() uuid";
			$q = $this->db->query($sql)->row();
			$collect_uuid = $q->uuid;
			$data = array(
				'task_collection_uuid'=>$collect_uuid,
				'uuid'=>UUID,
				'task_uuid'=>$task_uuid,
				'create_time'=>strtotime(date("Y-m-d H:i:s"))
			);
			$this->task_model->add_collect($data);
			echo 'true';
		}

	}

	//合作详细页
	public function show()
	{
		$this->load->helper('myfunction');
		$this->load->model('region_model');
		$this->load->model('platform_model');
		$task_uuid = $this->uri->segment(3);
		if(!$task_uuid || strlen(trim($task_uuid)) !== 36)
			redirect(site_url('cooperation'));		
		//合作详细信息
		$data['task_info'] = $this->task_model->fetch_id($task_uuid);
		if(!$data['task_info'])
			redirect(site_url('cooperation'));

		//取省市
		$data['areas'] = '';
		$areas = array();
		if($data['task_info']->province) $areas[] = $data['task_info']->province;
		if($data['task_info']->city) $areas[] = $data['task_info']->city;
		if($areas) $data['areas'] = $this->region_model->get_name('id',$areas);
		
		if('6' === $data['task_info']->task_target_id)
		{
			//取平台类型
			$data['platforms'] = $this->platform_model->get_name();		
		}

		$data['web_title'] = $data['task_info']->title.' - 合作 - 游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$data['headerh2'] = lang('Cooperation');
		$this->load->view('include/header',$data);
		$this->load->view('task_show',$data);
		//$this->load->view('include/footer',$data);
	}


	//加载留言
	public function comment($task_uuid,$order,$num)
	{
		//表情
		$this->load->helper('smiley');
		$this->load->library('table');
		$image_array = get_clickable_smileys(static_url('public/smileys/'), 'comments');
		$col_array = $this->table->make_columns($image_array, 20);  
		$data['smiley_table'] = $this->table->generate($col_array);

		//合作评论列表
		$list = $this->task_model->comment_list($task_uuid,str_replace('-',' ',$order));
		$this->load->helper('myfunction');
		$result = array();
		if($list){
			foreach($list as $k=>$v){
				$result[$v['comment_uuid']]  = $v ;
			}
		}
		$comment = comment($result,'comment_uuid','parent','childs');
		$min = $num + 0;
		$max = $num + 6;
		$data['comment'] = array();
		foreach($comment as $key=>$value)
		{
			if($key >= $min && $key < $max)
			{
				$data['comment'][] = $value;
			}
		}
		$this->load->view('comment',$data);
	}

	//提交合作留言
	public function reply()
	{
		header("Content-type:text/html;charset=utf-8");
		$task_uuid = $this->input->post('task_uuid', TRUE);
		$parent = $this->input->post('parent', TRUE);
		$content = $this->input->post('content', TRUE);

		/* 验证表单 */
		$this->load->library('form_validation');
		$this->form_validation->set_rules('content','评论内容','required');

		if ($this->form_validation->run() == FALSE)
		{
			echo '评论内容不可为空';
		}
		else
		{
			$sql = "select uuid() uuid";
			$q = $this->db->query($sql)->row();
			$comment_uuid = $q->uuid;
			$data =array(
				'comment_uuid' => $comment_uuid, 
				'uuid' => UUID,
				'task_uuid' => $task_uuid,
				'parent' => $parent,
				'content' => $content,
				'up' => 0,
				'down' => 0,
				'create_time' => strtotime(date("Y-m-d H:i:s")),
				'create_ip' => $this->input->ip_address(),
				'status' => 1,
			);
			$this->task_model->get_comment($data);
			redirect(site_url('cooperation/show'.'/'.$task_uuid.'/order-review/create_time-desc'), 'refresh');
		}
	}

	// 合作评论 顶/踩
	public function num($comment_uuid,$act)
	{
		$num = $this->task_model->num($comment_uuid,$act);
		$num++;
		$this->task_model->update_num($comment_uuid,$num,$act);
		echo $num;
	}

	// 载入回复
	public function add_reply($comment_uuid,$task_uuid)
	{
		//表情
		$this->load->helper('smiley');
		$this->load->library('table');
		$image_array = get_clickable_smileys(static_url('public/smileys/'), 'commentss');
		$col_array = $this->table->make_columns($image_array, 20);  
		$smiley_table = $this->table->generate($col_array);

		echo form_open('cooperation/reply',array('id'=>'myform'));
		echo '<input type="hidden" name="task_uuid" value="'.$task_uuid.'" >';
		echo '<input type="hidden" name="parent" value="'.$comment_uuid.'" >';
		echo '<div class="newlist_art fuhui">';
		echo '<textarea cols="40" rows="3" name="content" id="commentss"></textarea>';
		echo '<dl style="position:relative;">';
		echo '<dt><span><a href="JavaScript:void(0);" onclick="smiley(id)" class="biao" id="smiley_'.$comment_uuid.'"></a> 表情</span> <span><input type="checkbox" name="weibo"> 同步到微博</span> <span><input type="checkbox" name="weibo"> 同步到QQ空间</span></dt>';
		echo '<dd><input style="cursor:pointer;" class="fabu" type="button" value="发布" name="fabu" onclick="check()"/></dd>';
		echo '<div class="smiley smiley_'.$comment_uuid.'" style="display:none;">'.$smiley_table.'</div>';
		echo '</dl>';
		echo '</div>';
		echo form_close();
	}

	//载入发送站内信页面
	public function letters($uuid,$nickname,$task_uuid,$type='user')
	{
		$data = array(
			'uuid'=>$uuid,
			'nickname'=>urldecode($nickname),
			'task_uuid'=>$task_uuid,
			'type'=>$type
		);
		$this->load->view('letters',$data);
	}

	//发送站内性
	public function send_letters()
	{
		$task_uuid = $this->input->post('task_uuid', TRUE);
		$type = $this->input->post('type', TRUE);
		$accept_uuid = $this->input->post('accept_uuid', TRUE);
		$title = $this->input->post('title', TRUE);
		$content = $this->input->post('content', TRUE);

		if($task_uuid !='' && $accept_uuid !='' && $title !='' && $content !='')
		{
			$sql = "select uuid() uuid";
			$q = $this->db->query($sql)->row();
			$chat_uuid = $q->uuid;
			$data = array(
				'title'=>$title,
				'chat_uuid'=>$chat_uuid,
				'send_uuid'=>UUID,
				'accept_uuid'=>$accept_uuid,
				'send_content'=>$content,
				'status'=>'1',
				'send_time'=>strtotime(date('Y-m-d H:i:s'))
			);
			if($type == 'user')
			{
				$data['sender'] = '0';
				$data['accepter'] = '0';
			}
			else if($type == 'admin')
			{
				$data['sender'] = '0';
				$data['accepter'] = '1';
			}
			$this->load->model('chat_model');
			$this->chat_model->add_chat($data);
			redirect(site_url('cooperation/show'.'/'.$task_uuid), 'refresh');
		}
		else
		{
			redirect(site_url('cooperation'), 'refresh');
		}
	}


	//载入提交合作意向页面
	public function intention($task_uuid,$uuid)
	{
		$data = array(
			'task_uuid'=>$task_uuid,
			'uuid'=>$uuid
		);
		$this->load->view('intention',$data);
	}

	//提交合作意向
	public function send_intention()
	{	
		$uuid = $this->input->post('uuid', TRUE);
		$task_uuid = $this->input->post('task_uuid', TRUE);
		$hidden = $this->input->post('hidden', TRUE);
		$content = $this->input->post('content', TRUE);

		if($uuid !='' && $task_uuid !='' && $content !='')
		{
			$sql = "select uuid() uuid";
			$q = $this->db->query($sql)->row();
			$intents_uuid = $q->uuid;
			$data = array(
				'intents_uuid'=>$intents_uuid,
				'task_uuid'=>$task_uuid,
				'uuid'=>$uuid,
				'create_uuid'=>UUID,
				'hidden'=>$hidden,
				'content'=>$content,
				'checked'=>'1',
				'create_time'=>strtotime(date('Y-m-d H:i:s'))
			);
			$this->task_model->add_intention($data);
			//查询任务意向数
			$num = $this->task_model->intents_num($task_uuid);
			//更新任务意向数
			$num++;
			$this->task_model->update_intents($task_uuid,$num);
			redirect(site_url('cooperation/show'.'/'.$task_uuid.'/order-intent/create_time-desc'), 'refresh');
		}
		else
		{
			redirect(site_url('cooperation'), 'refresh');
		}
	}

	//载入结束任务页面
	public function ending($task_uuid)
	{
		$data = array(
			'task_uuid'=>$task_uuid
		);
		//合作意向列表
		$data['lists'] = $this->task_model->intents_lists($task_uuid);
		//所在地
		$data['region'] = $this->task_model->region();
		//判断合作数量
		$data['partner_num'] = $this->task_model->partner_num($task_uuid);
		$this->load->view('ending',$data);
	}

	//结束任务
	public function task_ending()
	{
		$task_uuid = $this->input->post('task_uuid', TRUE);
		$create_uuid = $this->input->post('create_uuid', TRUE);
		if(is_array($create_uuid))
		{
			//修改合作意向状态
			$this->task_model->task_ending($create_uuid,$task_uuid);
			//修改合作状态
			$this->task_model->task_end($task_uuid);
			//增加合作对象的威望值
			//$this->task_model->prestige($create_uuid);
			redirect(site_url('cooperation/show'.'/'.$task_uuid), 'refresh');
		}
		else
		{
			header('Content-type:text/html;charset=utf-8');
			echo '未选择合作伙伴';
			redirect(site_url('cooperation/show'.'/'.$task_uuid), 'refresh');
		}
	}

	//生成验证码
	public function code()
	{
		$this->load->library("code",array(
			'width'=>80,
			'height'=>29,
			'fontSize'=>20,
			'font'=>'application/fonts/font.ttf'
		));
		$this->code->show();
	}

	//校验验证码
	public function check_code($code){
		@ob_clean() ;
	    @session_start() ;
		if(strtolower($_SESSION['code']) == strtolower($code) )
		{
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}

	//关注提交的意向
	public function attention($intents_uuid,$status)
	{
		$this->task_model->attention($intents_uuid,$status);
	}

	//点赞
	public function praise($task_uuid)
	{
		//判断此合作是否已点赞
		$num = $this->task_model->praise_num($task_uuid,UUID);
		if($num > 0)
		{
			echo 'false';
		}
		else
		{
			$sql = "select uuid() uuid";
			$q = $this->db->query($sql)->row();
			$task_upon_uuid = $q->uuid;
			$data = array(
				'task_upon_uuid'=>$task_upon_uuid,
				'task_uuid'=>$task_uuid,
				'uuid'=>UUID,
				'create_ip'=>$this->input->ip_address(),
				'create_time'=>strtotime(date('Y-m-d H:i:s'))
			);
			$this->task_model->praise($data);
			echo 'true';
		}
	}

	//跳转页面
	public function redirect()
	{
		@session_start();
		$_SESSION['redirect'] = str_replace('/redirect','/show',$_SERVER['REQUEST_URI']);
		redirect(site_url('user/login'), 'refresh');
	}

	////////////////////////////////////////////////////////////////////////////////////////jeff
	/**
	 * type_id, radio1, radio2
	 * platform_id
	 */
	protected function _get_product_id($type_id,$platform_id,$radio1,$radio2)
	{
		$data = $type_data = $platform_data = $where = $checkbox = array();

		if($type_id)
		{
			$strpos = strpos($type_id,'_');
			if(FALSE !== $strpos)
			{
				$checkbox = explode('_',$type_id);
			}
			else
			{
				$checkbox = (array)$type_id;
			}
		}
		$checkbox = $checkbox?$checkbox:'';
		if(!$platform_id && !$radio1 && !$radio2 && !$checkbox) return 'all';//没有传入条件时返回all

		$this->load->model('p2type_model');
		$this->load->model('p2platform_model');

		if($checkbox)
			$type_data = $this->p2type_model->get_id_array($checkbox);//在p2type中取符合条件的产品uuid

		if($radio1)
			$where['radio1'] = $radio1;
		if($radio2)
			$where['radio2'] = $radio2;
		if($where)
			$product_data = $this->product_model->get_id_array($where);//在product中取符合条件的产品uuid

		if($platform_id)
			$platform_data = $this->p2platform_model->get_id_array($platform_id);//在platform中取符合条件的产品uuid
		
		//根据传参把数据整合
		if($platform_id && ($radio1 || $radio2) && $checkbox)
		{//echo '1';
			$data = array_intersect(array_intersect($type_data,$product_data),$platform_data);
		}
		elseif($platform_id && ($radio1 || $radio2))
		{//echo '2';
			$data = array_intersect($product_data,$platform_data);
		}
		elseif($platform_id && $checkbox)
		{//echo '3';
			$data = array_intersect($type_data,$platform_data);
		}
		elseif(($radio1 || $radio2) && $checkbox)
		{//echo '4';
			$data = array_intersect($type_data,$product_data);
		}
		elseif($platform_id)
		{//echo '5';
			$data = $platform_data;
		}
		elseif($radio1 || $radio2)
		{//echo '6';
			$data = $product_data;
		}
		else
		{//echo '7';
			$data = $type_data;
		}
		return $data;
	}
	/**
	 * keywords
	 * product_uuid
	 */
	/* 暂时不用
	protected function _get_product_by_key($keywords,$product_uuid)
	{
		$where = '';
		if('all' != $product_uuid) 
			$where = 'product_uuid in ('.array2str($product_uuid).')';
		$keywords = rawurldecode($keywords);
		$where .= $where?" and product_name like '%".$keywords."%'":"product_name like '%".$keywords."%'";
		$this->load->model('product_model');
		return $this->product_model->get_id_array($where);//在product中取符合条件的产品uuid
	}
	*/
	/**
	 * target_id
	 * 分取 target_id
	 */
	protected function _get_target_id($target_id)
	{

		$data = $target_id1 = $target_id2 =array();
		if($target_id && FALSE !== strpos($target_id,'_'))
		{
			$target_id = explode('-',$target_id);
			$target_id1 = isset($target_id[0]) && $target_id[0]?intval($target_id[0]):0;
			$target_id2 = isset($target_id[1]) && $target_id[1]?intval($target_id[1]):0;	
		}
		elseif($target_id)
		{
			$target_id1 = intval($target_id);
		}		
		if(!$target_id1 && !$target_id2) return 'all';//没有传入条件时返回all

		
		if($target_id2)
		{
			$data = (array)$target_id2;
		}
		elseif($target_id1)
		{
			//$where = "parent = '".$target_id1."' OR id = '".$target_id1."'";
			//入口已做选择最低层id
			$where = "parent = '".$target_id1."'";
			$this->load->model('target_model');
			$data = $this->target_model->get_id_array($where);
		}				
		return $data;
	}

	/**
	 * target_arr
	 * 对target集按parent处理
	 */
	protected function _get_targets($target_arr)
	{
		$data = $data['data'] = $data['name'] =array();
		if(is_array($target_arr) && $target_arr)
		{
			foreach($target_arr as $k=>$v)
			{
				$data['name'][$v->id] = $v->name;
				$data['data'][$v->parent][$v->id] = $v;
			}
		}
		return $data;
	}

	/**
	 * targets step绑定target_id集合
	 * step_id 当前step_id
	 * 返回符合条件的target_id数组集合
	 */
	protected function _target_in($targets='',$step_id='')
	{
		$data = array();
		if(is_array($targets) && $targets)
		{
			if($step_id && $targets[$step_id])
			{
				$strpos = strpos($targets[$step_id],',');
				if(FALSE !== $strpos)
				{
					$explode = explode(',',$targets[$step_id]);
					foreach($explode as $kv)
					{
						$data[] = $kv;
					}
				}
				else
				{
					$data[] = $targets[$step_id];
				}
			}
			else
			{
				foreach($targets as $k=>$v)
				{
					$strpos = strpos($v,',');
					if(FALSE !== $strpos)
					{
						$explode = explode(',',$v);
						foreach($explode as $kv)
						{
							$data[] = $kv;
						}
					}
					else
					{
						$data[] = $v;
					}
				}			
			}
		}
		return $data;
	}

	/**
	 * targets step绑定target_id集合
	 * target_id 当前target_id
	 * 返回符合条件的step_id数组集合
	 */
	protected function _step_in($targets='',$target_id='')
	{
		$data = array();
		$strpos = strpos($target_id,'-');
		if(FALSE !== $strpos)
		{
			$explode = explode('-',$target_id);
			$segment1 = intval($explode[0]);
		}
		else
		{
			$segment1 = intval($target_id);
		}

		foreach($targets as $k=>$v)
		{
			$explode = explode(',',$v);
			if(!in_array($segment1,$explode))
			{
				$data[] = $k;
			}
		}
		
		return $data;
	}
	/**
	 * _order_by
	 * anchors为安全排序字段范围
	 * 处理排序
	 */
	protected function _order_by($orderby='',$anchors=array())
	{
		if(!$orderby) return FALSE;
		$orderby = str_replace('hot','recommend',str_replace('new','open_time',$orderby));//对应数据库字段
		return url_orderby($orderby,$anchors);
	}

}
