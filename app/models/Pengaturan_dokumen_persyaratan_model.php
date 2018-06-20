<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class pengaturan_dokumen_persyaratan_model extends CI_Model{

		private $pengaturan_dokumen_id,$jalur_id,$thn_pelajaran,$dokumen_id,$status;

		const pkey = "pengaturan_dokumen_id";
		const tbl_name = "pengaturan_dokumen_persyaratan";

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

		function get_pengaturan_dokumen_id() {
	        return $this->pengaturan_dokumen_id;
	    }

	    function get_jalur_id() {
	        return $this->jalur_id;
	    }

	    function get_thn_pelajaran() {
	        return $this->thn_pelajaran;
	    }

	    function get_dokumen_id() {
	        return $this->dokumen_id;
	    }

	    function get_status() {
	        return $this->status;
	    }



		function set_pengaturan_dokumen_id($data) {
	        $this->pengaturan_dokumen_id=$data;
	    }

	    function set_jalur_id($data) {
	        $this->jalur_id=$data;
	    }

	    function set_thn_pelajaran($data) {
	        $this->thn_pelajaran=$data;
	    }

	    function set_dokumen_id($data) {
	        $this->dokumen_id=$data;
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