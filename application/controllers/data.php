<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->database();
		$this->load->model('product_model');
		$this->load->model('producttype_model');
		$this->load->model('target_model');
		$this->load->model('task_model');
		$this->load->model('company_model');
		$this->load->helper('text');
		$this->load->model('data_model');
		$this->load->library('product');
		$this->load->library('task');
	}

	public function index($category = 0,$page = 1)
	{
		$this->output->cache($this->config->config['cache_time']/60);
		$this->_list($category,$page);
	}

	//资料列表页
	public function _list($category,$page)
	{
		$data['web_title'] = '资料-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		//获取当前地址(设置连接初始值)
		if($this->uri->segment('2')!='')
		{
			$data['url'] = current_url();
		}
		else
		{
			$data['url'] = current_url().'/index';
		}

		//获取当前url的属性
		$data['select'] = $this->uri->uri_to_assoc();

		//判断选择那些属性分类
		$data['sort'] = array();
		foreach($data['select'] as $key=>$value)
		{
			$data['sort'][] = $key;
		}

		//设置page默认值
		if(!in_array('page',$data['sort']))
		{
			$data['select']['page'] = '1';
		}
		else
		{
			if($data['select']['page']=='')
			{
				$data['select']['page'] = '1';
			}
		}

		//资料列表(判断条件)
		$where = array();
		$order = '';
		$keywords = $data['keywords'] = '';
		$data['category'] = '';
		foreach($data['select'] as $key=>$value)
		{
			if($key =='order')
			{
				$order = str_replace('-',' ',$value);
			}
			else if($key =='keywords')
			{
				$data['keywords'] = $keywords = rawurldecode($value);				
			}
			else if($key =='page')
			{
				$page = $value;				
			}
			else
			{
				//category
				if(in_array('category',$data['sort']))
				{
					$data['category'] = $where['category'] = $value;
				}
			}
		}

		//资料分类
		$data['data_category'] = $this->data_model->data_category();

		if(!empty($data['category']))
		{
			$category = array();
			foreach($data['data_category'] as $row)
			{
				$category[] =  $row->id;
			}
			if(!in_array($data['category'],$category))
			{
				redirect(site_url('data'), 'refresh');
			}
		}



		//资讯分页
		$this->load->library('pagination');
		$config['base_url'] = str_replace('/page/'.$page,'',$data['url']).'/page/';
		$entrusted = '';
		$task_target_id = '';
	    $config['total_rows'] = $this->data_model->total_data($where,$order,$keywords);
	    $config['per_page']   = 10;
	    $config['num_links']  = 3;
		if(in_array('page',$data['sort']))
		{
			$config['uri_segment'] = count($data['sort'])*2 + 2;
		}
		else
		{
			$config['uri_segment'] = (count($data['sort'])+1)*2 + 2;
		}
		//$config['uri_segment'] = count($data['sort'])*2 + 2;
	    $config['use_page_numbers'] = TRUE;

	    $config['first_link'] = '首页';
	    $config['last_link']  = '最后';
	    $config['next_link']  = '下一页';
	    $config['prev_link']  = '上一页';

		$config['num_tag_open']   = '';
	    $config['num_tag_close']  = '';

	    $config['cur_tag_open']   = '<a class="page_currer">';
	    $config['cur_tag_close']  = '</a>';

	    $config['prev_tag_open']  = '';
	    $config['prev_tag_close'] = '';

	    $config['next_tag_open'] = '';
	    $config['next_tag_close'] = '';

	    $config['last_tag_open'] = '';
	    $config['last_tag_close'] = '';

	    $config['first_tag_open'] = '';
	    $config['first_tag_close'] = '';

		$config['full_tag_open'] = '<div id="paging">';
		$config['full_tag_close'] = '</div>';

    	$this->pagination->initialize($config);

		//资料列表
		$data['data_list'] = $this->data_model->data_lists($where,$order,$keywords,$config['per_page'],$page);

		//新进产品
		$data['new'] = $this->product_model->new_product();
		$data['type'] = $this->product_model->product_type();

		//热门合作
		$data['hot'] = $this->task_model->hot_task();

		$this->load->view('include/header_12',$data);
		$this->load->view('data',$data);
		$this->load->view('include/footer_12',$data);
	}

	//资料详细页
	public function show($data_uuid = '',$act = 'desc')
	{
		if(empty($data_uuid))
		{
			show_404();
		}
		else
		{
			$this->_show($data_uuid,$act);
		}
	}

	public function _show($data_uuid,$act)
	{
		if($act != 'asc' && $act != 'desc')
		{
			redirect(site_url('prompt/error'), 'refresh'); //跳转文件上传页面
		}
		$data['act'] = $act;

		//资料详细信息
		$data['info'] = $this->data_model->data_info($data_uuid);

		if(!$data['info'])
		{
			redirect(site_url('prompt/error'), 'refresh'); //跳转文件上传页面
		}
		if($data['info']->creater == '0')
		{
			if($data['info']->creater_uuid !='')
			{
				$data['info']->author = $this->data_model->author($data['info']->creater_uuid);
			}
			else
			{
				$data['info']->author = '';
			}
		}

		//判断是否为当前会员或已审核的资料
		if($data['info']->creater_uuid != UUID)
		{
			if($data['info']->status != '1' || $data['info']->checked != '1')
			{
				redirect(site_url('prompt/error'), 'refresh'); //跳转文件上传页面
			}
		}

		//浏览量
		$num = $this->data_model->num($data_uuid,'view');
		$num++;
		$this->data_model->update_num($data_uuid,'view',$num);

		//资料分类
		$data['data_category'] = $this->data_model->data_category();

		//判断是否已收藏
		if(UUID)
		{
			$data['collect_num'] = $this->data_model->collect_num($data_uuid,UUID);
		}

		//上一篇，下一篇
		$data['Previous'] = $this->data_model->more_info($data['info']->category,$data['info']->id,'Previous');
		$data['Next'] = $this->data_model->more_info($data['info']->category,$data['info']->id,'Next');

		//相关资料
		$category = $data['info']->category;
		$data['linked_data'] = $this->data_model->linked_data($category,$data_uuid);
		//print_r($data['linked_data']);exit;

		//表情
		$this->load->helper('smiley');
		$this->load->library('table');
		$image_array = get_clickable_smileys(static_url('public/smileys/'), 'comments');
		$col_array = $this->table->make_columns($image_array, 20);  
		$data['smiley_table'] = $this->table->generate($col_array);

		//文章评论列表
		$list = $this->data_model->comment_list($data_uuid,$act);
		$this->load->helper('myfunction');
		$result = array();
		if($list){
			foreach($list as $k=>$v){
				$result[$v['comment_uuid']]  = $v ;
			}
		}
		$comment = comment($result,'comment_uuid','parent','childs');
		$data['comment_n'] = count($comment);
		$data['comment'] = array();
		foreach($comment as $key=>$value)
		{
			if($key < 6)
			{
				$data['comment'][] = $value;
			}
		}

		//评论参与人数
		$data['num_p'] = $this->data_model->comment_join_num($data_uuid,'uuid');

		//评论数
		$data['num_c'] = $this->data_model->comment_join_num($data_uuid,'');

		//新进产品
		$data['new'] = $this->product_model->new_product();
		$data['type'] = $this->product_model->product_type();

		//热门合作
		$data['hot'] = $this->task_model->hot_task();

		$data['web_title'] = $data['info']->title.' - 资料 - 游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		$this->load->view('include/header_12',$data);
		$this->load->view('data_show',$data);
		$this->load->view('include/footer_12',$data);
	}

	//加载留言
	public function comment($data_uuid,$act,$num)
	{
		//表情
		$this->load->helper('smiley');
		$this->load->library('table');
		$image_array = get_clickable_smileys(static_url('public/smileys/'), 'comments');
		$col_array = $this->table->make_columns($image_array, 20);  
		$data['smiley_table'] = $this->table->generate($col_array);

		//文章评论列表
		$list = $this->data_model->comment_list($data_uuid,$act);
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

	//资料下载
	public function down($data_uuid)
	{
		//获取下载资料信息
		$data_info = $this->data_model->down_data_info($data_uuid);

		//获取会员总积分
		$this->load->model('user_model');
		$total_intergral = $this->user_model->total_intergral(UUID);

		if($total_intergral >= $data_info->intergral)
		{
			//读取资料下载次数
			$num = $this->data_model->num($data_uuid,'hits');
			$num++;

			//更新资料下载次数
			$this->data_model->update_num($data_uuid,'hits',$num);
			
			//更新会员积分记录表
			$sql = "select uuid() uuid";
			$q = $this->db->query($sql)->row();
			$intergral_uuid = $q->uuid;

			$this->load->model('intergral_model');
			$data = array(
				'intergral_uuid' => $intergral_uuid,
				'uuid' => UUID,
				'intergral' => '-'.$data_info->intergral,
				'title' => '下载资料（"'.$data_info->title.'"）扣除'.$data_info->intergral.'积分',
				'create_time' => strtotime(date('Y-m-d H:i:s')),
				'create_ip' => $this->input->ip_address(),
				'status' => '1'
				);
			$this->intergral_model->integral($data);

			//更新总积分
			$intergral = $total_intergral - $data_info->intergral;
			$this->intergral_model->update_total(UUID,$intergral);

			//输出页面js更新数量
			echo $num;
		}
	}

	//xiazai
	public function download($data_uuid)
	{
		//生成下载文件
		$this->load->helper('download');
		$download = $this->data_model->fetch_id($data_uuid);
		if(!$download)
			show_404();
		if($download)
		{
			//可根据条件返回不同值
			$file = static_url('uploadfile/file/'.$download->download);
			$data = file_get_contents($file);
			$name = $download->download;
			force_download($name, $data);
		}
		else
		{
			show_404();
		}
	}

	//点赞
	public function upon($data_uuid,$upon_num)
	{
		//判断是否已点赞
		$num = $this->data_model->upon_num($data_uuid,UUID);
		if($num > 0)
		{
			echo 'false';
		}
		else
		{
			$sql = "select uuid() uuid";
			$q = $this->db->query($sql)->row();
			$upon_uuid = $q->uuid;
			$data = array(
				'data_upon_uuid'=>$upon_uuid,
				'data_uuid'=>$data_uuid,
				'uuid'=>UUID,
				'create_time'=>strtotime(date("Y-m-d H:i:s")),
				'create_ip'=>$this->input->ip_address()
			);
			$this->data_model->insert_upon($data);
			$this->data_model->update_upon_num($data_uuid,$upon_num);
			echo 'true';
		}
	}

	//收藏
	public function collect($data_uuid,$collect_num)
	{
		//判断是否已收藏
		$num = $this->data_model->collect_num($data_uuid,UUID);
		if($num > 0)
		{
			echo 'false';
		}
		else
		{
			$sql = "select uuid() uuid";
			$q = $this->db->query($sql)->row();
			$collection_uuid = $q->uuid;
			$data = array(
				'data_collection_uuid'=>$collection_uuid,
				'data_uuid'=>$data_uuid,
				'uuid'=>UUID,
				'create_time'=>strtotime(date("Y-m-d H:i:s"))
			);
			$this->data_model->insert_collect($data);
			$this->data_model->update_collect_num($data_uuid,$collect_num);
			echo 'true';
		}
	}

	//提交资料评论
	public function reply()
	{
		header("Content-type:text/html;charset=utf-8");
		$data_uuid = $this->input->post('data_uuid', TRUE);
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
				'data_uuid' => $data_uuid,
				'parent' => $parent,
				'content' => $content,
				'up' => 0,
				'down' => 0,
				'create_time' => strtotime(date("Y-m-d H:i:s")),
				'create_ip' => $this->input->ip_address(),
				'status' => 1,
			);
			$this->data_model->get_comment($data);
			redirect(site_url('data/show'.'/'.$data_uuid), 'refresh'); //返回文章详细页
		}
	}

	// 文章评论 顶/踩
	public function num_c($comment_uuid,$act)
	{
		$num = $this->data_model->num_c($comment_uuid,$act);
		$num++;
		$this->data_model->update_num_c($comment_uuid,$num,$act);
		echo $num;
	}

	// 载入回复
	public function add_reply($comment_uuid,$data_uuid)
	{
		//表情
		$this->load->helper('smiley');
		$this->load->library('table');
		$image_array = get_clickable_smileys(static_url('public/smileys/'), 'commentss');
		$col_array = $this->table->make_columns($image_array, 20);  
		$smiley_table = $this->table->generate($col_array);

		echo form_open('data/reply');
		echo '<input type="hidden" name="data_uuid" value="'.$data_uuid.'" >';
		echo '<input type="hidden" name="parent" value="'.$comment_uuid.'" >';
		echo '<div class="newlist_art fuhui">';
		echo '<textarea cols="40" rows="3" name="content" id="commentss"></textarea>';
		echo '<dl style="position:relative;">';
		echo '<dt><span><a href="JavaScript:void(0);" onclick="smiley(id)" class="biao" id="smiley_'.$comment_uuid.'"></a> 表情</span> <span><input type="checkbox" name="weibo"> 同步到微博</span> <span><input type="checkbox" name="weibo"> 同步到QQ空间</span></dt>';
		echo '<dd><input style="cursor:pointer;" type="submit" value="发布" name="fabu" class="fabu" /></dd>';
		echo '<div class="smiley smiley_'.$comment_uuid.'" style="display:none;">'.$smiley_table.'</div>';
		echo '</dl>';
		echo '</div>';
		echo form_close();
	}

	//添加资料
	public function add_data()
	{
		if (!$this->is_login())
		{
			@session_start();
			$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
			redirect(site_url('user/login'), 'refresh');
		}
		$data['web_title'] = '发布资料-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		//敏感词
		$file = APPPATH.'config/keyword.txt';
		$keyword = file_get_contents($file);
		$keyword = explode("\n",$keyword);
		$keyword = implode("|",$keyword);

		$keyword = str_replace("(","\(",$keyword);
		$keyword = str_replace(")","\)",$keyword);
		$keyword = str_replace("*","\*",$keyword);
		$keyword = str_replace("/","\/",$keyword);
		$data['key'] = $keyword;

		//资料分类
		$data['data_category'] = $this->data_model->data_category();

		//新进产品
		$data['new'] = $this->product_model->new_product();
		$data['type'] = $this->product_model->product_type();

		//热门合作
		$data['hot'] = $this->task_model->hot_task();

		$this->load->view('include/header_12',$data);
		$this->load->view('data_add',$data);
		$this->load->view('include/footer_12',$data);
	}

	//资料上传
	public function add_upload()
	{
		$config['upload_path'] = RESPATH.'/uploadfile/file/';
		$config['allowed_types'] = 'gif|jpg|jpeg|bmp|png|doc|txt|docx|ppt|pptx|xls|xlsx|rar|zip|pdf';
		$config['max_size'] = '20480'; //2M
		$config['file_name'] = date('YmdHis').rand(0,1000); //上传后文件重命名
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			//echo '文件上传失败';
			$download = '';
		} 
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$download = $data['upload_data']['file_name'];
		}
		$title = $this->input->post('title', TRUE);
		$category = $this->input->post('category', TRUE);
		$intergral = $this->input->post('intergral', TRUE);
		$content = $this->input->post('content', TRUE);
		if($this->input->post('feedback', TRUE))
		{
			$feedback = implode(',', $this->input->post('feedback', TRUE));
		}
		else
		{
			$feedback = $this->input->post('feedback', TRUE);
		}

		// 验证表单 
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title','资料标题','trim|required');
		//$this->form_validation->set_rules('download','上传文件','required');
		if ($this->form_validation->run() == FALSE)
		{
			redirect(site_url('prompt/data'), 'refresh'); //跳转文件上传页面
		}
		else
		{
			//当前表中编号最大值
			$this->load->model('sn_model');
			$sn = $this->sn_model->sn('data');

			//生成data_uuid
			$sql = "select uuid() uuid";
			$q = $this->db->query($sql)->row();
			$data_uuid = $q->uuid;

			$data = array(
				'data_uuid'=>$data_uuid,
				'title'=>$title,
				'download'=>$download,
				'category'=>$category,
				'content'=>$content,
				'intergral'=>$intergral,
				'feedback'=>$feedback,
				'status'=>1,
				'checked'=>0,
				'creater'=>0,
				'creater_uuid'=>UUID,
				'create_time' => strtotime(date("Y-m-d H:i:s")),
				'create_ip' => $this->input->ip_address(),
				'sn' => $sn
			);
			$this->data_model->add_data($data);

			$data['web_title'] = '资料发布-游商网';
			$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
			$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

			$data['title'] = '资料发布已成功';
			$data['img'] = 'true.png';
			$data['message'] = '资料发布已成功，等待管理员审核中...';
			$data['where_1'] = '资料';
			$data['url_1'] = site_url('data');
			$data['target_1']  = '';
			$data['where_2'] = '我上传的资料';
			$data['url_2'] = site_url('user/contribute');
			$data['target_2']  = '';
			$this->load->view('include/header_12',$data);
			$this->load->view('include/message',$data);
			$this->load->view('include/footer_12',$data);
		}
	}

	//编辑资料
	public function edit_data($data_uuid='')
	{
		if (!$this->is_login())
		{
			redirect(site_url('prompt'), 'refresh');
		}
		$data['web_title'] = '编辑资料-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

		//敏感词
		$file = APPPATH.'config/keyword.txt';
		$keyword = file_get_contents($file);
		$keyword = explode("\n",$keyword);
		$keyword = implode("|",$keyword);

		$keyword = str_replace("(","\(",$keyword);
		$keyword = str_replace(")","\)",$keyword);
		$keyword = str_replace("*","\*",$keyword);
		$keyword = str_replace("/","\/",$keyword);
		$data['key'] = $keyword;

		//资料分类
		$data['data_category'] = $this->data_model->data_category();

		//资料详细信息
		$data['data_detail'] = $this->data_model->data_detail(UUID,$data_uuid);

		//新进产品
		$data['new'] = $this->product_model->new_product();
		$data['type'] = $this->product_model->product_type();

		//热门合作
		$data['hot'] = $this->task_model->hot_task();

		$this->load->view('include/header_12',$data);
		$this->load->view('data_edit',$data);
		$this->load->view('include/footer_12',$data);
	}

	//资料修改
	public function edit_upload($data_uuid='')
	{   //var_dump($_FILES['userfile']);exit;
		if($_FILES['userfile']['size']>0)
		{
			$config['upload_path'] = RESPATH.'/uploadfile/file/';
			$config['allowed_types'] = 'gif|jpg|jpeg|bmp|png|doc|txt|docx|ppt|pptx|xls|xlsx|rar|zip|pdf';
			$config['max_size'] = '20480'; //2M
			$config['file_name'] = date('YmdHis').rand(0,1000); //上传后文件重命名
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('userfile'))
			{
				$error = array('error' => $this->upload->display_errors());
				echo $error['error'];
				$download = '';
				exit;
			} 
			else
			{
				$data = array('upload_data' => $this->upload->data());
				$download = $data['upload_data']['file_name'];
			}
		}
		else
		{
			$download = '';
		}		
		$title = $this->input->post('title', TRUE);
		$category = $this->input->post('category', TRUE);
		$intergral = $this->input->post('intergral', TRUE);
		$content = $this->input->post('content', TRUE);
		if($this->input->post('feedback', TRUE))
		{
			$feedback = implode(',', $this->input->post('feedback', TRUE));
		}
		else
		{
			$feedback = $this->input->post('feedback', TRUE);
		}

		// 验证表单 
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title','资料标题','trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			echo '资料填写不完整';
		}
		else
		{
			if(!empty($download))
			{
				$data = array(
					'title'=>$title,
					'download'=>$download,
					'category'=>$category,
					'content'=>$content,
					'intergral'=>$intergral,
					'feedback'=>$feedback,
					'status'=>1,
					'checked'=>0
				);
			}
			else
			{
				$data = array(
					'title'=>$title,
					'category'=>$category,
					'content'=>$content,
					'intergral'=>$intergral,
					'feedback'=>$feedback,
					'status'=>1,
					'checked'=>0
				);
			}
			$this->data_model->update_data($data,$data_uuid,UUID);

			$data['web_title'] = '编辑资料-游商网';
			$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
			$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';

			$data['title'] = '编辑资料布已成功';
			$data['img'] = 'true.png';
			$data['message'] = '编辑资料已成功，等待管理员审核中...';
			$data['where_1'] = '资料';
			$data['url_1'] = site_url('data');
			$data['target_1']  = '';
			$data['where_2'] = '我上传的资料';
			$data['url_2'] = site_url('user/contribute');
			$data['target_2']  = '';
			$this->load->view('include/header_12',$data);
			$this->load->view('include/message',$data);
			$this->load->view('include/footer_12',$data);
		}
	}

	//载入纠错内容
	public function load($data_uuid)
	{
		//联系方式
		if(UUID)
		{
			$this->load->model('user_model');
			$correction = $this->user_model->contact(UUID);
		}
		else
		{
			$correction = array(
				'mobile' => '',
				'qq' => '',
				'email' => ''
				);
		}
		echo '
		<dl>
			<dt>我要纠错</dt>
			<dd><a href="JavaScript:void(0);" onclick="closeBg();"><img src="'.static_url('public/images/lace/cuo.gif').'"></a></dd>
		</dl>
		'.form_open('data/correction',array('id' =>'myform')).'
			<ul class="dia_start">
				<input type="hidden" name="data_uuid" value="'.$data_uuid.'">
				<li onclick="error()"><strong>错误地方： </strong> <span><textarea rows="10" cols="30" name="error" id="error" value=""></textarea></span></li>
				<li onclick="error()"><strong>修改为： </strong> <span><textarea rows="10" cols="30" name="correct" id="correct" value=""></textarea></span></li>
				<li onclick="error()"><strong>手机： </strong> <span><input type="text" name="mobile"  class="biao_y" id="mobile" value="'.$correction['mobile'].'"/> <strong>QQ： </strong> <input type="text" name="qq"  class="biao_y" id="qq" value="'.$correction['qq'].'"/></span></li>	
				<li onclick="error()"><strong>邮箱：</strong> <span><input type="text" name="email"  class="biao_s" id="email" value="'.$correction['email'].'"/></span></li>
				<div class="dia_start_a"></div>
				<li class="cooplist_pro_a1"><a id="submit" onclick="check()" href="javascript:void(0);" style="color:#FFF;">发送</a> </li>
			</ul>
		'.form_close();
	}

	//提交纠错内容
	public function correction()
	{
		header("Content-type:text/html;charset=utf-8");
		$data_uuid = $this->input->post('data_uuid', TRUE);
		$error = $this->input->post('error', TRUE);
		$correct = $this->input->post('correct', TRUE);
		$mobile = $this->input->post('mobile', TRUE);
		$qq = $this->input->post('qq', TRUE);
		$email = $this->input->post('email', TRUE);

		/* 验证表单 */
		$this->load->library('form_validation');
		$this->form_validation->set_rules('error','错误地方','required');
		$this->form_validation->set_rules('correct','修改内容','required');

		if ($this->form_validation->run() == FALSE)
		{
			echo '信息填写有误';
		}
		else
		{
			$sql = "select uuid() uuid";
			$q = $this->db->query($sql)->row();
			$data_error_uuid = $q->uuid;
			$data =array(
				'data_error_uuid' => $data_error_uuid,
				'data_uuid' => $data_uuid,
				'uuid' => UUID,
				'content' => $error.'修改为'.$correct,
				'mobile' => $mobile,
				'qq' => $qq,
				'email' => $email,
				'create_time' => strtotime(date("Y-m-d H:i:s")),
				'status' => '0'
			);
			$this->data_model->correction($data);
			redirect(site_url('data/show'.'/'.$data_uuid), 'refresh');
		}
	}

}
