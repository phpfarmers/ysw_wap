<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Information extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('information_model');
		$this->load->model('artcategory_model');
		$this->load->model('article_model');
		$this->load->model('tags_model');
		$this->lang->load('information');
	}

	public function index()
	{
		$this->output->cache($this->config->config['cache_time']/60);
		$this->_list();
	}

	/**
	 *
	 **/
	protected function _list()
	{
		$this->load->helper('array');
		$this->load->helper('text');
		//组装url
		$segment = array('category','tags','keywords','orderby','page_size');//定义取值范围
		$arr_segment = 'index' === $this->uri->segment(2)?$this->uri->uri_to_assoc(3,$segment):$this->uri->uri_to_assoc(2,$segment);//获取分段		
		if($kw = $this->input->post('keywords',TRUE))
		{
			$arr_segment['keywords'] = $kw;
		}
		$anchor_link = site_url('information/index').'/'.$this->uri->assoc_to_uri(elements($segment,$arr_segment,0));//url组装结果
		$data['segment'] = elements($segment,$arr_segment);
		//设置不同筛选链接
		$data['category_link'] = site_url('information/index').'/'.$this->uri->assoc_to_uri(elements(array('tags','keywords','orderby','page_size'),$arr_segment,0));
		$data['tags_link'] = site_url('information/index').'/'.$this->uri->assoc_to_uri(elements(array('category','keywords','orderby','page_size'),$arr_segment,0));
		$data['keywords_link'] = site_url('information/index').'/'.$this->uri->assoc_to_uri(elements(array('category','tags','orderby','page_size'),$arr_segment,0));
		//$data['orderby_link'] =	anchor_url($data['orderby_link'], $anchor = array('hot','new','intents','amount'),$data['segment']['orderby']);//组装url
		$data['page_link'] = site_url('information/index').'/'.$this->uri->assoc_to_uri(elements(array('category','tags','keywords','orderby','page_size'),$arr_segment,0));
		
		//资讯列表(判断条件)
		$where = $keywords = $data['keywords'] = $data['category'] = $data['tags'] = '';
		$where = 'status = 1 and checked = 1';

		$data['keywords'] = $keywords = isset($arr_segment['keywords'])?$arr_segment['keywords']:'';
		$category = isset($arr_segment['category'])?intval($arr_segment['category']):0;
		$tags = isset($arr_segment['tags'])?intval($arr_segment['tags']):0;
		if($keywords)
			$where .= $where?" and title like '%".$keywords."%' or summary like '%".$keywords."%'":"title like '%".$keywords."%' or summary like '%".$keywords."%'";
		if($category)
			$where .= $where?" and category = '".$category."'":"category = '".$category."'";
		if($tags)
			$where = $where?$where.' and find_in_set('.$tags.',tags)':'find_in_set('.$tags.',tags)';
		//资讯分类
		$data['category'] = $this->artcategory_model->lists('','order desc');

		$this->load->library('pagination');
		$config['base_url'] = $data['page_link'].'/page_size/';
		$pagesize = isset($arr_segment['page_size'])?intval($arr_segment['page_size']):0;
		$config['my_segment'] = $pagesize;
		$config['per_page'] = $this->pagination->per_page;
		$data['data'] = $this->article_model->lists($pagesize, $config['per_page'], $where, 'recommend desc,order asc,open_time desc','article_uuid,title,category,tags,pic,author,summary,create_time');
		$config['total_rows'] = $data['data']['total_rows'];
		$this->pagination->initialize($config);
		$data['tags_all'] = array();
		//资讯标签
		if($data['data']['tags'])
			$data['tags_all'] = $this->tags_model->get_name('id',$data['data']['tags'],'',$order_by='order asc');

		$data['web_title'] = '资讯-游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$data['headerh2'] = lang('Article');

		$this->load->view('include/header',$data);
		$this->load->view('information',$data);
		$this->load->view('include/footer',$data);
	}

	public function show()
	{
		$this->_view();
	}
	
	/**
	 *
	 **/
	protected function _view()
	{
		$article_uuid = $this->uri->segment(3);
		if(!$article_uuid || strlen(trim($article_uuid)) !== 36)
			redirect(site_url('information'));	
		//资讯详细内容
		$data['article_info'] = $this->article_model->fetch_id($article_uuid);
		if(!$data['article_info'])
			redirect(site_url('information'));

		$tags = $data['article_info']->tags;
		$category = $data['article_info']->category;

		//资讯标签
		$data['tags_all'] = array();
		if($tags)
		{
			if(FALSE !== strpos($tags,','))
			{
				$tags = explode(',',$tags);
			}
			else
			{
				$tags = (array)intval($tags);
			}
			$data['tags_all'] = $this->tags_model->get_name('id',$tags);
		}
		
		$data['web_title'] = $data['article_info']->title.' - 资讯 - 游商网';
		$data['web_keywords'] = '创业,游商网,融资网站,游戏品台';
		$data['web_description'] = '游商网,第一个做融资网络游戏的平台！';
		$data['headerh2'] = lang('Article');

		$this->load->view('include/header',$data);
		$this->load->view('information_show',$data);
		$this->load->view('include/footer',$data);
	}

	//加载留言
	public function comment($article_uuid,$act,$num)
	{
		//表情
		$this->load->helper('smiley');
		$this->load->library('table');
		$image_array = get_clickable_smileys(static_url('public/smileys/'), 'comments');
		$col_array = $this->table->make_columns($image_array, 20);  
		$data['smiley_table'] = $this->table->generate($col_array);

		//文章评论列表
		$list = $this->information_model->comment_list($article_uuid,$act);
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

	// 文章评论 顶/踩
	public function num($comment_uuid,$act)
	{
		$num = $this->information_model->num($comment_uuid,$act);
		$num++;
		$this->information_model->update_num($comment_uuid,$num,$act);
		echo $num;
	}

	// 载入回复
	public function add_reply($comment_uuid,$article_uuid)
	{
		//表情
		$this->load->helper('smiley');
		$this->load->library('table');
		$image_array = get_clickable_smileys(static_url('public/smileys/'), 'commentss');
		$col_array = $this->table->make_columns($image_array, 20);  
		$smiley_table = $this->table->generate($col_array);

		echo form_open('information/reply');
		echo '<input type="hidden" name="article_uuid" value="'.$article_uuid.'" >';
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

	//提交文章留言
	public function reply()
	{
		header("Content-type:text/html;charset=utf-8");
		$article_uuid = $this->input->post('article_uuid', TRUE);
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
				'article_uuid' => $article_uuid,
				'parent' => $parent,
				'content' => $content,
				'up' => 0,
				'down' => 0,
				'create_time' => strtotime(date("Y-m-d H:i:s")),
				'create_ip' => $this->input->ip_address(),
				'status' => 1,
			);
			$this->information_model->get_comment($data);
			redirect(site_url('information/show'.'/'.$article_uuid), 'refresh'); //返回文章详细页
		}
	}

	//载入纠错内容
	public function load($article_uuid)
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
		'.form_open('information/correction',array('id' =>'myform')).'
			<ul class="dia_start">
				<input type="hidden" name="article_uuid" value="'.$article_uuid.'">
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
		$article_uuid = $this->input->post('article_uuid', TRUE);
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
			$article_error_uuid = $q->uuid;
			$data =array(
				'article_error_uuid' => $article_error_uuid,
				'article_uuid' => $article_uuid,
				'uuid' => UUID,
				'content' => $error.'修改为'.$correct,
				'mobile' => $mobile,
				'qq' => $qq,
				'email' => $email,
				'create_time' => strtotime(date("Y-m-d H:i:s")),
				'status' => '0'
			);
			$this->information_model->correction($data);
			redirect(site_url('information/show'.'/'.$article_uuid), 'refresh');
		}
	}

}
