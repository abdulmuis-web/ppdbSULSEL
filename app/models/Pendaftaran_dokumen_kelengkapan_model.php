<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class pendaftaran_dokumen_kelengkapan_model extends CI_Model{

		private $dokel_id,$id_pendaftaran,$dokumen,$status;

		const pkey = "dokel_id";
		const tbl_name = "pendaftaran_dokumen_kelengkapan";

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

		function get_dokel_id() {
	        return $this->dokel_id;
	    }

	    function get_id_pendaftaran() {
	        return $this->id_pendaftaran;
	    }

	    function get_dokumen() {
	        return $this->dokumen;
	    }

	    function get_status() {
	        return $this->status;
	    }


		
	    function set_dokel_id($data) {
	        $this->dokel_id=$data;
	    }

	    function set_id_pendaftaran($data) {
	        $this->id_pendaftaran=$data;
	    }

	    function set_dokumen($data) {
	        $this->dokumen=$data;
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
			$query = $this->db->query("SELECT * FROM ".$this->get_tbl_name()." ORDER BY ".$this->get_pkey()." ASC");
			return $query->result_array();
		}
	}
?>