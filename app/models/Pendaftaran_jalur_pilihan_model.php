<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class pendaftaran_jalur_pilihan_model extends CI_Model{

		private $japil_id,$id_pendaftaran,$jalur_id,$tipe_sekolah_id,$zona_id;

		const pkey = "japil_id";
		const tbl_name = "pendaftaran_jalur_pilihan";

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

		function get_japil_id() {
	        return $this->japil_id;
	    }

	    function get_id_pendaftaran() {
	        return $this->id_pendaftaran;
	    }

	    function get_jalur_id() {
	        return $this->jalur_id;
	    }

	    function get_tipe_sekolah_id() {
	        return $this->tipe_sekolah_id;
	    }

	    function get_zona_id() {
	        return $this->zona_id;
	    }

		
		function set_japil_id($data) {
	        $this->japil_id=$data;
	    }

	    function set_id_pendaftaran($data) {
	        $this->id_pendaftaran=$data;
	    }

	    function set_jalur_id($data) {
	        $this->jalur_id=$data;
	    }

	    function set_tipe_sekolah_id($data) {
	        $this->tipe_sekolah_id=$data;
	    }

	    function set_zona_id($data) {
	        $this->zona_id=$data;
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