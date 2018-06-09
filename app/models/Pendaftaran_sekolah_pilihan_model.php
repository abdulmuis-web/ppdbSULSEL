<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class pendaftaran_sekolah_pilihan_model extends CI_Model{

		private $sepil_id,$id_pendaftaran,$jalur_id,$sekolah_id,$pilihan_ke,$jarak_sekolah,$status;

		const pkey = "sepil_id";
		const tbl_name = "pendaftaran_sekolah_pilihan";

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

		function get_jalur_id(){
			return $this->jalur_id;
		}

		function get_status() {
	        return $this->status;
	    }

		function get_sepil_id() {
	        return $this->sepil_id;
	    }

	    function get_id_pendaftaran() {
	        return $this->id_pendaftaran;
	    }

	    function get_sekolah_id() {
	        return $this->sekolah_id;
	    }


	    function get_pilihan_ke(){
	    	return $this->pilihan_ke;
	    }

	    function get_jarak_sekolah() {
	        return $this->jarak_sekolah;
	    }

		

		function set_sepil_id($data) {
	        $this->sepil_id=$data;
	    }

	    function set_id_pendaftaran($data) {
	        $this->id_pendaftaran=$data;
	    }

	    function set_sekolah_id($data) {
	        $this->sekolah_id=$data;
	    }

	    function set_jarak_sekolah($data) {
	        $this->jarak_sekolah=$data;
	    }	   

	    function set_pilihan_ke($data) {
	        $this->pilihan_ke=$data;
	    }

	    function set_status($data) {
	        $this->status=$data;
	    }

	    function set_jalur_id($data) {
	        $this->jalur_id=$data;
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