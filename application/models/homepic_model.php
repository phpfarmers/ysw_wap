<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepic_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_lists()
	{
		$this->db->order_by('order','asc');
		$this->db->limit('6');
		$query = $this->db->get_where('ysw_home_pic',array('status'=>'1'));
		return $query->result();
	}

}