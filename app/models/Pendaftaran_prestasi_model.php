<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class pendaftaran_prestasi_model extends CI_Model{

		private $prestasi_id,$id_pendaftaran,$tkt_kejuaraan_id,$bdg_kejuaraan_id,$nm_kejuaraan,
				$no_sertifikat,$penyelenggara,$thn_kejuaraan,$peringkat,$status;

		const pkey = "prestasi_id";
		const tbl_name = "pendaftaran_prestasi";

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

		function get_no_sertifikat() {
	        return $this->no_sertifikat;
	    }

	    function get_status() {
	        return $this->status;
	    }

		function get_prestasi_id() {
	        return $this->prestasi_id;
	    }

	    function get_id_pendaftaran() {
	        return $this->id_pendaftaran;
	    }

	    function get_tkt_kejuaraan_id() {
	        return $this->tkt_kejuaraan_id;
	    }

	    function get_bdg_kejuaraan_id() {
	        return $this->bdg_kejuaraan_id;
	    }

	    function get_nm_kejuaraan() {
	        return $this->nm_kejuaraan;
	    }

	    function get_penyelenggara() {
	        return $this->penyelenggara;
	    }

	    function get_thn_kejuaraan() {
	        return $this->thn_kejuaraan;
	    }

	    function get_peringkat() {
	        return $this->peringkat;
	    }


		
		function set_no_sertifikat($data) {
	        $this->no_sertifikat=$data;
	    }

	    function set_status($data) {
	        $this->status=$data;
	    }

		function set_prestasi_id($data) {
	        $this->prestasi_id=$data;
	    }

	    function set_id_pendaftaran($data) {
	        $this->id_pendaftaran=$data;
	    }

	    function set_tkt_kejuaraan_id($data) {
	        $this->tkt_kejuaraan_id=$data;
	    }

	    function set_bdg_kejuaraan_id($data) {
	        $this->bdg_kejuaraan_id=$data;
	    }

	    function set_nm_kejuaraan($data) {
	        $this->nm_kejuaraan=$data;
	    }

	    function set_penyelenggara($data) {
	        $this->penyelenggara=$data;
	    }

	    function set_thn_kejuaraan($data) {
	        $this->thn_kejuaraan=$data;
	    }

	    function set_peringkat($data) {
	        $this->peringkat=$data;
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