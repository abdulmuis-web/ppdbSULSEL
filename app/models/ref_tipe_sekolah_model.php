<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ref_tipe_sekolah_model extends CI_Model{

		private $ref_tipe_sklh_id,$nama_tipe_sekolah,$akronim;

		const pkey = "ref_tipe_sklh_id";
		const tbl_name = "ref_tipe_sekolah";

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

		function get_ref_tipe_sklh_id() {
	        return $this->ref_tipe_sklh_id;
	    }

	    function get_nama_tipe_sekolah() {
	        return $this->nama_tipe_sekolah;
	    }

	    function get_akronim() {
	        return $this->akronim;
	    }

		function set_ref_tipe_sklh_id($ref_tipe_sklh_id) {
	        $this->ref_tipe_sklh_id = $ref_tipe_sklh_id;
	    }

	    function set_nama_tipe_sekolah($nama_tipe_sekolah) {
	        $this->nama_tipe_sekolah = $nama_tipe_sekolah;
	    }

	    function set_akronim($akronim) {
	        $this->akronim = $akronim;
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