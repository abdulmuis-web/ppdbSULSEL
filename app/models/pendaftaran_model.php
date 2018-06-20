<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class pendaftaran_model extends CI_Model{

		private $id_pendaftaran,$nama,$jk,$tpt_lahir,$tgl_lahir,				
				$alamat,$kelurahan_id,$kecamatan_id,$dt2_id,$no_telp,
				$sekolah_asal_id,$sekolah_asal,$nm_orang_tua,$mode_un,$nil_bhs_indonesia,
				$nil_bhs_inggris,$nil_matematika,$nil_ipa,$tot_nil,$latitude,
				$longitude,$gambar,$waktu_pendaftaran,$status,$no_pendaftaran,$no_seri,$passphrase,$show_passphrase;

		const pkey = "id_pendaftaran";
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
					WHERE id_pendaftaran='".$id."'";

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
		

	    function get_mode_un() {
	        return $this->mode_un;
	    }

	    function get_passphrase() {
	        return $this->passphrase;
	    }

	    function get_show_passphrase() {
	        return $this->show_passphrase;
	    }

	    function get_sekolah_asal() {
	        return $this->sekolah_asal;
	    }

		function get_id_pendaftaran() {
	        return $this->id_pendaftaran;
	    }

	    function get_no_pendaftaran() {
	        return $this->no_pendaftaran;
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

	    function get_alamat() {
	        return $this->alamat;
	    }

	    function get_kelurahan_id() {
	        return $this->kelurahan_id;
	    }

	    function get_kecamatan_id() {
	        return $this->kecamatan_id;
	    }

	    function get_dt2_id() {
	        return $this->dt2_id;
	    }	    

	    function get_no_telp() {
	        return $this->no_telp;
	    }

	    function get_sekolah_asal_id() {
	        return $this->sekolah_asal_id;
	    }

	    function get_nm_orang_tua() {
	        return $this->nm_orang_tua;
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

	    function get_tot_nilai() {
	        return $this->tot_nilai;
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

	    function get_no_seri() {
	        return $this->no_seri;
	    }



		function set_id_pendaftaran($data) {
	        $this->id_pendaftaran=$data;
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

	    function set_alamat($data) {
	        $this->alamat=$data;
	    }

	    function set_kelurahan_id($data) {
	        $this->kelurahan_id=$data;
	    }

	    function set_kecamatan_id($data) {
	        $this->kecamatan_id=$data;
	    }

	    function set_dt2_id($data) {
	        $this->dt2_id=$data;
	    }	    

	    function set_no_telp($data) {
	        $this->no_telp=$data;
	    }

	    function set_sekolah_asal_id($data) {
	        $this->sekolah_asal_id=$data;
	    }

	    function set_nm_orang_tua($data) {
	        $this->nm_orang_tua=$data;
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

	    function set_tot_nilai($data) {
	        $this->tot_nilai=$data;
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

	    function set_no_pendaftaran($data) {
	        $this->no_pendaftaran=$data;
	    }

	    function set_sekolah_asal($data) {
	        $this->sekolah_asal=$data;
	    }	   

	    function set_mode_un($data) {
	        $this->mode_un=$data;
	    }


	    function set_no_seri($data) {
	        $this->no_seri=$data;
	    }

	    function set_passphrase($data) {
	        $this->passphrase=$data;
	    }

	    function set_show_passphrase($data) {
	        $this->show_passphrase=$data;
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