<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ketentuan_berlaku_model extends CI_Model{

		private $ketentuan_id,$jalur_id,$thn_pelajaran,$ketentuan;

		const pkey = "deskripsi";
		const tbl_name = "ketentuan_berlaku";

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

		function get_deskripsi() {
	        return $this->deskripsi;
	    }
	    

		function set_deskripsi($deskripsi) {
	        $this->deskripsi = $deskripsi;
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
			$query = $this->db->query("SELECT * FROM ".$this->get_tbl_name()." ORDER BY ".$this->get_pkey()." ASC");
			return $query->result_array();
		}
	}
?>