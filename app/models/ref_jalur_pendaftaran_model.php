<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class ref_jalur_pendaftaran_model extends CI_Model{

		private $ref_jalur_id,$ktg_jalur_id,$nama_jalur,$keterangan;

		const pkey = "ref_jalur_id";
		const tbl_name = "ref_jalur_pendaftaran";

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

		function get_jalur_id() {
	        return $this->jalur_id;
	    }

	    function get_ktg_jalur_id() {
	        return $this->ktg_jalur_id;
	    }

	    function get_nama_jalur() {
	        return $this->nama_jalur;
	    }

	    function get_keterangan() {
	        return $this->keterangan;
	    }

		function set_jalur_id($jalur_id) {
	        $this->jalur_id = $jalur_id;
	    }

	    function set_ktg_jalur_id($ktg_jalur_id) {
	        $this->ktg_jalur_id = $ktg_jalur_id;
	    }

	    function set_nama_jalur($nama_jalur) {
	        $this->nama_jalur = $nama_jalur;
	    }

	    function set_keterangan($keterangan) {
	        $this->keterangan = $keterangan;
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