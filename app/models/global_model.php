<?php
  defined('BASEPATH') OR exit('No derict script access allowed!');  
  
  class global_model extends CI_Model
  {

  	private $dao;

  	function __construct(){
  		$this->dao = new DAO('',$this->db);
  	}

  	function initialize_dao($tbl_name){
  		$this->dao = new DAO($tbl_name,$this->db);
  	}

  	function get_dao(){
  		return $this->dao;
  	}

	function get_incrementID($pk,$tbl)
	{
		$this->dao->set_sql_without_params("SELECT ".$pk." FROM ".$tbl." ORDER BY ".$pk." DESC");
		$q = $this->dao->execute(0);
		$id=1;
		if($q->num_rows()>0)
		{
			$d=$q->row_array();
			$id=$d[$pk]+1;
		}
		return $id;
	}	

	function get_system_params(){
		$query = $this->db->query("SELECT value FROM system_params");		
		$rows = array_map(function($a){
			return $a['value'];
		},$query->result_array());
		
		return $rows;
	}
 
  }
  
