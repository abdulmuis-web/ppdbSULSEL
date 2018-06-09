<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class hasil_seleksi_model extends CI_Model{

		private $hasil_id,$id_pendaftaran,$jalur_id,$sekolah_id,$tipe_sekolah_id,$kompetensi_id,
				$pilihan_ke,$thn_pelajaran,$score,$peringkat;

		const pkey = "hasil_id";
		const tbl_name = "hasil_seleksi";

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

		function get_hasil_id() {
	        return $this->hasil_id;
	    }

	    function get_id_pendaftaran() {
	        return $this->id_pendaftaran;
	    }

	    function get_jalur_id() {
	        return $this->jalur_id;
	    }

	    function get_sekolah_id() {
	        return $this->sekolah_id;
	    }

	    function pilihan_ke() {
	        return $this->pilihan_ke;
	    }

	    function get_thn_pelajaran() {
	        return $this->thn_pelajaran;
	    }

	    function get_score() {
	        return $this->score;
	    }

	    function get_peringkat() {
	        return $this->peringkat;
	    }

	    function get_kompetensi_id() {
	        return $this->kompetensi_id;
	    }

	    function get_tipe_sekolah_id() {
	        return $this->tipe_sekolah_id;
	    }



		function set_hasil_id($data) {
	        $this->hasil_id=$data;
	    }

	    function set_id_pendaftaran($data) {
	        $this->id_pendaftaran=$data;
	    }

	    function set_jalur_id($data) {
	        $this->jalur_id=$data;
	    }

	    function set_sekolah_id($data) {
	        $this->sekolah_id=$data;
	    }

	    function set_pilihan_ke($data) {
	        $this->pilihan_ke=$data;
	    }

	    function set_thn_pelajaran($data) {
	        $this->thn_pelajaran=$data;
	    }

	    function set_score($data) {
	        $this->score=$data;
	    }

	    function set_peringkat($data) {
	        $this->peringkat=$data;
	    }

	    function set_kompetensi_id($data) {
	        $this->kompetensi_id=$data;
	    }
	    
	    function set_tipe_sekolah_id($data) {
	        $this->tipe_sekolah_id=$data;
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