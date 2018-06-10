<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Sekolah_model extends CI_Model{

		private $sekolah_id,$provinsi_id,$dt2_id,$kd_sekolah,$kecamatan_id,
				$tipe_sekolah_id,$nama_sekolah,$alamat,$telepon,$email,
				$latitude,$longitude;

		const pkey = "sekolah_id";
		const tbl_name = "sekolah";

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

		function get_sekolah_id(){
			return $this->sekolah_id;
		}

		function get_provinsi_id(){
			return $this->provinsi_id;
		}

		function get_dt2_id(){
			return $this->dt2_id;
		}

		function get_kd_sekolah(){
			return $this->kd_sekolah;
		}

		function get_kecamatan_id(){
			return $this->kecamatan_id;
		}

		function get_tipe_sekolah_id(){
			return $this->tipe_sekolah_id;
		}

		function get_nama_sekolah(){
			return $this->nama_sekolah;
		}

		function get_alamat(){
			return $this->alamat;
		}

		function get_telepon(){
			return $this->telepon;
		}

		function get_email(){
			return $this->email;
		}

		function get_latitude() {
	        return $this->latitude;
	    }

		function get_longitude() {
	        return $this->longitude;
	    }

		

		function set_sekolah_id($data) {
	        $this->sekolah_id=$data;
	    }

	    function set_provinsi_id($data){
			$this->provinsi_id=$data;
		}

		function set_dt2_id($data){
			$this->dt2_id=$data;
		}

		function set_kd_sekolah($data){
			$this->kd_sekolah=$data;
		}

		function set_kecamatan_id($data){
			$this->kecamatan_id=$data;
		}

		function set_tipe_sekolah_id($data){
			$this->tipe_sekolah_id=$data;
		}

		function set_nama_sekolah($data){
			$this->nama_sekolah=$data;
		}

		function set_alamat($data){
			$this->alamat=$data;
		}

		function set_telepon($data){
			$this->telepon=$data;
		}

		function set_email($data){
			$this->email=$data;
		}

	    function set_latitude($data) {
	        $this->latitude=$data;
	    }

	    function set_longitude($data) {
	        $this->longitude=$data;
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