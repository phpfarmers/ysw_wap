<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trust_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function add_trust($data)
	{
		$this->db->insert('ysw_entrust',$data);
	}

}