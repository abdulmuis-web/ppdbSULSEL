<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ref_dokumen_persyaratan_model extends CI_Model{

		private $ref_dokumen_id,$nama_dokumen;

		const pkey = "ref_dokumen_id";
		const tbl_name = "ref_dokumen_persyaratan";

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

		function get_ref_dokumen_id() {
	        return $this->ref_dokumen_id;
	    }

	    function get_nama_dokumen() {
	        return $this->nama_dokumen;
	    }


	    
		function set_ref_dokumen_id($ref_dokumen_id) {
	        $this->ref_dokumen_id = $ref_dokumen_id;
	    }

	    function set_nama_dokumen($nama_dokumen) {
	        $this->nama_dokumen = $nama_dokumen;
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