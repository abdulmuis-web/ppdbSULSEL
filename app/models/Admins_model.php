<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class admins_model extends CI_Model{

		private $admin_id,$username,$password,$type_fk,$fullname,
				$email,$phone_number,$status,$sekolah_id,$created_by,
				$created_time,$modified_by,$modified_time,$modifiable;

		const pkey = "admin_id";
		const tbl_name = "admins";

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

		function get_admin_id() {
	        return $this->admin_id;
	    }

	    function get_username() {
	        return $this->username;
	    }

	    function get_password() {
	        return $this->password;
	    }

	    function get_type_fk() {
	        return $this->type_fk;
	    }

	    function get_fullname() {
	        return $this->fullname;
	    }

	    function get_email() {
	        return $this->email;
	    }

	    function get_phone_number() {
	        return $this->phone_number;
	    }

	    function get_status() {
	        return $this->status;
	    }

	    function get_sekolah_id() {
	        return $this->sekolah_id;
	    }

	    function get_created_by() {
	        return $this->created_by;
	    }

	    function get_created_time() {
	        return $this->created_time;
	    }

	    function get_modified_by() {
	        return $this->modified_by;
	    }

	    function get_modified_time() {
	        return $this->modified_time;
	    }

	    function get_modifiable() {
	        return $this->modifiable;
	    }



		function set_admin_id($data) {
	        $this->admin_id=$data;
	    }

	    function set_username($data) {
	        $this->username=$data;
	    }

	    function set_password($data) {
	        $this->password=$data;
	    }

	    function set_type_fk($data) {
	        $this->type_fk=$data;
	    }

	    function set_fullname($data) {
	        $this->fullname=$data;
	    }

	    function set_email($data) {
	        $this->email=$data;
	    }

	    function set_phone_number($data) {
	        $this->phone_number=$data;
	    }

	    function set_status($data) {
	        $this->status=$data;
	    }

	    function set_sekolah_id($data) {
	        $this->sekolah_id=$data;
	    }

	    function set_created_by($data) {
	        $this->created_by=$data;
	    }

	    function set_created_time($data) {
	        $this->created_time=$data;
	    }

	    function set_modified_by($data) {
	        $this->modified_by=$data;
	    }

	    function set_modified_time($data) {
	        $this->modified_time=$data;
	    }

	    function set_modifiable($data) {
	        $this->modifiable=$data;
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