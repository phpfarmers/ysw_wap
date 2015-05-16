<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_model extends  CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//资料分类
	public function data_category()
	{
		$this->db->select('id,name');
		$this->db->from('ysw_data_category');
		$this->db->where('status','1');
		$this->db->limit('7');
		$this->db->order_by('order desc');
		$query = $this->db->get();
		return $query->result();
	}

	// 资料列表
	/*public function data_list($category,$num,$page,$keywords='')
	{
		$this->db->select('ysw_data.data_uuid,ysw_data.title,ysw_data.content,ysw_data.category,ysw_data.view,ysw_data.upon,ysw_data.collect,ysw_data.hits,ysw_data.create_time,ysw_data_category.name');
		$this->db->from('ysw_data');
		$this->db->join('ysw_data_category','ysw_data.category = ysw_data_category.id','left');
		if($category != 0)
		{
			$this->db->where("concat(',',ysw_data.category,',') like '%,".$category.",%'");
		}
		if($keywords)
			$this->db->where("(ysw_data.title like '%".$keywords."%' or ysw_data.summary like '%".$keywords."%')");
		$this->db->where('ysw_data.status','1');
		$this->db->order_by('ysw_data.order asc , ysw_data.create_time desc');
		$this->db->limit($num,$num*($page-1));
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}*/

	//资料总数
	/*public function total_rows($category,$keywords='')
	{
		$this->db->from('ysw_data');
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
	public function data_lists($where,$order,$keywords,$num,$page)
	{
		$this->db->select('ysw_data.data_uuid,ysw_data.title,ysw_data.summary,ysw_data.category,ysw_data.view,ysw_data.upon,ysw_data.collect,ysw_data.hits,ysw_data.open_time,ysw_data_category.name');
		$this->db->from('ysw_data');
		$this->db->join('ysw_data_category','ysw_data.category = ysw_data_category.id','left');
		if(is_array($where))
		{
			foreach($where as $key=>$value)
			{
				if($key == 'category')
				{
					$this->db->where("concat(',',category,',') like '%,".$value.",%'");
				}
			}
		}
		if($keywords != '')
		{
			$this->db->where("(title like '%".$keywords."%' or summary like '%".$keywords."%')");
		}
		if($order != '')
		{
			$this->db->order_by('ysw_data.'.$order);
		}
		else
		{
			$this->db->order_by('ysw_data.order asc , ysw_data.open_time desc');
		}
		$this->db->where(array('ysw_data.status'=>'1','ysw_data.checked'=>'1'));
		$this->db->limit($num,$num*($page-1));
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	//资讯总数（sunny 2015/1/29）
	public function total_data($where,$order,$keywords)
	{
		$this->db->from('ysw_data');
		if(is_array($where))
		{
			foreach($where as $key=>$value)
			{
				if($key == 'category')
				{
					$this->db->where("concat(',',category,',') like '%,".$value.",%'");
				}
			}
		}
		if($keywords != '')
		{
			$this->db->where("(title like '%".$keywords."%' or summary like '%".$keywords."%')");
		}
		if($order != '')
		{
			$this->db->order_by($order);
		}
		else
		{
			$this->db->order_by('order asc , open_time desc');
		}
		$this->db->where(array('ysw_data.status'=>'1','ysw_data.checked'=>'1'));
		$query = $this->db->get();
		return $query->num_rows();
	}

	//资料详细信息
	public function data_info($data_uuid)
	{
		$this->db->select('ysw_data.id,ysw_data.data_uuid,ysw_data.title,ysw_data.download,ysw_data.author,ysw_data.content,ysw_data.open_time,ysw_data.creater,ysw_data.creater_uuid,ysw_data.hits,ysw_data.upon,ysw_data.collect,ysw_data.view,ysw_data.category,ysw_data.sn,ysw_data.status,ysw_data.checked,ysw_data.intergral,ysw_data_category.name');
		$this->db->from('ysw_data');
		$this->db->join('ysw_data_category','ysw_data.category = ysw_data_category.id','left');
		$this->db->where('data_uuid',$data_uuid);
		$query = $this->db->get();
		return $query->row();
	}

	//查询资料发布作者
	public function author($uuid)
	{
		$this->db->select('nickname');
		$query = $this->db->get_where('ysw_user',array('uuid'=>$uuid));
		$author = $query->row()->nickname;
		return $author;
	}

	//上一篇，下一篇
	public function more_info($category,$id,$action)
	{
		$this->db->select('data_uuid,title');
		$this->db->from('ysw_data');
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
	public function linked_data($category,$data_uuid)
	{
		$this->db->select('ysw_data.data_uuid,ysw_data.title,ysw_data.category,ysw_data_category.name');
		$this->db->from('ysw_data');
		$this->db->join('ysw_data_category','ysw_data.category = ysw_data_category.id','left');
		if($category != 0)
		{
			$this->db->where("concat(',',ysw_data.category,',') like '%,".$category.",%'");
		}
		$this->db->where("ysw_data.status = 1 and ysw_data.data_uuid != '".$data_uuid."'");
		$this->db->order_by('ysw_data.order asc , ysw_data.create_time desc');
		$this->db->limit('4');
		$query = $this->db->get();
		return $query->result();
	}

	//查询当前会员是否收藏本资料
	public function collect_num($data_uuid,$uuid)
	{
		$query = $this->db->get_where('ysw_data_collection',array('data_uuid'=>$data_uuid,'uuid'=>$uuid));
		return $query->num_rows();
	}

	// 获取 下载,赞、收藏、浏览量 的数量
	public function num($data_uuid,$field)
	{
		$this->db->select($field);
		$query = $this->db->get_where('ysw_data',array('data_uuid' => $data_uuid));
		foreach ($query->result_array() as $value) {
			$num = $value[$field];
		}
		return $num;
	}

	// 更新 下载,赞、收藏、浏览量 的数量
	public function update_num($data_uuid,$field,$num)
	{
		$data = array($field => $num);
		$this->db->update('ysw_data',$data,array('data_uuid' => $data_uuid));
	}

	//添加赞
	public function insert_upon($data)
	{
		$this->db->insert('ysw_data_upon',$data);
	}

	//添加收藏
	public function insert_collect($data)
	{
		$this->db->insert('ysw_data_collection',$data);
	}

	//添加资料评论
	public function get_comment($data)
	{
		$this->db->insert('ysw_data_comment',$data);
	}

	//资料评论列表
	public function comment_list($data_uuid,$act)
	{
		$this->db->select('ysw_data_comment.id,ysw_data_comment.parent,ysw_data_comment.uuid,ysw_data_comment.comment_uuid,ysw_data_comment.content,ysw_data_comment.up,ysw_data_comment.down,ysw_data_comment.create_time,ysw_user.nickname,ysw_user.user_grade,ysw_user.user_pic,ysw_region.name as province');
		$this->db->from('ysw_data_comment');
		$this->db->join('ysw_user','ysw_data_comment.uuid = ysw_user.uuid','left');
		$this->db->join('ysw_user_info','ysw_data_comment.uuid = ysw_user_info.uuid','left');
		$this->db->join('ysw_region','ysw_user_info.province = ysw_region.id','left');
		$this->db->where('ysw_data_comment.data_uuid',$data_uuid);
		$this->db->where('ysw_data_comment.status','1');
		if($act)
		{
			$this->db->order_by('ysw_data_comment.create_time '.$act);
		}
		
		$query = $this->db->get();
		return $query->result_array();
	}

	// 文章评论 顶/踩 的数量
	public function num_c($comment_uuid,$act)
	{
		$this->db->select($act);
		$query = $this->db->get_where('ysw_data_comment',array('comment_uuid' => $comment_uuid));
		foreach ($query->result_array() as $value) {
			$num = $value[$act];
		}
		return $num;
	}

	// 更新文章评论 顶/踩 的数量
	public function update_num_c($comment_uuid,$num,$act)
	{
		$data = array($act => $num);
		$this->db->update('ysw_data_comment',$data,array('comment_uuid' => $comment_uuid));
	}

	// 评论参与参与评论人数
	public function comment_join_num($data_uuid,$columns)
	{
		$this->db->from('ysw_data_comment');
		$this->db->where('data_uuid',$data_uuid);
		if($columns)
		{
			$this->db->group_by($columns);
		}
		$this->db->where('status','1');
		$query = $this->db->get();
		return $query->num_rows();
	}

	//读取资料信息
	public function data_detail($uuid,$data_uuid)
	{
		$this->db->select('data_uuid,title,category,download,content,feedback,intergral');
		$query = $this->db->get_where('ysw_data',array('data_uuid'=>$data_uuid,'creater_uuid'=>$uuid));
		return $query->row_array();
	}

	//会员上传资料
	public function add_data($data)
	{
		$this->db->insert('ysw_data',$data);
	}

	//编辑资料
	public function update_data($data,$data_uuid,$uuid)
	{
		$this->db->update('ysw_data',$data,array('data_uuid'=>$data_uuid,'creater_uuid'=>$uuid));
	}

	//资料纠错
	public function correction($data)
	{
		$this->db->insert('ysw_data_error',$data);
	}

	//获取下载资料信息
	public function down_data_info($data_uuid)
	{
		$this->db->select('title,intergral');
		$query = $this->db->get_where('ysw_data',array('data_uuid'=>$data_uuid));
		return $query->row();
	}

	//判断当前资料此会员是否点赞
	public function upon_num($data_uuid,$uuid)
	{
		$query = $this->db->get_where('ysw_data_upon',array('data_uuid'=>$data_uuid,'uuid'=>$uuid));
		return $query->num_rows();
	}

	//更新资料点赞数量
	public function update_upon_num($data_uuid,$upon_num)
	{
		$data = array(
			'upon'=>$upon_num+1
			);
		$this->db->update('ysw_data',$data,array('data_uuid'=>$data_uuid));
	}

	//更新资料收藏数量
	public function update_collect_num($data_uuid,$collect_num)
	{
		$data = array(
			'collect'=>$collect_num+1
			);
		$this->db->update('ysw_data',$data,array('data_uuid'=>$data_uuid));
	}

	public function fetch_id($data_uuid)
	{
		$this->db->select('download');
		$query = $this->db->get_where('ysw_data',array('data_uuid'=>$data_uuid,'status'=>'1','checked <'=>'2'));
		return $query->row();		
	}

}