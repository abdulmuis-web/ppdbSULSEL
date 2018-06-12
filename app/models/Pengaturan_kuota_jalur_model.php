<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class pengaturan_kuota_jalur_model extends CI_Model{

		private $pengaturan_kuota_id,$jalur_id,$ktg_jalur_id,$thn_pelajaran,$tipe_sekolah_id,
				$jml_sekolah,$persen_kuota,$jumlah_kuota;

		const pkey = "pengaturan_kuota_id";
		const tbl_name = "pengaturan_kuota_jalur";

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

		function get_pengaturan_kuota_id() {
	        return $this->pengaturan_kuota_id;
	    }

	    function get_jalur_id() {
	        return $this->jalur_id;
	    }

	    function get_ktg_jalur_id() {
	        return $this->ktg_jalur_id;
	    }

	    function get_thn_pelajaran() {
	        return $this->thn_pelajaran;
	    }

	    function get_tipe_sekolah_id() {
	        return $this->tipe_sekolah_id;
	    }

	    function get_jml_sekolah() {
	        return $this->jml_sekolah;
	    }

	    function get_persen_kuota() {
	        return $this->persen_kuota;
	    }

	    function get_jumlah_kuota() {
	        return $this->jumlah_kuota;
	    }	    


	    
		function set_pengaturan_kuota_id($data) {
	        $this->pengaturan_kuota_id=$data;
	    }

	    function set_jalur_id($data) {
	        $this->jalur_id=$data;
	    }

	    function set_ktg_jalur_id($data) {
	        $this->ktg_jalur_id=$data;
	    }

	    function set_thn_pelajaran($data) {
	        $this->thn_pelajaran=$data;
	    }

	    function set_tipe_sekolah_id($data) {
	        $this->tipe_sekolah_id=$data;
	    }

	    function set_jml_sekolah($data) {
	        $this->jml_sekolah=$data;
	    }

	    function set_persen_kuota($data) {
	        $this->persen_kuota=$data;
	    }

	    function set_jumlah_kuota($data) {
	        $this->jumlah_kuota=$data;
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