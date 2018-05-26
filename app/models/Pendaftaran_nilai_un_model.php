<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class pendaftaran_nilai_un_model extends CI_Model{

		private $nil_id,$id_pendaftaran,$nil_pkn,$nil_bhs_indonesia,$nil_bhs_inggris,
				$nil_matematika,$nil_ipa,$nil_ips,$tot_nilai;

		const pkey = "nil_id";
		const tbl_name = "pendaftaran_nilai_un";

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


		function get_nil_id() {
	        return $this->nil_id;
	    }

	    function get_id_pendaftaran() {
	        return $this->id_pendaftaran;
	    }

	    function get_nil_pkn() {
	        return $this->nil_pkn;
	    }

	    function get_nil_bhs_indonesia() {
	        return $this->nil_bhs_indonesia;
	    }

	    function get_nil_bhs_inggris() {
	        return $this->nil_bhs_inggris;
	    }

	    function get_nil_matematika() {
	        return $this->nil_matematika;
	    }

	    function get_nil_ipa() {
	        return $this->nil_ipa;
	    }

	    function get_nil_ips() {
	        return $this->nil_ips;
	    }

	    function get_tot_nilai() {
	        return $this->tot_nilai;
	    }




		function set_nil_id($data) {
	        $this->nil_id=$data;
	    }

	    function set_id_pendaftaran($data) {
	        $this->id_pendaftaran=$data;
	    }

	    function set_nil_pkn($data) {
	        $this->nil_pkn=$data;
	    }

	    function set_nil_bhs_indonesia($data) {
	        $this->nil_bhs_indonesia=$data;
	    }

	    function set_nil_bhs_inggris($data) {
	        $this->nil_bhs_inggris=$data;
	    }

	    function set_nil_matematika($data) {
	        $this->nil_matematika=$data;
	    }

	    function set_nil_ipa($data) {
	        $this->nil_ipa=$data;
	    }

	    function set_nil_ips($data) {
	        $this->nil_ips=$data;
	    }

	    function set_tot_nilai($data) {
	        $this->tot_nilai=$data;
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