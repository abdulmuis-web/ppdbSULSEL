<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class pendaftaran_model extends CI_Model{

		private $nun,$nama,$jk,$tpt_lahir,$tgl_lahir,
				$no_reg_akta_lahir,$agama,$kewarganegaraan,$berkebutuhan_khusus,
				$alamat,$rt,$rw,$dusun,$kelurahan,$kecamatan,
				$kabupaten,$kode_pos,$tinggal_bersama,$no_telp,$email,
				$asal_sekolah,$alamat_asal_sekolah,$latitude,$longitude,$gambar,
				$waktu_pendaftaran,$status;

		const pkey = "nun";
		const tbl_name = "pendaftaran";

		function get_pkey(){
			return self::pkey;
		}		

		function get_tbl_name(){
			return self::tbl_name;
		}

		function login($id){
			
			$sql = "SELECT a.*,b.nama_kelurahan,c.nama_kecamatan,d.nama_dt2 FROM pendaftaran as a 
					LEFT JOIN ref_kelurahan as b ON (a.kelurahan_id=b.kelurahan_id) 
					LEFT JOIN ref_kecamatan as c ON (a.kecamatan_id=c.kecamatan_id) 
					LEFT JOIN ref_dt2 as d ON (a.dt2_id=d.dt2_id) 
					WHERE nun='".$id."'";
			
			$query = $this->db->query($sql);
			$row = $query->row_array();
			return $row;

		}

		function __construct(array $init_properties=array()){

			if(count($init_properties)>0){
				foreach($init_properties as $key=>$val){
					$this->$key = $val;
				}
			}
		}

		function get_nun() {
	        return $this->nun;
	    }


	    function get_nama() {
	        return $this->nama;
	    }

	    function get_jk() {
	        return $this->jk;
	    }

	    function get_tpt_lahir() {
	        return $this->tpt_lahir;
	    }

	    function get_tgl_lahir() {
	        return $this->tgl_lahir;
	    }

	    function get_tpt_no_reg_akta_lahir() {
	        return $this->tpt_no_reg_akta_lahir;
	    }

	    function get_agama() {
	        return $this->agama;
	    }

	    function get_kewarganegaraan() {
	        return $this->kewarganegaraan;
	    }

	    function get_berkebutuhan_khusus() {
	        return $this->berkebutuhan_khusus;
	    }

	    function get_alamat() {
	        return $this->alamat;
	    }

	    function get_rt() {
	        return $this->rt;
	    }


	    function get_rw() {
	        return $this->rw;
	    }

	    function get_dusun() {
	        return $this->dusun;
	    }

	    function get_kelurahan() {
	        return $this->kelurahan;
	    }

	    function get_kecamatan() {
	        return $this->kecamatan;
	    }

	    function get_kabupaten() {
	        return $this->kabupaten;
	    }

	    function get_kode_pos() {
	        return $this->kode_pos;
	    }

	    function get_tinggal_bersama() {
	        return $this->tinggal_bersama;
	    }

	    function get_no_telp() {
	        return $this->no_telp;
	    }

	    function get_email() {
	        return $this->email;
	    }

	    function get_asal_sekolah() {
	        return $this->asal_sekolah;
	    }

	    function get_alamat_asal_sekolah() {
	        return $this->alamat_asal_sekolah;
	    }

	    function get_latitude() {
	        return $this->latitude;
	    }

	    function get_longitude() {
	        return $this->longitude;
	    }

	    function get_gambar() {
	        return $this->gambar;
	    }

	    function get_waktu_pendaftaran() {
	        return $this->waktu_pendaftaran;
	    }

	    function get_status() {
	        return $this->status;
	    }



		function set_nun($data) {
	        $this->nun=$data;
	    }

	    function set_nama($data) {
	        $this->nama=$data;
	    }

	    function set_jk($data) {
	        $this->jk=$data;
	    }

	    function set_tpt_lahir($data) {
	        $this->tpt_lahir=$data;
	    }

	    function set_tgl_lahir($data) {
	        $this->tgl_lahir=$data;
	    }

	    function set_tpt_no_reg_akta_lahir($data) {
	        $this->tpt_no_reg_akta_lahir=$data;
	    }

	    function set_agama($data) {
	        $this->agama=$data;
	    }

	    function set_kewarganegaraan($data) {
	        $this->kewarganegaraan=$data;
	    }

	    function set_berkebutuhan_khusus($data) {
	        $this->berkebutuhan_khusus=$data;
	    }

	    function set_alamat($data) {
	        $this->alamat=$data;
	    }

	    function set_rt($data) {
	        $this->rt=$data;
	    }


	    function set_rw($data) {
	        $this->rw=$data;
	    }

	    function set_dusun($data) {
	        $this->dusun=$data;
	    }

	    function set_kelurahan($data) {
	        $this->kelurahan=$data;
	    }

	    function set_kecamatan($data) {
	        $this->kecamatan=$data;
	    }

	    function set_kabupaten($data) {
	        $this->kabupaten=$data;
	    }

	    function set_kode_pos($data) {
	        $this->kode_pos=$data;
	    }

	    function set_tinggal_bersama($data) {
	        $this->tinggal_bersama=$data;
	    }

	    function set_no_telp($data) {
	        $this->no_telp=$data;
	    }

	    function set_email($data) {
	        $this->email=$data;
	    }

	    function set_asal_sekolah($data) {
	        $this->asal_sekolah=$data;
	    }

	    function set_alamat_asal_sekolah($data) {
	        $this->alamat_asal_sekolah=$data;
	    }

	    function set_latitude($data) {
	        $this->latitude=$data;
	    }

	    function set_longitude($data) {
	        $this->longitude=$data;
	    }

	    function set_gambar($data) {
	        $this->gambar=$data;
	    }

	    function set_waktu_pendaftaran($data) {
	        $this->waktu_pendaftaran=$data;
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
	}
?>