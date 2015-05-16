<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* jeff 2014/11/25 
* 
*/
class Article_model extends CI_Model{
	private $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table_name = $this->db->dbprefix.'article';
	}

	
	/**
	*
	*/
	public function lists($pagesize = 0,$count = 20,$where = '',$order_by = '',$select = '*')
	{
		$data = array();
		$category = array();
		$tags = array();
		$result = array();
		if($where)
			$this->db->where($where);
		$total_rows = $this->db->get($this->table_name)->num_rows();
		$result['total_rows'] = $total_rows;
		
		$pagesize = intval($pagesize);
		$count = intval($count);
		if($where)
			$this->db->where($where);
		if($order_by)
			$this->db->order_by($order_by);
		$this->db->limit($count,$pagesize);
		$this->db->select($select);
		$this->db->from($this->table_name);
		$query = $this->db->get();
		foreach($query->result() as $row)
		{
			$data[] = $row;
			if($row->category)
			{
				$catarr = explode(',',$row->category);
				for($i=0;$i<count($catarr);$i++)
				{				
					if(!in_array($catarr[$i],$category))
						$category[]=$catarr[$i];
				}
			}
			if($row->tags)
			{
				$tagsarr = explode(',',$row->tags);
				for($i=0;$i<count($tagsarr);$i++)
				{				
					if(!in_array($tagsarr[$i],$tags))
						$tags[]=$tagsarr[$i];
				}
			}
		}
		$result['data'] = $data;
		$result['category'] = $category;
		$result['tags'] = $tags;
		
		return $result;
	}
	
	public function update($data=array())
	{
		if(empty($data)) return FALSE;

		$article_uuid = isset($data['article_uuid'])&&$data['article_uuid']?$data['article_uuid']:'';
		if(!$article_uuid) return FALSE;
		unset($data['article_uuid']);
		$this->db->where('article_uuid',$article_uuid);
		if($this->db->update($this->table_name,$data)) return TRUE;

		return FALSE;		
	}

	
	/*
	* column 为查询的字段,
	* article_uuid 会员id
	* 取数据
	*/
	public function fetch_id($article_uuid='',$column='*')
	{
		if(!$article_uuid) return FALSE;

		$this->db->where('article_uuid',$article_uuid);
		$this->db->select($column);
		return $this->db->get($this->table_name)->row();
		
	}
	/**
	 * jeff 2014/12/5
	 */
	public function article_list($column = ' * ',$where='',$limit='',$order_by='')
	 {
		$this->db->select($column);
		if($where)
			$this->db->where($where);
		$limit = intval($limit);
		if($limit)
			$this->db->limit($limit);
		if($order_by)			
			$this->db->order_by($order_by);
		return $this->db->get($this->table_name)->result();
	 }
}