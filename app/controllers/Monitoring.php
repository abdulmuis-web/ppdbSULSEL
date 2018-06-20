<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require_once APPPATH.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'Backoffice_parent.php';

	class monitoring extends Backoffice_parent{

		public $active_controller;

		function __construct(){
			parent::__construct();
			$this->active_controller = __CLASS__;			
		}
		
		function registration(){
			// $this->aah->check_access();
			$this->init_monitor(0);
		}

		function verification(){
			// $this->aah->check_access();
			$this->init_monitor(3);
		}

		function settlement(){
			// $this->aah->check_access();
			$this->init_monitor(5);
		}

		function init_monitor($status){
			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();
			
			$nama_sekolah = "";
			if($this->session->userdata('admin_type_id')=='3' or $this->session->userdata('admin_type_id')=='4')
			{
				$sql = "SELECT a.jalur_id,b.nama_jalur FROM pengaturan_kuota_jalur as a LEFT JOIN ref_jalur_pendaftaran as b 
					ON (a.jalur_id=b.ref_jalur_id) WHERE a.thn_pelajaran='".$this->_SYS_PARAMS[0]."' 
					AND tipe_sekolah_id='".$this->session->userdata('tipe_sekolah')."'";
				$nama_sekolah = $this->session->userdata('nama_sekolah');
			}else{
				$sql = "SELECT ref_jalur_id as jalur_id,nama_jalur FROM ref_jalur_pendaftaran";
			}

			$jalur_rows = $dao->execute(0,$sql)->result_array();
			$data['jalur_rows'] = $jalur_rows;
			$data['nama_sekolah'] = $nama_sekolah;
			$data['type'] = ($this->session->userdata('admin_type_id')=='3' || $this->session->userdata('admin_type_id')=='4'?'1':'2');
			$this->backoffice_template->monitor($this->active_controller.'/'.$this->get_folder($status).'/index',$data);
		}

		private function get_folder($status){
			$folder = '';
			switch($status){
				case '0':$folder='registration';break;
				case '3':$folder='verification';break;
				case '5':$folder='settlement';break;
			}
			return $folder;
		}

		function load_counter(){
			$jalur_id = $this->input->post('jalur_id');
			$status = $this->input->post('status');			
			$i = $this->input->post('i');

			$type = '';

			if($this->session->userdata('admin_type_id')=='3' || $this->session->userdata('admin_type_id')=='4')
			{
				$count = $this->get_count1($jalur_id,$status);
				$type = '1';
			}
			else{
				$count = $this->get_count2($jalur_id,$status);
				$type = '2';
			}

			$data['n1'] = $count[0];
			$data['n2'] = $count[1];
			$data['t'] = array_sum($count);
			$data['i'] = $i;
			$data['type'] = $type;

			$folder = $this->get_folder($status);
			$this->load->view($this->active_controller.'/'.$folder.'/content_counter',$data);
		}

		private function get_count1($jalur_id,$status){

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();

			$main_table = ($this->session->userdata('tipe_sekolah')=='1'?'pendaftaran_sekolah_pilihan':'pendaftaran_kompetensi_pilihan');

			$sql = "SELECT SUM(CASE b.jk WHEN 'L' THEN 1 ELSE 0 END) as nl,
					SUM(CASE b.jk WHEN 'P' THEN 1 ELSE 0 END) as np
					FROM ".$main_table." as a 
					LEFT JOIN (SELECT id_pendaftaran,jk FROM pendaftaran) as b ON (a.id_pendaftaran=b.id_pendaftaran) 
					WHERE a.jalur_id='".$jalur_id."' AND a.status='".$status."' AND a.sekolah_id='".$this->session->userdata('sekolah_id')."'";
			
			
			$row = $dao->execute(0,$sql)->row_array();
			return array($row['nl'],$row['np']);
		}

		private function get_count2($jalur_id,$status){

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();

			$sql = "SELECT COUNT(1) as n FROM pendaftaran_sekolah_pilihan 
					WHERE jalur_id='".$jalur_id."' AND status='".$status."'";
								
			$row1 = $dao->execute(0,$sql)->row_array();

			$sql = "SELECT COUNT(1) as n FROM pendaftaran_kompetensi_pilihan 
					WHERE jalur_id='".$jalur_id."' AND status='".$status."'";

			$row2 = $dao->execute(0,$sql)->row_array();
									
			return array($row1['n'],$row2['n']);
		}

		function counter_listener(){
			$curr_counter = $this->input->post('curr_counter');
			$jalur_id = $this->input->post('jalur_id');
			$status = $this->input->post('status');

			$n = $this->get_count($jalur_id,$status);
			
			if($n==$curr_counter)
				$n = '';

			$folder = $this->get_folder($status);

			$this->load->view($this->active_controller.'/'.$folder.'/counter',array('n'=>$n));
		}
		
	}

?>