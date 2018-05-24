<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ketentuan_umum_model extends CI_Model{

		private $ketentuan_id,$thn_pelajaran,$ketentuan;

		const pkey = "ketentuan_id";
		const tbl_name = "ketentuan_umum";

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

		function get_ketentuan_id() {
	        return $this->ketentuan_id;
	    }

	    function get_thn_pelajaran() {
	        return $this->thn_pelajaran;
	    }

	    function get_ketentuan() {
	        return $this->ketentuan;
	    }

		function set_ketentuan_id($ketentuan_id) {
	        $this->ketentuan_id = $ketentuan_id;
	    }

	    function set_thn_pelajaran($thn_pelajaran) {
	        $this->thn_pelajaran = $thn_pelajaran;
	    }

	    function set_ketentuan($ketentuan) {
	        $this->ketentuan = $ketentuan;
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