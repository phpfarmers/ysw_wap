<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Information_model extends  CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//资讯分类
	public function article_category()
	{
		$this->db->select('id,name');
		$this->db->from('ysw_article_category');
		$this->db->where('status','1');
		$this->db->limit('7');
		$this->db->order_by('order desc');
		$query = $this->db->get();
		return $query->result();
	}

	// 资讯列表
	/*public function information_list($tags,$category,$num,$page,$keywords='')
	{
		$tags = base64_decode(rawurldecode($tags));
		$this->db->select('ysw_article.article_uuid,ysw_article.title,ysw_article.category,ysw_article.tags,ysw_article.author,ysw_article.summary,ysw_article.create_time,ysw_article.order,ysw_article_category.name');
		$this->db->from('ysw_article');
		$this->db->join('ysw_article_category','ysw_article.category = ysw_article_category.id','left');
		if($tags != '')
		{
			$this->db->where("concat(',',ysw_article.tags,',') like '%,".$tags.",%'");
		}
		if($category != 0)
		{
			$this->db->where("concat(',',ysw_article.category,',') like '%,".$category.",%'");
		}
		if($keywords)
			$this->db->where("(ysw_article.title like '%".$keywords."%' or ysw_article.summary like '%".$keywords."%')");
		$this->db->where('ysw_article.status','1');
		$this->db->order_by('ysw_article.order asc , ysw_article.create_time desc');
		$this->db->limit($num,$num*($page-1));
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}*/

	//资讯总数
	/*public function total_rows($tags,$category,$keywords='')
	{
		$tags = base64_decode(rawurldecode($tags));
		$this->db->from('ysw_article');
		if($tags != '')
		{
			$this->db->where("concat(',',ysw_article.tags,',') like '%,".$tags.",%'");
		}
		if($category != 0)
		{
			$this->db->where("concat(',',category,',') like '%,".$category.",%'");
		}
		if($keywords)
			$this->db->where("(title like '%".$keywords."%' or summary like '%".$keywords."%')");
		$this->db->where('status','1');
		$query = $this->db->get();
		return $query->num_rows();
	}*/

	//资讯列表（sunny 2015/1/29）
	public function article_list($where,$order,$keywords,$num,$page)
	{
		$this->db->select('ysw_article.article_uuid,ysw_article.title,ysw_article.category,ysw_article.tags,ysw_article.author,ysw_article.summary,ysw_article.open_time,ysw_article.order,ysw_article_category.name');
		$this->db->from('ysw_article');
		$this->db->join('ysw_article_category','ysw_article.category = ysw_article_category.id','left');
		if(is_array($where))
		{
			foreach($where as $key=>$value)
			{
				if($key == 'category')
				{
					$this->db->where("concat(',',category,',') like '%,".$value.",%'");
				}
				if($key == 'tags')
				{
					$this->db->where("concat(',',ysw_article.tags,',') like '%,".$value.",%'");
				}
			}
		}
		if($keywords != '')
		{
			$this->db->where("(title like '%".$keywords."%' or summary like '%".$keywords."%')");
		}
		if($order != '')
		{
			$this->db->order_by('ysw_article.recommend desc , ysw_article.'.$order);
		}
		else
		{
			$this->db->order_by('ysw_article.recommend desc , ysw_article.order asc , ysw_article.open_time desc');
		}
		$this->db->where(array('ysw_article.status'=>'1','ysw_article.checked'=>'1'));
		$this->db->limit($num,$num*($page-1));
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	//资讯总数（sunny 2015/1/29）
	public function total_article($where,$order,$keywords)
	{
		$this->db->from('ysw_article');
		if(is_array($where))
		{
			foreach($where as $key=>$value)
			{
				if($key == 'category')
				{
					$this->db->where("concat(',',category,',') like '%,".$value.",%'");
				}
				if($key == 'tags')
				{
					$this->db->where("concat(',',tags,',') like '%,".$value.",%'");
				}
			}
		}
		if($keywords != '')
		{
			$this->db->where("(title like '%".$keywords."%' or summary like '%".$keywords."%')");
		}
		if($order != '')
		{
			$this->db->order_by('recommend desc ,'.$order);
		}
		else
		{
			$this->db->order_by('recommend desc , order asc , open_time desc');
		}
		$this->db->where(array('status'=>'1','checked'=>'1'));
		$query = $this->db->get();
		return $query->num_rows();
	}	

	//资讯详细信息
	public function article_info($article_uuid)
	{
		$this->db->select('ysw_article.id,ysw_article.article_uuid,ysw_article.title,ysw_article.author,ysw_article.content,ysw_article.open_time,ysw_article.view,ysw_article.tags,ysw_article.source,ysw_article.category,ysw_article.sn,ysw_article_category.name');
		//$this->db->select('*');
		$this->db->from('ysw_article');
		$this->db->join('ysw_article_category','ysw_article.category = ysw_article_category.id','left');
		$this->db->where(array('article_uuid'=>$article_uuid,'ysw_article.status'=>'1','ysw_article.checked'=>'1'));
		$query = $this->db->get();
		return $query->row();
	}

	//上一篇，下一篇
	public function more_info($category,$id,$action)
	{
		$this->db->select('article_uuid,title');
		$this->db->from('ysw_article');
		if($category != 0)
		{
			$this->db->where("concat(',',category,',') like '%,".$category.",%'");
		}
		$this->db->where('status = 1');
		if($action == 'Previous')
		{
			$this->db->where("id <'".$id."'");
			$this->db->order_by('create_time desc');
		}
		else
		{
			$this->db->where("id >'".$id."'");
			$this->db->order_by('create_time asc');
		}
		$this->db->limit('1');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->row();
	}

	//相关资讯
	public function linked_article($tags,$category,$article_uuid)
	{
		$tags = explode(',',$tags);
		$this->db->select('ysw_article.article_uuid,ysw_article.title,ysw_article.category,ysw_article_category.name');
		$this->db->from('ysw_article');
		$this->db->join('ysw_article_category','ysw_article.category = ysw_article_category.id','left');
		if($tags != '')
		{
			if(is_array($tags))
			{
				foreach($tags as $value)
				{
					$this->db->or_where("concat(',',ysw_article.tags,',') like '%,".$value.",%'");
				}
			}
		}
		if($category != 0)
		{
			$this->db->where("concat(',',ysw_article.category,',') like '%,".$category.",%'");
		}
		$this->db->where("ysw_article.status = 1 and ysw_article.article_uuid != '".$article_uuid."'");
		//$this->db->where("ysw_article.article_uuid not in ".$article_uuid."");
		$this->db->order_by('ysw_article.order asc , ysw_article.create_time desc');
		$this->db->limit('4');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result();
	}

	//添加文章评论
	public function get_comment($data)
	{
		$this->db->insert('ysw_article_comment',$data);
	}

	//文章评论列表
	public function comment_list($article_uuid,$act)
	{
		$this->db->select('ysw_article_comment.id,ysw_article_comment.parent,ysw_article_comment.uuid,ysw_article_comment.comment_uuid,ysw_article_comment.content,ysw_article_comment.up,ysw_article_comment.down,ysw_article_comment.create_time,ysw_user.nickname,ysw_user.user_grade,ysw_user.user_pic,ysw_region.name as province');

		//$this->db->select('ysw_article_comment.comment_uuid,ysw_article_comment.parent,ysw_article_comment.content,ysw_article_comment.up,ysw_article_comment.down,ysw_article_comment.create_time,ysw_user.nickname,ysw_user.user_grade,ysw_user.user_pic,ysw_region.name as province');
		$this->db->from('ysw_article_comment');
		$this->db->join('ysw_user','ysw_article_comment.uuid = ysw_user.uuid','left');
		$this->db->join('ysw_user_info','ysw_article_comment.uuid = ysw_user_info.uuid','left');
		$this->db->join('ysw_region','ysw_user_info.province = ysw_region.id','left');
		$this->db->where('ysw_article_comment.article_uuid',$article_uuid);
		$this->db->where('ysw_article_comment.status','1');
		//$this->db->where('ysw_article_comment.parent','0');
		if($act)
		{
			$this->db->order_by('ysw_article_comment.create_time '.$act);
		}
		
		$query = $this->db->get();
		return $query->result_array();
		//return $query->result();
		/*foreach($query->result() as $row)
		{
			//$data[] = $row;
			if(empty($row->parent))
			{
				$data[] = $row;
			}
			else
			{
				$data[$row->parent] = $row;
			}
		}
		var_dump($data);exit;*/
	}

	// 文章评论 顶/踩 的数量
	public function num($comment_uuid,$act)
	{
		$this->db->select($act);
		$query = $this->db->get_where('ysw_article_comment',array('comment_uuid' => $comment_uuid));
		foreach ($query->result_array() as $value) {
			$num = $value[$act];
		}
		return $num;
	}

	// 更新文章评论 顶/踩 的数量
	public function update_num($comment_uuid,$num,$act)
	{
		$data = array($act => $num);
		$this->db->update('ysw_article_comment',$data,array('comment_uuid' => $comment_uuid));
	}

	// 评论参与参与评论人数
	public function comment_join_num($article_uuid,$columns)
	{
		$this->db->from('ysw_article_comment');
		$this->db->where('article_uuid',$article_uuid);
		if($columns)
		{
			$this->db->group_by($columns);
		}
		$this->db->where('status','1');
		$query = $this->db->get();
		return $query->num_rows();
	}

	//最新资讯
	public function news($limit = 5)
	{
		$this->db->select('article_uuid,title,ysw_article.create_time,name');
		$this->db->from('ysw_article');
		$this->db->join('ysw_article_category','ysw_article.category = ysw_article_category.id','left');
		$this->db->where(array('ysw_article.status'=>'1','ysw_article.checked'=>'1'));
		$this->db->order_by('ysw_article.recommend desc , ysw_article.create_time desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result();
	}

	//资讯纠错
	public function correction($data)
	{
		$this->db->insert('ysw_article_error',$data);
	}

	//资讯标签
	public function tags()
	{
		$this->db->select('id,name');
		$query = $this->db->get_where('ysw_tags',array('status'=>1));
		foreach($query->result() as $row)
		{
			$data[$row->id] = $row->name;
		}
		return $data;
	}

	//热门资讯
	public function hot_news($limit = 8)
	{
		$this->db->select('article_uuid,title,summary,pic,create_time');
		$this->db->from('ysw_article');
		$this->db->where(array('status'=>'1','checked'=>'1'));
		$this->db->order_by('recommend desc , create_time desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result();
	}

}