<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class pengaturan_bobot_jarak_model extends CI_Model{

		private $pengaturan_bobot_id,$thn_pelajaran,$jarak_min,$jarak_max,$bobot;				

		const pkey = "pengaturan_bobot_id";
		const tbl_name = "pengaturan_bobot_jarak";

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

		function get_pengaturan_bobot_id() {
	        return $this->pengaturan_bobot_id;
	    }

	    function get_thn_pelajaran() {
	        return $this->thn_pelajaran;
	    }

	    function get_jarak_min() {
	        return $this->jarak_min;
	    }

	    function get_jarak_max() {
	        return $this->jarak_max;
	    }

	    function get_bobot() {
	        return $this->bobot;
	    }	    


	    
		function set_pengaturan_bobot_id($data) {
	        $this->pengaturan_bobot_id=$data;
	    }

	    function set_thn_pelajaran($data) {
	        $this->thn_pelajaran=$data;
	    }

	    function set_jarak_min($data) {
	        $this->jarak_min=$data;
	    }

	    function set_jarak_max($data) {
	        $this->jarak_max=$data;
	    }

	    function set_bobot($data) {
	        $this->bobot=$data;
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

		function get_by_id($id){
			$query = $this->db->query("SELECT * FROM ".$this->get_tbl_name()." WHERE ".$this->get_pkey()."='".$id."'");
			return $query->row_array();
		}
	}
?>