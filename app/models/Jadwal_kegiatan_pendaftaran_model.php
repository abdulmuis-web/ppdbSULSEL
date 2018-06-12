<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class jadwal_kegiatan_pendaftaran_model extends CI_Model{

		private $jadwal_id,$jalur_id,$tipe_sklh_id,$thn_pelajaran,$kegiatan,
				$lokasi,$tgl_buka,$tgl_tutup,$keterangan;

		const pkey = "jadwal_id";
		const tbl_name = "jadwal_kegiatan_pendaftaran";

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

		function get_jadwal_id() {
	        return $this->jadwal_id;
	    }

	    function get_jalur_id() {
	        return $this->jalur_id;
	    }

	    function get_tipe_sklh_id() {
	        return $this->tipe_sklh_id;
	    }

	    function get_thn_pelajaran() {
	        return $this->thn_pelajaran;
	    }

	    function get_kegiatan() {
	        return $this->kegiatan;
	    }

	    function get_lokasi() {
	        return $this->lokasi;
	    }

	    function get_tgl_buka() {
	        return $this->tgl_buka;
	    }

	    function get_tgl_tutup() {
	        return $this->tgl_tutup;
	    }

	    function get_keterangan() {
	        return $this->keterangan;
	    }


	    

		function set_jadwal_id($data) {
	        $this->jadwal_id=$data;
	    }

	    function set_jalur_id($data) {
	        $this->jalur_id=$data;
	    }

	    function set_tipe_sklh_id($data) {
	        $this->tipe_sklh_id=$data;
	    }

	    function set_thn_pelajaran($data) {
	        $this->thn_pelajaran=$data;
	    }

	    function set_kegiatan($data) {
	        $this->kegiatan=$data;
	    }

	    function set_lokasi($data) {
	        $this->lokasi=$data;
	    }

	    function set_tgl_buka($data) {
	        $this->tgl_buka=$data;
	    }

	    function set_tgl_tutup($data) {
	        $this->tgl_tutup=$data;
	    }

	    function set_keterangan($data) {
	        $this->keterangan=$data;
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