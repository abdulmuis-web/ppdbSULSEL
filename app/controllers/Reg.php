<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class reg extends CI_Controller{

		public $active_controller;
		private $tipe_sekolah_rows,
				$tipe_sekolah_arr,
				$jalur_pendaftaran_rows,
				$jalur_pendaftaran_arr,
				$tabs,$tabs_view;

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

			$this->tabs = ['Panduan','Aturan','Jadwal','Prosedur','Daftar','Hasil','Data','Kuota'];
			$this->tabs_view = ['guidance','regulation','schedule','procedure','registration','result','statistic','quota'];
		}


		function stage($stage,$path='',$tab=''){
			
			$_SYS_PARAMS = $this->global_model->get_system_params();
			$data['_SYS_PARAMS'] = $_SYS_PARAMS;
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
			$tab_id = $this->input->post('tab_id');
			$stage = $this->input->post('stage');
			$path = $this->input->post('path');

			$this->load->view();
		}


	}
?>