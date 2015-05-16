<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cooperation_model extends  CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//查询关联的产品及公司
	public function linked_product_company($product_uuid)
	{
		$this->db->select('ysw_product.product_uuid,ysw_product.product_name,ysw_product.product_icon,ysw_company.company_uuid,ysw_company.company_name');
		$this->db->from('ysw_product');
		$this->db->join('ysw_company','ysw_product.company_uuid = ysw_company.company_uuid','left');
		$this->db->where('ysw_product.product_uuid',$product_uuid);
		$query = $this->db->get();
		return $query->row_array();
	}

	//输出游戏阶段
	public function product_step()
	{
		$this->db->select('id,name,target');
		$this->db->from('ysw_product_step');
		$this->db->where('status','0');
		$this->db->order_by('order ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	// 输出任务目标
	public function product_target()
	{
		$this->db->select('id,name');
		$this->db->from('ysw_task_target');
		$this->db->where('status','0');
		$this->db->where('grade','1');
		$this->db->order_by('order ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	// 输出任务目标二级分类
	public function target_grade($sid)
	{
		$this->db->select('id,name');
		$this->db->from('ysw_task_target');
		$this->db->where_in('parent',$sid);
		$this->db->where('status','0');
		$this->db->where('grade','2');
		$this->db->order_by('order ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}

	// 添加合作信息
	public function insert_cooperation($data_form)
	{
		$this->db->insert('ysw_task',$data_form);
	}

	// 更新合作信息
	public function update_cooperation($data_form,$task_uuid)
	{
		$this->db->update('ysw_task',$data_form,array('task_uuid'=>$task_uuid));
	}


	// 会员中心我发的合作信息
	public function cooperation_product($uuid,$company_uuid,$num,$page)
	{
		$this->db->select('ysw_task.task_uuid,ysw_task.task_target_id,ysw_task_target.name target_name,ysw_task.checked,ysw_product.product_uuid,ysw_task.title,ysw_product.product_icon');
		$this->db->from('ysw_task');
		$this->db->join('ysw_product', 'ysw_task.product_uuid = ysw_product.product_uuid','left');
		$this->db->join('ysw_task_target', 'ysw_task.task_target_id = ysw_task_target.id','left');
		$this->db->where('ysw_task.uuid',$uuid);
		if($company_uuid)
		{
			$this->db->where('ysw_product.company_uuid',$company_uuid);
		}
		$this->db->where('ysw_task.status','1');
		$this->db->order_by('ysw_task.create_time','desc');
		$this->db->limit($num,$num*($page-1));
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result();
	}

	// 会员中心删除我发布的合作信息
	public function del_cooperation($task_uuid)
	{
		$data = array(
			'status' => '0'
		);
		$this->db->update('ysw_task', $data,array('task_uuid' => $task_uuid));
	}

	public function cooperation_info($task_uuid)
	{
		/* task_uuid,product_step,task_target_id,product_step_percent,area,info,end_time,start_time,team_step,amount,stock,cycle,prospectus,financing,partner_num,platform,requires,styles,content_serialize,partner_type,partner_method,limit_time*/
		/* ysw_product.product_uuid,ysw_product.product_name,ysw_product.product_icon,ysw_company.company_uuid,ysw_company.company_name */
		$this->db->select('*');
		$this->db->from('ysw_task');
		$this->db->join('ysw_product','ysw_task.product_uuid = ysw_product.product_uuid','left');
		$this->db->join('ysw_company','ysw_product.company_uuid = ysw_company.company_uuid','left');
		$this->db->join('ysw_task_target','ysw_task.task_target_id = ysw_task_target.id','left');
		$this->db->where('task_uuid',$task_uuid);
		$query = $this->db->get();
		return $query->row_array();
	}

	//输出产品信息
	public function product_info($product_uuid)
	{
		$this->db->select('ysw_product.product_uuid,ysw_product.product_name,ysw_product.product_icon,ysw_company.company_uuid,ysw_company.company_name');
		$this->db->from('ysw_product');
		$this->db->join('ysw_company','ysw_product.company_uuid = ysw_company.company_uuid','left');
		$this->db->where('ysw_product.product_uuid',$product_uuid);
		$query = $this->db->get();
		return $query->row_array();
	}

	//我发布的合作总数
	public function total_rows($uuid,$company_uuid) {

		$this->db->from('ysw_task');
		$this->db->join('ysw_product', 'ysw_task.product_uuid = ysw_product.product_uuid','left');
		$this->db->where('ysw_task.uuid',$uuid);
		if($company_uuid)
		{
			$this->db->where('ysw_product.company_uuid',$company_uuid);
		}
		$this->db->where('ysw_task.status','1');
		$query = $this->db->get();
		return $query->num_rows();
	}

	//平台类型
	public function platform_step()
	{
		$this->db->select('id,platform_name,parent');
		$this->db->order_by('order asc');
		$query = $this->db->get_where('ysw_product_platform',array('status'=>'0'));
		return $query->result_array();
	}

}