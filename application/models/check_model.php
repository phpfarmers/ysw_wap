<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check_model extends  CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

  	//查询公司列表
    public function company_name_list($company_name)
	{
		$this->db->select('company_uuid,company_name,checked');
		$this->db->from('ysw_company');
		//$this->db->where("(status = 1 or (create_uuid='".$uuid."' and status <= 1))");
		//$this->db->where("and status = 1 and checked < 1");
		$this->db->where(array('status'=>'1','checked <'=>'2'));
		$this->db->like('company_name', $company_name);
		$this->db->order_by('status desc');
		$this->db->limit('10');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
    }

  	//查询已审核和我添加未删除的产品列表
    public function product_name_list($product_name,$uuid ='')
	{
		$this->db->select('product_uuid,product_name,company_name');
		$this->db->from('ysw_product');
		$this->db->join('ysw_company','ysw_product.company_uuid = ysw_company.company_uuid','left');
		$this->db->where(array('ysw_product.status'=>'1','ysw_product.checked <'=>'2'));
		$this->db->like('ysw_product.product_name', $product_name);
		$this->db->limit('10');
		$query = $this->db->get();
		return $query->result_array();
    }

	//返回公司详细信息
	public function company_info($company_uuid)
	{
		$this->db->select('company_uuid,company_name,company_pic,company_type,company_size,province,city,company_desc,company_address,company_web,company_phone,company_email,status');
		$this->db->from('ysw_company');
		$this->db->where('company_uuid',$company_uuid);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function linked_product_info($product_uuid)
	{
		$this->db->select('ysw_product.product_uuid,ysw_product.product_name,ysw_product.product_icon,ysw_product.company_uuid,ysw_company.company_name');
		$this->db->from('ysw_product');
		$this->db->join('ysw_company', 'ysw_product.company_uuid = ysw_company.company_uuid','left');
		$this->db->where('ysw_product.product_uuid',$product_uuid);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->row_array();


	}

	//查询公司是否存在
	public function Check_company($company_name)
	{
		$this->db->from('ysw_company');
		$this->db->where('company_name',$company_name);
		//$this->db->where("((status = 1 and checked = 1) or (create_uuid='".$uuid."' and status = 1 and checked < 1))");
		$this->db->where(array('status'=>'1','checked <'=>'2'));
		$query = $this->db->get();
		return $query->num_rows();
	}

}