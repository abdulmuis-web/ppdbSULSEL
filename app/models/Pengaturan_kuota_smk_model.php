<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class pengaturan_kuota_smk_model extends CI_Model{

		private $pengaturan_kuota_id,$sekolah_id,$kompetensi_id,$thn_pelajaran,$jml_rombel,
				$jml_siswa_rombel,$kuota_domisili,$kuota_afirmasi,$kuota_akademik,$kuota_prestasi,
				$kuota_khusus,$jml_kuota;

		const pkey = "pengaturan_kuota_id";
		const tbl_name = "pengaturan_kuota_smk";

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

	    function get_sekolah_id() {
	        return $this->sekolah_id;
	    }

	    function get_kompetensi_id() {
	        return $this->kompetensi_id;
	    }

	    function get_thn_pelajaran() {
	        return $this->thn_pelajaran;
	    }

	    function get_jml_rombel() {
	        return $this->jml_rombel;
	    }

	    function get_jml_siswa_rombel() {
	        return $this->jml_siswa_rombel;
	    }

	    function get_kuota_domisili() {
	        return $this->kuota_domisili;
	    }

	    function get_kuota_afirmasi() {
	        return $this->kuota_afirmasi;
	    }

	    function get_kuota_akademik() {
	        return $this->kuota_akademik;
	    }

	    function get_kuota_prestasi() {
	        return $this->kuota_prestasi;
	    }

	    function get_kuota_khusus() {
	        return $this->kuota_khusus;
	    }

	    function get_jml_kuota() {
	        return $this->jml_kuota;
	    }


		function set_pengaturan_kuota_id($data) {
	        $this->pengaturan_kuota_id=$data;
	    }

	    function set_sekolah_id($data) {
	        $this->sekolah_id=$data;
	    }	    

	    function set_kompetensi_id($data) {
	        $this->kompetensi_id=$data;
	    }	    

	    function set_thn_pelajaran($data) {
	        $this->thn_pelajaran=$data;
	    }

	    function set_jml_rombel($data) {
	        $this->jml_rombel=$data;
	    }

	    function set_jml_siswa_rombel($data) {
	        $this->jml_siswa_rombel=$data;
	    }

	    function set_kuota_domisili($data) {
	        $this->kuota_domisili=$data;
	    }

	    function set_kuota_afirmasi($data) {
	        $this->kuota_afirmasi=$data;
	    }

	    function set_kuota_akademik($data) {
	        $this->kuota_akademik=$data;
	    }

	    function set_kuota_prestasi($data) {
	        $this->kuota_prestasi=$data;
	    }

	    function set_kuota_khusus($data) {
	        $this->kuota_khusus=$data;
	    }

	    function set_jml_kuota($data) {
	        $this->jml_kuota=$data;
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