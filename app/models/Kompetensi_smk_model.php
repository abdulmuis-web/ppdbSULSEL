<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Kompetensi_smk_model extends CI_Model{

		private $kompetensi_id,$sekolah_id,$nama_kompetensi;

		const pkey = "kompetensi_id";
		const tbl_name = "kompetensi_smk";

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

		function get_kompetensi_id(){
			return $this->kompetensi_id;
		}

		function get_sekolah_id(){
			return $this->sekolah_id;
		}

		function get_nama_kompetensi(){
			return $this->nama_kompetensi;
		}
		
		

		function set_kompetensi_id($data) {
	        $this->kompetensi_id=$data;
	    }

		function set_sekolah_id($data) {
	        $this->sekolah_id=$data;
	    }

	    function set_nama_kompetensi($data){
			$this->nama_kompetensi=$data;
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