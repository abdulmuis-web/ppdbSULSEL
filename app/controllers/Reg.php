<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class reg extends CI_Controller{

		public $active_controller;
		private $tipe_sekolah_rows,
				$tipe_sekolah_arr,
				$jalur_pendaftaran_rows,
				$jalur_pendaftaran_arr,
				$tabs,$tabs_view,$_SYS_PARAMS;

		function __construct(){
			
			parent::__construct();

			$this->load->library(array('public_template','DAO','session'));
			$this->load->helper('url');
			$this->load->model(array('ref_tipe_sekolah_model','ref_jalur_pendaftaran_model','global_model'));
			$this->active_controller = $this->config->item('controller_list')[1];
			
			$this->tipe_sekolah_rows = $this->ref_tipe_sekolah_model->get_all_data();		

			foreach($this->ref_tipe_sekolah_model->get_all_data() as $row){
				$this->tipe_sekolah_arr[$row['ref_tipe_sklh_id']] = $row['akronim'];
			}
			
			$this->jalur_pendaftaran_rows = $this->ref_jalur_pendaftaran_model->get_all_data();

			foreach($this->jalur_pendaftaran_rows as $row){
				$this->jalur_pendaftaran_arr[$row['ref_jalur_id']] = $row['nama_jalur'];
			}

			$this->tabs = array('Panduan','Aturan','Jadwal','Prosedur','Daftar','Hasil','Data','Kuota');
			$this->tabs_view = array('guidance','regulation','schedule','procedure','registration','result','statistic','quota');

			$this->_SYS_PARAMS = $this->global_model->get_system_params();
		}


		function stage($stage,$path='',$tab=''){
			
			
			$data['_SYS_PARAMS'] = $this->_SYS_PARAMS;
			$data['active_controller'] = $this->active_controller;
			$data['breadcrumbs'] = $this->generate_breadcrumbs($stage,$path);
			$data['jalur_pendaftaran_rows'] = $this->jalur_pendaftaran_rows;
			$data['tipe_sekolah_rows'] = $this->tipe_sekolah_rows;
			$data['stage'] = $stage;
			$data['path'] = $path;

			$this->public_template->render('reg/index.php',$data);

		}

		function generate_breadcrumbs($stage,$path='',$tab=0){
			$breadcrumbs = [
							['url'=>base_url(),'text'=>'Home','active'=>false],
							['url'=>base_url().'stage/'.$stage,'text'=>$this->tipe_sekolah_arr[$stage],'active'=>false],							
						];
			if($path==''){
				$breadcrumbs[] = ['url'=>'#','text'=>'Info Umum','active'=>true];
			}else{
				$breadcrumbs[] = ['url'=>base_url().'stage/'.$stage.'/'.$path,'text'=>$this->jalur_pendaftaran_arr[$path],'active'=>false];
				$breadcrumbs[] = ['url'=>'#','text'=>$this->tabs[$tab],'active'=>true];
			}
			return $breadcrumbs;
		}

		function content_tab_menu(){
			
			$this->load->helper('date_helper');

			$stage = (!is_null($this->input->post('stage'))?$this->input->post('stage'):'');
			$path = (!is_null($this->input->post('path'))?$this->input->post('path'):'');
			$tab_id = (!is_null($this->input->post('tab_id'))?$this->input->post('tab_id'):0);

			$data = array();

			if($tab_id==4){
				$dao = $this->global_model->get_dao();
				$sql = "SELECT a.tipe_ujian_smp,a.tpt_lahir,a.tgl_lahir,a.nm_orang_tua,a.nil_pkn,a.nil_bhs_indonesia,
						a.nil_bhs_inggris,a.nil_matematika,a.nil_ipa,a.nil_ips,a.tot_nilai,b.dt2_kd
						FROM pendaftaran as a 
						LEFT JOIN (SELECT dt2_id,dt2_kd FROM ref_dt2) as b ON (a.dt2_id=b.dt2_id)
						WHERE a.id_pendaftaran='".$this->session->userdata('nopes')."'";						
				$peserta_row = $dao->execute(0,$sql)->row_array();

				$sql = "SELECT * FROM ref_kecamatan WHERE dt2_id='".$peserta_row['dt2_kd']."'";
				$kecamatan_rows = $dao->execute(0,$sql)->result_array();

				$sql = "SELECT * FROM ref_dokumen_persyaratan";
				$dokumen_persyaratan_rows = $dao->execute(0,$sql)->result_array();

				$sql = "SELECT jml_sekolah,persen_kuota FROM pengaturan_kuota_jalur WHERE thn_pelajaran='".$this->_SYS_PARAMS[0]."' AND jalur_id='".$path."'";				
				$kuota_jalur_row = $dao->execute(0,$sql)->row_array();

				$data['peserta_row'] = $peserta_row;
				$data['kecamatan_rows'] = $kecamatan_rows;
				$data['dokumen_persyaratan_rows'] = $dokumen_persyaratan_rows;
				$data['kuota_jalur_row'] = $kuota_jalur_row;

				
			}

			$this->load->view($this->active_controller.'/'.$this->tabs_view[$tab_id],$data);
		}

		function get_village_destSchool(){
			$district = $this->input->post('district');
			$path_quota = $this->input->post('path_quota');

			$dao = $this->global_model->get_dao();
			$kelurahan_rows = $dao->execute(0,"SELECT * FROM ref_kelurahan WHERE kecamatan_id='".$district."'")->result_array();

			$sql = "SELECT kecamatan_id FROM pengaturan_zona WHERE zona_id=(SELECT zona_id FROM pengaturan_zona WHERE kecamatan_id='".$district."')";
			$pengaturan_zona_rows = $dao->execute(0,$sql)->result_array();
			
			$sekolah_rows = array();
			if(count($pengaturan_zona_rows)>0)
			{
				$sql = "SELECT sekolah_id,nama_sekolah FROM sekolah WHERE ";
				$s = false;
				foreach($pengaturan_zona_rows as $row){
					$sql .= ($s?" OR":"")." kecamatan_id='".$row['kecamatan_id']."'";
					$s = true;
				}				
				$sekolah_rows = $dao->execute(0,$sql)->result_array();				
			}			

			$data['kelurahan_rows'] = $kelurahan_rows;
			$data['sekolah_rows'] = $sekolah_rows;
			$data['type'] = (!is_null($this->input->post('type'))?$this->input->post('type'):'0');
			$data['district'] = $district;
			$data['path_quota'] = $path_quota;

			
			$this->load->view($this->active_controller.'/villages_and_destSchool',$data);

		}


	}
?>