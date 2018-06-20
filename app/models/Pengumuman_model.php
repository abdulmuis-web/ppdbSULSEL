<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class pengumuman_model extends CI_Model{

		private $pengumuman_id,$judul,$deskripsi,$diposting_oleh,$waktu_posting,$status;

		const pkey = "pengumuman_id";
		const tbl_name = "pengumuman";

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

		function get_pengumuman_id() {
	        return $this->pengumuman_id;
	    }

	    function get_judul() {
	        return $this->judul;
	    }

	    function get_deskripsi() {
	        return $this->deskripsi;
	    }

	    function get_diposting_oleh() {
	        return $this->diposting_oleh;
	    }

	    function get_waktu_posting() {
	        return $this->waktu_posting;
	    }

	    function get_status() {
	        return $this->status;
	    }

	    
		
		function set_pengumuman_id($data) {
	        $this->pengumuman_id=$data;
	    }

	    function set_judul($data) {
	        $this->judul=$data;
	    }

	    function set_deskripsi($data) {
	        $this->deskripsi=$data;
	    }

	    function set_diposting_oleh($data) {
	        $this->diposting_oleh=$data;
	    }

	    function set_waktu_posting($data) {
	        $this->waktu_posting=$data;
	    }

	    function set_status($data) {
	        $this->status=$data;
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