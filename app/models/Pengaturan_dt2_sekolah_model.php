<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Pengaturan_dt2_sekolah_model extends CI_Model{

		private $dt2_id,$dt2_sekolah_id,$status;

		const pkey = array("dt2_id","dt2_sekolah_id");
		const tbl_name = "pengaturan_dt2_sekolah";

		function get_pkey(){
			return self::pkey;
		}		

		function get_tbl_name(){
			return self::tbl_name;
		}

		function __construct(array $init_properties=array()){

			if(count($init_properties)>0){
				foreach($init_properties as $key=>$val){
					$this->$key = $val;
				}
			}
		}

		function get_dt2_id() {
	        return $this->dt2_id;
	    }

	    function get_dt2_sekolah_id() {
	        return $this->dt2_sekolah_id;
	    }

	    function get_status() {
	        return $this->status;
	    }	    


	    
		function set_dt2_id($data) {
	        $this->dt2_id=$data;
	    }

	    function set_dt2_sekolah_id($data) {
	        $this->dt2_sekolah_id=$data;
	    }

	    function set_status($data) {
	        $this->status=$data;
	    }
	    

	    function get_field_list(){
			return get_object_vars($this);
		}

		function get_property_collection(){
			$field_list = get_object_vars($this);

			$collections = array();
			foreach($field_list as $key=>$val){
				if($val!='')
					$collections[$key]=$val;
			}

			return $collections;
		}

		function get_all_data(){
			$pkey = $this->get_pkey();
			
			if(is_array($pkey)){
				$s = false;
				foreach ($pkey as $key => $value) {
					$order_field .= ($s?",":"").$value;
					$s = true;
				}
			}else{
				$order_field = $pkey;
			}

			$query = $this->db->query("SELECT * FROM ".$this->get_tbl_name()." ORDER BY ".$order_field." ASC");
			return $query->result_array();
		}

		function get_by_id($id){
			$cond = "";
			if(is_array($id)){
				$s = false;
				foreach($id as $key=>$val){
					$cond .= ($s?" AND ":"").$key."='".$val."'";
					$s = true;
				}
			}else{
				$cond = $this->get_pkey()."='".$id."'";
			}
			$query = $this->db->query("SELECT * FROM ".$this->get_tbl_name()." WHERE ".$cond);
			return $query->row_array();
		}
	}
?>