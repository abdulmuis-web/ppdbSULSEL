<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require_once APPPATH.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'Backoffice_parent.php';

	class backoffice extends Backoffice_parent{

		public $active_controller;

		function __construct(){
			parent::__construct();
			$this->active_controller = __CLASS__;			
		}

		function dashboard(){
			$this->aah->check_access();
			$this->index();
		}

		function index(){
			$this->aah->check_access();
			$this->load->model(array('ref_tipe_sekolah_model','ref_jalur_pendaftaran_model'));

			$this->global_model->reinitialize_dao();
			$dao1 = $this->global_model->get_dao();			

			$type='';
			if($this->session->userdata('admin_type_id')=='3' or $this->session->userdata('admin_type_id')=='4'){
				$type = 1;
				$sql = "SELECT (SELECT COUNT(1) FROM pendaftaran_sekolah_pilihan as x WHERE x.jalur_id=a.ref_jalur_id AND x.sekolah_id='".$this->session->userdata('sekolah_id')."') as n_pendaftaran, 
						'' as n_kuota
						FROM ref_jalur_pendaftaran as a WHERE a.ref_jalur_id=?";
			}else{
				$type = 2;
				$sql = "SELECT (SELECT COUNT(1) FROM pendaftaran_jalur_pilihan as x WHERE x.jalur_id=a.ref_jalur_id) as n_pendaftaran, 
						(SELECT SUM(jumlah_kuota) FROM pengaturan_kuota_jalur as y WHERE y.jalur_id=a.ref_jalur_id) as n_kuota
						FROM ref_jalur_pendaftaran as a WHERE a.ref_jalur_id=?";
			}

			$dao1->set_sql_with_params($sql);
			
			$this->global_model->reinitialize_dao();
			$dao2 = $this->global_model->get_dao();			

			$labelChart = "[";
			$dataChart = "[";
			$s = false;
			
			$jalur_pendaftaran_rows = $this->ref_jalur_pendaftaran_model->get_all_data();

			foreach($jalur_pendaftaran_rows as $row){
				$params = array($row['ref_jalur_id']);
				$dao1->set_sql_params($params);
				$row2 = $dao1->execute(1)->row_array();
				
				if($type==1){
					$jenis_kuota = '';
	                switch($row['ref_jalur_id']){
	                	case '1':$jenis_kuota='domisili';break;
	                	case '2':$jenis_kuota='afirmasi';break;
	                	case '3':$jenis_kuota='akademik';break;
	                	case '4':$jenis_kuota='prestasi';break;
	                	case '5':$jenis_kuota='khusus';break;
	                }

					$sql = "SELECT kuota_".$jenis_kuota." as n_kuota FROM pengaturan_kuota_sma WHERE thn_pelajaran='".$this->_SYS_PARAMS[0]."' 
							AND sekolah_id='".$this->session->userdata('sekolah_id')."'";
					$row3 = $dao2->execute(0,$sql)->row_array();
					$kuota = $row3['n_kuota'];
				}else{
					$kuota = $row2['n_kuota'];
				}
				
				$pendaftaran = $row2['n_pendaftaran'];

				$ratio = ($kuota>0?$pendaftaran/$kuota*100:0);
				$labelChart .= ($s?",":"")."'".$row['nama_jalur']."'";
				$dataChart .= ($s?",":"").number_format($ratio,3,'.',',');
				$s = true;
			}

			$labelChart .= "]";
			$dataChart .= "]";
			$data['labelChart'] = $labelChart;
			$data['dataChart'] = $dataChart;


			$tipe_sekolah_rows = $this->ref_tipe_sekolah_model->get_all_data();

			if($type==1)
			{

				$this->global_model->reinitialize_dao();
				$dao1 = $this->global_model->get_dao();

				$sql = "SELECT COUNT(1) as tot_pendaftar FROM pendaftaran_sekolah_pilihan WHERE sekolah_id='".$this->session->userdata('sekolah_id')."' 
						AND jalur_id=?";
				$this->global_model->reinitialize_dao();
				$dao2 = $this->global_model->get_dao();
				$dao2->set_sql_with_params($sql);

				$table = ($this->session->userdata('admin_type_id')=='3'?'pengaturan_kuota_sma':'pengaturan_kuota_smk');

				foreach($jalur_pendaftaran_rows as $row){
					
					$jenis_kuota = '';
	                switch($row['ref_jalur_id']){
	                	case '1':$jenis_kuota='domisili';break;
	                	case '2':$jenis_kuota='afirmasi';break;
	                	case '3':$jenis_kuota='akademik';break;
	                	case '4':$jenis_kuota='prestasi';break;
	                	case '5':$jenis_kuota='khusus';break;
	                }
	                $field = ($this->session->userdata('admin_type_id')=='3'?"kuota_".$jenis_kuota:"sum(kuota_".$jenis_kuota.")");
					$sql = "SELECT ".$field." as tot_kuota FROM ".$table." WHERE thn_pelajaran='".$this->_SYS_PARAMS[0]."' 
							AND sekolah_id='".$this->session->userdata('sekolah_id')."'";

					$row1 = $dao1->execute(0,$sql)->row_array();

					$params2 = array($row['ref_jalur_id']);
					$dao2->set_sql_params($params2);
					$row2 = $dao2->execute(1)->row_array();

	                $kuota_sekolah[$row['ref_jalur_id']] = $row1['tot_kuota'];
	                $pendaftar_sekolah[$row['ref_jalur_id']] = $row2['tot_pendaftar'];
				}
			}else{

				$sql = "SELECT SUM(CASE WHEN a.tipe_sekolah=? THEN jml_kuota else 0 END) as tot_kuota 
						FROM
						(SELECT sekolah_id,jml_kuota,'1' AS tipe_sekolah FROM pengaturan_kuota_sma 
						WHERE thn_pelajaran=?
						UNION
						SELECT DISTINCT sekolah_id, SUM(jml_kuota) AS jml_kuota, '2' AS tipe_sekolah FROM pengaturan_kuota_smk 
						WHERE thn_pelajaran=? 
						GROUP BY sekolah_id) AS a";
				
				$this->global_model->reinitialize_dao();
				$dao1 = $this->global_model->get_dao();
				$dao1->set_sql_with_params($sql);

				$sql = "SELECT COUNT(1) as tot_pendaftar FROM pendaftaran_jalur_pilihan WHERE tipe_sekolah_id=?";
				$this->global_model->reinitialize_dao();
				$dao2 = $this->global_model->get_dao();
				$dao2->set_sql_with_params($sql);

				$kuota_sekolah = array();
				$pendaftar_sekolah = array();

				foreach($tipe_sekolah_rows as $row){
					
					$params1 = array($row['ref_tipe_sklh_id'],$this->_SYS_PARAMS[0],$this->_SYS_PARAMS[0]);
					$dao1->set_sql_params($params1);
					$row1 = $dao1->execute(1)->row_array();

					$params2 = array($row['ref_tipe_sklh_id']);
					$dao2->set_sql_params($params2);
					$row2 = $dao2->execute(1)->row_array();

	                $kuota_sekolah[$row['ref_tipe_sklh_id']] = $row1['tot_kuota'];
	                $pendaftar_sekolah[$row['ref_tipe_sklh_id']] = $row2['tot_pendaftar'];
				}
			}

			$data['tipe_sekolah_rows'] = $tipe_sekolah_rows;			
			$data['jalur_pendaftaran_rows'] = $jalur_pendaftaran_rows;
			$data['kuota_sekolah'] = $kuota_sekolah;
			$data['pendaftar_sekolah'] = $pendaftar_sekolah;

			$data['active_url'] = __CLASS__;
			$this->backoffice_template->render($this->active_controller.'/home/index',$data);
		}

		function login_page(){
			$data = array();
			$this->load->view($this->active_controller.'/login',$data);
		}

		function login(){			
			$this->load->helper('mix_helper');
			
			$username = $this->security->xss_clean($this->input->post('username'));
			$password = md5($this->security->xss_clean($this->input->post('password')));
			$ip = get_ip();

			$result['status'] = $this->aah->login_process($username,$password,$ip);
			$data['result'] = $result;

			$this->load->view('backoffice/login_result',$data);

		}

		function logout(){
			$this->aah->logout_process();			
		}

		
	}

?>