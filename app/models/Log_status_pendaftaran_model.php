<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class log_status_pendaftaran_model extends CI_Model{

		private $log_status_id,$id_pendaftaran,$thn_pelajaran,$jalur_id,$status,$created_time,$user,$sekolah_id;

		const pkey = "log_status_id";
		const tbl_name = "log_status_pendaftaran";

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


		function get_log_status_id() {
	        return $this->log_status_id;
	    }

	    function get_id_pendaftaran() {
	        return $this->id_pendaftaran;
	    }

	    function get_thn_pelajaran() {
	        return $this->thn_pelajaran;
	    }

	    function get_status() {
	        return $this->status;
	    }

	    function get_jalur_id() {
	        return $this->jalur_id;
	    }

	    function get_created_time() {
	        return $this->created_time;
	    }

	    function get_user() {
	        return $this->user;
	    }

	    function get_sekolah_id() {
	        return $this->sekolah_id;
	    }



	    
	    function set_log_status_id($data) {
	        $this->log_status_id=$data;
	    }

	    function set_id_pendaftaran($data) {
	        $this->id_pendaftaran=$data;
	    }

	    function set_thn_pelajaran($data) {
	        $this->thn_pelajaran=$data;
	    }

	    function set_status($data) {
	        $this->status=$data;
	    }

	    function set_jalur_id($data) {
	        $this->jalur_id=$data;
	    }

	    function set_created_time($data) {
	        $this->created_time=$data;
	    }

	    function set_user($data) {
	        $this->user=$data;
	    }

	    function set_sekolah_id($data) {
	        $this->sekolah_id=$data;
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