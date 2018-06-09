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
			$this->index();
		}

		function index(){
			
			if(is_null($this->session->userdata('admin_id'))){
				redirect($this->active_controller.'/login_page');
			}
			$data['active_url'] = __CLASS__;
			$this->backoffice_template->render($this->active_controller.'/home/index',$data);

		}

		function login_page(){
			$data = array();
			$this->load->view($this->active_controller.'/login',$data);
		}

		function login(){			
			$this->load->helper('mix_helper');
			$this->load->library('admin_access_handler');

			$aah = $this->admin_access_handler;

			$username = $this->security->xss_clean($this->input->post('username'));
			$password = md5($this->security->xss_clean($this->input->post('password')));
			$ip = get_ip();

			$dao = $this->global_model->get_dao();
			$aah->initialize_dao($dao);			

			$result['status'] = $aah->login_process($username,$password,$ip);
			
			$data['result'] = $result;

			$this->load->view('backoffice/login_result',$data);

		}

		function logout(){
			$this->load->library('admin_access_handler');
			$aah = $this->admin_access_handler;
			$dao = $this->global_model->get_dao();
			$aah->initialize_dao($dao);
			$aah->logout_process();			
		}

		function verification(){
			if(is_null($this->session->userdata('admin_id'))){
				redirect($this->active_controller.'/login_page');
			}

			$kompetensi_rows = array();

			if($this->session->userdata('tipe_sekolah')=='2'){
				$dao = $this->global_model->get_dao();
				$sql = "SELECT * FROM kompetensi_smk WHERE sekolah_id='".$this->session->userdata('sekolah_id')."'";
				$kompetensi_rows = $dao->execute(0,$sql)->result_array();
			}

			$data['form_id'] = 'search_form';
			$data['api_key'] = $this->_SYS_PARAMS[3];
			$data['kompetensi_rows'] = $kompetensi_rows;
			$data['active_url'] = str_replace('::','/',__METHOD__);
			$this->backoffice_template->render($this->active_controller.'/verification/index',$data);
		}

		function settlement(){
			if(is_null($this->session->userdata('admin_id'))){
				redirect($this->active_controller.'/login_page');
			}

			$kompetensi_rows = array();

			if($this->session->userdata('tipe_sekolah')=='2'){
				$dao = $this->global_model->get_dao();
				$sql = "SELECT * FROM kompetensi_smk WHERE sekolah_id='".$this->session->userdata('sekolah_id')."'";
				$kompetensi_rows = $dao->execute(0,$sql)->result_array();
			}

			$data['form_id'] = 'search_form';
			$data['kompetensi_rows'] = $kompetensi_rows;
			$data['active_url'] = str_replace('::','/',__METHOD__);
			$this->backoffice_template->render($this->active_controller.'/settlement/index',$data);
		}		
		
		function submit_settlement(){
			$this->load->model(array('pendaftaran_model','pendaftaran_sekolah_pilihan_model','pendaftaran_kompetensi_pilihan_model'));

			$id_pendaftaran = $this->input->post('verifikasi_id_pendaftaran');
			$no_pendaftaran = $this->input->post('verifikasi_no_pendaftaran');
			$jalur_id = $this->input->post('verifikasi_jalur_id');
			$nama_jalur = $this->input->post('verifikasi_nama_jalur');
			$sekolah_id = $this->input->post('verifikasi_sekolah_id');			
			$kompetensi_id = $this->input->post('verifikasi_kompetensi_id');
			$nama = $this->input->post('verifikasi_nama');
			$jk = $this->input->post('verifikasi_jk');
			$alamat = $this->input->post('verifikasi_alamat');
			$sekolah_asal = $this->input->post('verifikasi_sekolah_asal');
			$tipe_jalur = $this->input->post('verifikasi_tipe_jalur');
			$tipe_sekolah = $this->input->post('verifikasi_tipe_sekolah');

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();

			$m1 = $this->pendaftaran_model;
			$m2 = $this->pendaftaran_sekolah_pilihan_model;
			$m3 = $this->pendaftaran_kompetensi_pilihan_model;

			$this->db->trans_begin();

			$m1->set_status('2');
			$result = $dao->update($m1,array('id_pendaftaran'=>$id_pendaftaran));
			if(!$result){
				$this->db->trans_rollback();
				die('ERROR: gagal mendaftar ulang');
			}


			$m2->set_status('5');
			$result = $dao->update($m2,array('id_pendaftaran'=>$id_pendaftaran,'sekolah_id'=>$sekolah_id));
			if(!$result){
				$this->db->trans_rollback();
				die('ERROR: gagal mendaftar ulang');
			}

			if($tipe_sekolah=='2'){
				$m3->set_status('5');
				$result = $dao->update($m3,array('id_pendaftaran'=>$id_pendaftaran,'kompetensi_id'=>$kompetensi_id));
				if(!$result){
					$this->db->trans_rollback();
					die('ERROR: gagal mendaftar ulang');
				}
			}

			$this->db->trans_commit();
			//end of transaction
			
			$data['id_pendaftaran'] = $id_pendaftaran;
			$data['no_pendaftaran'] = $no_pendaftaran;
			$data['nama'] = $nama;
			$data['jk'] = $jk;
			$data['sekolah_asal'] = $sekolah_asal;
			$data['sekolah_id'] = $sekolah_id;
			$data['kompetensi_id'] = $kompetensi_id;
			$data['tipe_sekolah'] = $tipe_sekolah;
			$data['jalur_id'] = $jalur_id;
			$data['nama_jalur'] = $nama_jalur;
			$data['alamat'] = $alamat;			

			$this->load->view($this->active_controller.'/settlement/settlement_result',$data);

		}

		function submit_verification(){

			$this->load->model(array('pendaftaran_model','pendaftaran_dokumen_kelengkapan_model','pendaftaran_sekolah_pilihan_model',
									 'pendaftaran_kompetensi_pilihan_model','pendaftaran_nilai_un_model','pendaftaran_prestasi_model',
									 'log_status_pendaftaran_model'));

			$id_pendaftaran = $this->input->post('verifikasi_id_pendaftaran');
			$no_pendaftaran = $this->input->post('verifikasi_no_pendaftaran');
			$jalur_id = $this->input->post('verifikasi_jalur_id');
			$nama_jalur = $this->input->post('verifikasi_nama_jalur');
			$sekolah_id = $this->input->post('verifikasi_sekolah_id');
			$sekolah_pilihan_ke = $this->input->post('verifikasi_sekolah_pilihan_ke');
			$kompetensi_id = $this->input->post('verifikasi_kompetensi_id');
			$nama = $this->input->post('verifikasi_nama');
			$jk = $this->input->post('verifikasi_jk');
			$alamat = $this->input->post('verifikasi_alamat');
			$sekolah_asal = $this->input->post('verifikasi_sekolah_asal');
			$tipe_jalur = $this->input->post('verifikasi_tipe_jalur');
			$tipe_sekolah = $this->input->post('verifikasi_tipe_sekolah');

			$nil_bhs_indonesia = (!is_null($this->input->post('verifikasi_nil_bhs_indonesia'))?'1':'0');
			$nil_bhs_inggris = (!is_null($this->input->post('verifikasi_nil_bhs_inggris'))?'1':'0');
			$nil_matematika = (!is_null($this->input->post('verifikasi_nil_matematika'))?'1':'0');
			$nil_ipa = (!is_null($this->input->post('verifikasi_nil_ipa'))?'1':'0');
			$tot_nilai = (!is_null($this->input->post('verifikasi_tot_nilai'))?'1':'0');
			$n_berkas = $this->input->post('verifikasi_n_berkas');
			
			$x_jarak = explode(' ',$this->security->xss_clean($this->input->post('verifikasi_jarak')));
			$jarak =  str_replace(",","",$x_jarak[0]);

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();

			$this->db->trans_begin();

			$status1 = ($tot_nilai==='1');

			$m = $this->pendaftaran_nilai_un_model;
			$m->set_status_nil_bhs_indonesia($nil_bhs_indonesia);			
			$m->set_status_nil_bhs_inggris($nil_bhs_inggris);
			$m->set_status_nil_matematika($nil_matematika);
			$m->set_status_nil_ipa($nil_ipa);

			$result = $dao->update($m,array('id_pendaftaran'=>$id_pendaftaran));
			if(!$result){
				$this->db->trans_rollback();
				die('ERROR: gagal menyimpan verifikasi');
			}


			//insert pendaftaran_dokumen_kelengkapan
			$m = $this->pendaftaran_dokumen_kelengkapan_model;			
			$status2 = true;
			for($i=1;$i<=$n_berkas;$i++){

				$berkas_id = $this->input->post('verifikasi_berkas_id'.$i);
				$status = !is_null($this->input->post('verifikasi_berkas'.$i));
				$_status = (!is_null($this->input->post('verifikasi_berkas'.$i))?'1':'2');
				$m->set_status($_status);
				$result = $dao->update($m,array('dokel_id'=>$berkas_id));
				if(!$result){
					$this->db->trans_rollback();
					die('ERROR: gagal menyimpan verifikasi');
				}

				if($status2)
				{
					$status2 = $status2 && $status;
				}
			}

			$status3 = true;
			if($jalur_id=='4'){
				$m = $this->pendaftaran_prestasi_model;
				$n_prestasi = $this->input->post('verifikasi_n_prestasi');
				$status3 = false;

				for($i=1;$i<=$n_prestasi;$i++){

					$prestasi_id = $this->input->post('verifikasi_prestasi_id'.$i);

					$status = !is_null($this->input->post('verifikasi_prestasi'.$i));
					$_status = (!is_null($this->input->post('verifikasi_prestasi'.$i))?'1':'2');
					$m->set_status($_status);
					$result = $dao->update($m,array('prestasi_id'=>$prestasi_id));
					if(!$result){
						$this->db->trans_rollback();
						die('ERROR: gagal menyimpan verifikasi');
					}

					if($status && !$status3)
					{
						$status3 = true;
					}
				}
			}


			$status_pendaftaran = (!$status1 || !$status2 || !$status3?'2':'1');

			$m = $this->pendaftaran_sekolah_pilihan_model;
			if($tipe_sekolah=='1' and $tipe_jalur=='1')			
				$m->set_jarak_sekolah($jarak);						

			$m->set_status('1');
			$m->set_status($status_pendaftaran);
			$result = $dao->update($m,array('id_pendaftaran'=>$id_pendaftaran,'sekolah_id'=>$sekolah_id));
			if(!$result){
				$this->db->trans_rollback();
				die('ERROR: gagal menyimpan verifikasi');
			}


			if($tipe_sekolah=='2'){
				$m = $this->pendaftaran_kompetensi_pilihan_model;
				$m->set_status('1');
				$m->set_status($status_pendaftaran);
				$result = $dao->update($m,array('id_pendaftaran'=>$id_pendaftaran,'kompetensi_id'=>$kompetensi_id));
				if(!$result){
					$this->db->trans_rollback();
					die('ERROR: gagal menyimpan verifikasi');
				}
			}



			//insert registration log
			$m = $this->log_status_pendaftaran_model;
			$m->set_id_pendaftaran($id_pendaftaran);
			$m->set_thn_pelajaran($this->_SYS_PARAMS[0]);
			$m->set_status($status_pendaftaran);
			$m->set_jalur_id($jalur_id);
			$m->set_created_time(date('Y-m-d H:i:s'));
			$result = $dao->insert($m);
			if(!$result){
				$this->db->trans_rollback();
				die('ERROR: gagal menyimpan verifikasi');
			}


			$this->db->trans_commit();
			//end of transaction

			$data['id_pendaftaran'] = $id_pendaftaran;
			$data['no_pendaftaran'] = $no_pendaftaran;
			$data['nama'] = $nama;
			$data['jk'] = $jk;
			$data['sekolah_asal'] = $sekolah_asal;
			$data['sekolah_id'] = $sekolah_id;
			$data['kompetensi_id'] = $kompetensi_id;
			$data['tipe_sekolah'] = $tipe_sekolah;
			$data['jalur_id'] = $jalur_id;
			$data['nama_jalur'] = $nama_jalur;
			$data['alamat'] = $alamat;
			$data['status_pendaftaran'] = $status_pendaftaran;

			$this->load->view($this->active_controller.'/verification/verification_result',$data);
			
		}

		function ranking_process(){
			
			$this->load->helper('mix_helper');
			$this->load->model(array('pendaftaran_model','pendaftaran_sekolah_pilihan_model','pendaftaran_kompetensi_pilihan_model',
									 'log_status_pendaftaran_model','hasil_seleksi_model'));
			$this->load->library('PPDB_ranking','','rank');

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();

			$id_pendaftaran = $this->input->post('ranking_id_pendaftaran');
			$sekolah_id = $this->input->post('ranking_sekolah_id');
			$kompetensi_id = $this->input->post('ranking_kompetensi_id');
			$tipe_sekolah = $this->input->post('ranking_tipe_sekolah');
			$jalur_id = $this->input->post('ranking_jalur_id');
			$nama_jalur = $this->input->post('ranking_nama_jalur');
			$no_pendaftaran = $this->input->post('ranking_no_pendaftaran');
			$nama = $this->input->post('ranking_nama');
			$jk = $this->input->post('ranking_jk');
			$sekolah_asal = $this->input->post('ranking_sekolah_asal');
			$alamat = $this->input->post('ranking_alamat');

			if($tipe_sekolah=='1')
			{
				$sql = "SELECT kuota_domisili,kuota_afirmasi,kuota_akademik,kuota_prestasi,kuota_khusus FROM pengaturan_kuota_sma
						WHERE sekolah_id='".$sekolah_id."' AND thn_pelajaran='".$this->_SYS_PARAMS[0]."'";
			}else{
				$sql = "SELECT kuota_domisili,kuota_afirmasi,kuota_akademik,kuota_prestasi,kuota_khusus FROM pengaturan_kuota_smk
						WHERE sekolah_id='".$sekolah_id."' AND kompetensi_id='".$kompetensi_id."' AND thn_pelajaran='".$this->_SYS_PARAMS[0]."'";
			}
			$kuota_row = $dao->execute(0,$sql)->row_array();

			switch($jalur_id){
				case '1':$kuota = $kuota_row['kuota_domisili'];break;
				case '2':$kuota = $kuota_row['kuota_afirmasi'];break;
				case '3':$kuota = $kuota_row['kuota_akademik'];break;
				case '4':$kuota = $kuota_row['kuota_prestasi'];break;
				case '5':$kuota = $kuota_row['kuota_khusus'];break;
				default:$kuota=0;
			}

			$this->db->trans_begin();

			$m1 = $this->hasil_seleksi_model;
			$m2 = $this->pendaftaran_sekolah_pilihan_model;
			$m3 = $this->pendaftaran_kompetensi_pilihan_model;

			$this->rank->set_dbAccess_needs($id_pendaftaran,$sekolah_id,$tipe_sekolah,$kompetensi_id,$jalur_id,$this->_SYS_PARAMS[0],$dao);
			
			$opponents = $this->rank->set_opponents(1);			
			
			$myReg = $this->rank->set_myReg(1);
			
			if(!$myReg or !$opponents){
				
				die('ERROR: gagal menetapkan peringkat');
			}
			
			if($jalur_id=='4'){

				$sql = "SELECT tkt_kejuaraan_id, peringkat FROM pendaftaran_prestasi WHERE id_pendaftaran='".$id_pendaftaran."'
						AND status='1' ORDER BY tkt_kejuaraan_id,peringkat ASC LIMIT 0,1";
				$prestasi_row = $dao->execute(0,$sql)->row_array();
				
				$this->rank->set_levelAchievement($prestasi_row['tkt_kejuaraan_id']);
				$this->rank->set_rateAchievement($prestasi_row['peringkat']);
			}

			$this->rank->process();

			$m1->set_jalur_id($jalur_id);
			$m1->set_sekolah_id($sekolah_id);
			$m1->set_tipe_sekolah_id($tipe_sekolah);
			$m1->set_kompetensi_id($kompetensi_id);
			$m1->set_thn_pelajaran($this->_SYS_PARAMS[0]);

			$result = $dao->delete($m1,array('sekolah_id'=>$sekolah_id,'kompetensi_id'=>$kompetensi_id,'jalur_id'=>$jalur_id));
			if(!$result){
				$this->db->trans_rollback();
				die('ERROR: gagal menetapkan peringkat');
			}			

			$condM2 = array('sekolah_id'=>$sekolah_id);
			if($tipe_sekolah=='2')
				$condM3 = array('kompetensi_id'=>$kompetensi_id);

			$idPendaftaran_arr = array();

			foreach($this->rank->get_rankList() as $row){

				if(!in_array($row['id_pendaftaran'],$idPendaftaran_arr))
				{
					$idPendaftaran_arr[] = $row['id_pendaftaran'];

					$hasil_id = $this->global_model->get_incrementID('hasil_id','hasil_seleksi');
					$m1->set_hasil_id($hasil_id);
					$m1->set_id_pendaftaran($row['id_pendaftaran']);
					$m1->set_pilihan_ke($row['pilihan_ke']);
					$m1->set_score($row['score']);
					$m1->set_peringkat($row['peringkat']);
					$result = $dao->insert($m1);
					if(!$result){
						$this->db->trans_rollback();
						die('ERROR: gagal menetapkan peringkat');
					}

					$condM2['id_pendaftaran'] = $row['id_pendaftaran'];
					$m2->set_status(($row['peringkat']<=$kuota?'3':'4'));
					$result = $dao->update($m2,$condM2);
					if(!$result){
						$this->db->trans_rollback();
						die('ERROR: gagal menetapkan peringkat');
					}

					if($tipe_sekolah=='2')
					{
						$condM3['id_pendaftaran'] = $row['id_pendaftaran'];
						$m3->set_status(($row['peringkat']<=$kuota?'3':'4'));
						$result = $dao->update($m3,$condM3);
						if(!$result){
							$this->db->trans_rollback();
							die('ERROR: gagal menetapkan peringkat');
						}
					}
				}
			}

			$this->db->trans_commit();

			$myRank = $this->rank->get_myRank();
			$data['id_pendaftaran'] = $id_pendaftaran;
			$data['no_pendaftaran'] = $no_pendaftaran;
			$data['nama'] = $nama;
			$data['jk'] = $jk;
			$data['sekolah_asal'] = $sekolah_asal;			
			$data['alamat'] = $alamat;
			$data['jalur'] = $nama_jalur;
			$data['peringkat'] = $myRank[0];
			$data['score'] = $myRank[1];

			$this->load->view($this->active_controller.'/verification/ranking_result',$data);

		}

		function search_verification(){
			
			$this->load->helper(array('date_helper','mix_helper'));
			$no_pendaftaran = $this->security->xss_clean($this->input->post('src_registrasi'));
			$jenis_kompetensi = $this->security->xss_clean($this->input->post('src_kompetensi'));

			$dao = $this->global_model->get_dao();

			$sql = "SELECT a.*,b.nama_kecamatan,c.nama_dt2,d.nama_jalur,d.jalur_id,d.ktg_jalur_id as tipe_jalur,
					e.nil_bhs_indonesia,e.nil_bhs_inggris,e.nil_matematika,e.nil_ipa,e.tot_nilai
					FROM pendaftaran as a 
					LEFT JOIN ref_kecamatan as b ON (a.kecamatan_id=b.kecamatan_id) 
					LEFT JOIN ref_dt2 as c ON (a.dt2_id=c.dt2_id)
					LEFT JOIN (SELECT x.id_pendaftaran,x.jalur_id,y.nama_jalur,z.ktg_jalur_id
						FROM pendaftaran_jalur_pilihan as x 
						LEFT JOIN ref_jalur_pendaftaran as y ON (x.jalur_id=y.ref_jalur_id)
						LEFT JOIN (SELECT jalur_id,ktg_jalur_id FROM pengaturan_kuota_jalur WHERE thn_pelajaran='".$this->_SYS_PARAMS[0]."' 
							AND tipe_sekolah_id='".$this->session->userdata('tipe_sekolah')."') as z ON (x.jalur_id=z.jalur_id)) as d 
					ON (a.id_pendaftaran=d.id_pendaftaran)
					LEFT JOIN pendaftaran_nilai_un as e ON (a.id_pendaftaran=e.id_pendaftaran)
					WHERE a.no_pendaftaran='".$no_pendaftaran."'";
			
			
			$pendaftaran_row = $dao->execute(0,$sql)->row_array();

			if($this->session->userdata('tipe_sekolah')=='1')
			{
				$sql = "SELECT a.id_pendaftaran,'0' as kompetensi_id,b.nama_sekolah,b.latitude,b.longitude,b.tipe_sekolah_id as tipe_sekolah,
						b.alamat as alamat_sekolah,a.sekolah_id,a.pilihan_ke,a.status
						FROM pendaftaran_sekolah_pilihan as a 
						LEFT JOIN (SELECT sekolah_id,nama_sekolah,latitude,longitude,alamat,tipe_sekolah_id FROM sekolah) as b ON (a.sekolah_id=b.sekolah_id) 
						WHERE a.id_pendaftaran='".$pendaftaran_row['id_pendaftaran']."' AND 
						a.sekolah_id='".$this->session->userdata('sekolah_id')."'";
			}else{
				$sql = "SELECT a.id_pendaftaran,a.kompetensi_id,b.nama_sekolah,b.latitude,b.longitude,
						b.alamat as alamat_sekolah,a.sekolah_id,b.tipe_sekolah_id as tipe_sekolah,
						c.nama_kompetensi,a.pilihan_ke,a.status
						FROM pendaftaran_kompetensi_pilihan as a 
						LEFT JOIN (SELECT sekolah_id,nama_sekolah,latitude,longitude,alamat,tipe_sekolah_id FROM sekolah) as b ON (a.sekolah_id=b.sekolah_id)  
						LEFT JOIN kompetensi_smk as c ON (a.kompetensi_id=c.kompetensi_id)
						WHERE a.id_pendaftaran='".$pendaftaran_row['id_pendaftaran']."' AND 
						a.kompetensi_id='".$jenis_kompetensi."'";
			}

			$sql .= " AND a.status='3'";
			$sekolah_pilihan_row = $dao->execute(0,$sql)->row_array();

			$data['pendaftaran_row']=$pendaftaran_row;
			$data['sekolah_pilihan_row']=$sekolah_pilihan_row;
			$data['form_id'] = 'settlement-form';
			
			$this->load->view($this->active_controller.'/settlement/form',$data);

		}

		function search_registration()
		{
			$error = 0;
			$this->load->helper(array('date_helper','mix_helper'));
			$no_pendaftaran = $this->security->xss_clean($this->input->post('src_registrasi'));
			$jenis_kompetensi = $this->security->xss_clean($this->input->post('src_kompetensi'));

			$dao = $this->global_model->get_dao();

			$sql = "SELECT a.*,b.nama_kecamatan,c.nama_dt2,d.nama_jalur,d.jalur_id,d.ktg_jalur_id as tipe_jalur,
					e.nil_bhs_indonesia,e.nil_bhs_inggris,e.nil_matematika,e.nil_ipa,e.tot_nilai
					FROM pendaftaran as a 
					LEFT JOIN ref_kecamatan as b ON (a.kecamatan_id=b.kecamatan_id) 
					LEFT JOIN ref_dt2 as c ON (a.dt2_id=c.dt2_id)
					LEFT JOIN (SELECT x.id_pendaftaran,x.jalur_id,y.nama_jalur,z.ktg_jalur_id
						FROM pendaftaran_jalur_pilihan as x 
						LEFT JOIN ref_jalur_pendaftaran as y ON (x.jalur_id=y.ref_jalur_id)
						LEFT JOIN (SELECT jalur_id,ktg_jalur_id FROM pengaturan_kuota_jalur WHERE thn_pelajaran='".$this->_SYS_PARAMS[0]."' 
							AND tipe_sekolah_id='".$this->session->userdata('tipe_sekolah')."') as z ON (x.jalur_id=z.jalur_id)) as d 
					ON (a.id_pendaftaran=d.id_pendaftaran)
					LEFT JOIN pendaftaran_nilai_un as e ON (a.id_pendaftaran=e.id_pendaftaran)
					WHERE a.no_pendaftaran='".$no_pendaftaran."'";
			
			$pendaftaran_row = $dao->execute(0,$sql)->row_array();
			$sekolah_pilihan_row = array();
			$dokumen_rows = array();
			$prestasi_rows = array();
			$status_urutan = true;

			if(count($pendaftaran_row)>0)
			{
				$sql = "SELECT a.*,b.nama_dokumen FROM pendaftaran_dokumen_kelengkapan as a LEFT JOIN ref_dokumen_persyaratan as b ON (a.dokumen=b.ref_dokumen_id) 
						WHERE a.id_pendaftaran='".$pendaftaran_row['id_pendaftaran']."'";
				$dokumen_rows = $dao->execute(0,$sql)->result_array();

				if($this->session->userdata('tipe_sekolah')=='1')
				{
					$sql = "SELECT a.id_pendaftaran,'0' as kompetensi_id,b.nama_sekolah,b.latitude,b.longitude,b.tipe_sekolah_id as tipe_sekolah,
							b.alamat as alamat_sekolah,a.sekolah_id,a.pilihan_ke,a.status
							FROM pendaftaran_sekolah_pilihan as a 
							LEFT JOIN (SELECT sekolah_id,nama_sekolah,latitude,longitude,alamat,tipe_sekolah_id FROM sekolah) as b ON (a.sekolah_id=b.sekolah_id) 
							WHERE a.id_pendaftaran='".$pendaftaran_row['id_pendaftaran']."' AND 
							a.sekolah_id='".$this->session->userdata('sekolah_id')."'";
				}else{
					$sql = "SELECT a.id_pendaftaran,a.kompetensi_id,b.nama_sekolah,b.latitude,b.longitude,
							b.alamat as alamat_sekolah,a.sekolah_id,b.tipe_sekolah_id as tipe_sekolah,
							c.nama_kompetensi,a.pilihan_ke,a.status
							FROM pendaftaran_kompetensi_pilihan as a 
							LEFT JOIN (SELECT sekolah_id,nama_sekolah,latitude,longitude,alamat,tipe_sekolah_id FROM sekolah) as b ON (a.sekolah_id=b.sekolah_id)  
							LEFT JOIN kompetensi_smk as c ON (a.kompetensi_id=c.kompetensi_id)
							WHERE a.id_pendaftaran='".$pendaftaran_row['id_pendaftaran']."' AND 
							a.kompetensi_id='".$jenis_kompetensi."'";
				}
				
				$sekolah_pilihan_row = $dao->execute(0,$sql)->row_array();				
				
				if($sekolah_pilihan_row['status']=='0')
				{
					if($sekolah_pilihan_row['pilihan_ke']>1){

						$prev_pilihan = $sekolah_pilihan_row['pilihan_ke']-1;
						$sql = "SELECT status FROM ".($this->session->userdata('tipe_sekolah')=='1'?'pendaftaran_sekolah_pilihan':'pendaftaran_kompetensi_pilihan')." 
								WHERE id_pendaftaran='".$sekolah_pilihan_row['id_pendaftaran']."' 
								AND pilihan_ke='".$prev_pilihan."' LIMIT 0,1";

						$row = $dao->execute(0,$sql)->row_array();
						$error = ($row['status']!='0'?($row['status']=='3'?4:0):3);

						//3:prev choise haven't been verified,4:prev choise is not failed yet
					}		

					$prestasi_rows = array();

					if($pendaftaran_row['jalur_id']=='4'){
						$sql = "SELECT a.*,b.tingkat_kejuaraan,c.bidang_kejuaraan FROM pendaftaran_prestasi as a 
								LEFT JOIN ref_tingkat_kejuaraan as b ON (a.tkt_kejuaraan_id=b.ref_tkt_kejuaraan_id)
								LEFT JOIN ref_bidang_kejuaraan as c ON (a.bdg_kejuaraan_id=c.ref_bdg_kejuaraan_id) 
								WHERE a.id_pendaftaran='".$pendaftaran_row['id_pendaftaran']."'";
						$prestasi_rows = $dao->execute(0,$sql)->result_array();

					}
				}else{
					$error = 2; //verified;
				}

			}
			else{
				$error = 1; //not found;
			}

			$data['pendaftaran_row']=$pendaftaran_row;
			$data['sekolah_pilihan_row']=$sekolah_pilihan_row;
			$data['dokumen_rows']=$dokumen_rows;
			$data['prestasi_rows']=$prestasi_rows;
			$data['status_urutan']=$status_urutan;
			$data['provinsi'] = $this->_SYS_PARAMS[2];			
			$data['form_id'] = 'verification-form';
			$data['error'] = $error;
			$this->load->view($this->active_controller.'/verification/form_wizard',$data);
		}

		function get_verification_data($type){
			$dao = $this->global_model->get_dao();
			
			$cond = " WHERE a.sekolah_id='".$this->session->userdata('sekolah_id')."'";
			if($type==1)
				$cond .= " AND (status='1' or status='2' or status='3' or status='4')";
			else
				$cond .= " AND status='5'";
			
			if($this->session->userdata('tipe_sekolah')=='1')
			{
				$sql = "SELECT a.id_pendaftaran,b.nama,b.alamat,b.sekolah_asal,b.no_pendaftaran,b.jk,b.nama_dt2
						FROM pendaftaran_sekolah_pilihan as a 
						LEFT JOIN (SELECT x.nama,x.id_pendaftaran,x.alamat,x.sekolah_asal,x.no_pendaftaran,x.jk,y.nama_dt2 FROM pendaftaran as x 
							LEFT JOIN ref_dt2 as y ON (x.dt2_id=y.dt2_id)) as b ON (a.id_pendaftaran=b.id_pendaftaran)";
			}else{
				$sql = "SELECT a.id_pendaftaran,a.kompetensi_id,b.nama,b.alamat,b.sekolah_asal,b.no_pendaftaran,b.jk,b.nama_dt2,c.nama_kompetensi
						FROM pendaftaran_kompetensi_pilihan as a 
						LEFT JOIN (SELECT x.nama,x.id_pendaftaran,x.alamat,x.sekolah_asal,x.no_pendaftaran,x.jk,y.nama_dt2 FROM pendaftaran as x 
							LEFT JOIN ref_dt2 as y ON (x.dt2_id=y.dt2_id)) as b ON (a.id_pendaftaran=b.id_pendaftaran)
						LEFT JOIN kompetensi_smk as c ON (a.kompetensi_id=c.kompetensi_id)";
			}

			$sql .= $cond;
			
			
			$result = $dao->execute(0,$sql);
			$rows = array();
			if($result)
				$rows = $result->result_array();
			return $rows;
		}

		function load_verification_list(){
			$data['tipe_sekolah'] = $this->session->userdata('tipe_sekolah');
			$data['rows'] = $this->get_verification_data(1);
			$this->load->view($this->active_controller.'/verification/list_of_data',$data);
		}

		function delete_verification(){
			$this->load->model(array('pendaftaran_kompetensi_pilihan_model','pendaftaran_sekolah_pilihan_model','hasil_seleksi_model'));
			$id_pendaftaran = $this->input->post('id_pendaftaran');
			$kompetensi_id = $this->input->post('kompetensi_id');

			$dao = $this->global_model->get_dao();

			$this->db->trans_begin();			

			if($this->session->userdata('tipe_sekolah')=='1')
			{	
				$m2 = $this->pendaftaran_sekolah_pilihan_model;			
				$cond1 = array('id_pendaftaran'=>$id_pendaftaran);
				$cond2 = array('id_pendaftaran'=>$id_pendaftaran,'sekolah_id'=>$this->session->userdata('sekolah_id'));
			}else{
				$m2 = $this->pendaftaran_kompetensi_pilihan_model;
				$cond1 = array('id_pendaftaran'=>$id_pendaftaran,'kompetensi_id'=>$kompetensi_id);
				$cond2 = $cond1;
			}

			$m1 = $this->hasil_seleksi_model;			
			$result = $dao->delete($m1,$cond1);
			if(!$result){
				$this->db->trans_rollback();
				die('failed');
			}

			$m2->set_status('0');
			$result = $dao->update($m2,$cond2);
			if(!$result){
				$this->db->trans_rollback();
				die('failed');
			}

			$this->db->trans_commit();

			$this->load_verification_list();
		}		

		function load_settlement_list(){
			$data['tipe_sekolah'] = $this->session->userdata('tipe_sekolah');
			$data['rows'] = $this->get_verification_data(2);
			$this->load->view($this->active_controller.'/settlement/list_of_data',$data);
		}

		function delete_settlement(){
			$this->load->model(array('pendaftaran_kompetensi_pilihan_model','pendaftaran_sekolah_pilihan_model'));
			$id_pendaftaran = $this->input->post('id_pendaftaran');
			$kompetensi_id = $this->input->post('kompetensi_id');

			$dao = $this->global_model->get_dao();

			$this->db->trans_begin();

			if($this->session->userdata('tipe_sekolah')=='1')
			{	
				$m = $this->pendaftaran_sekolah_pilihan_model;							
				$cond = array('id_pendaftaran'=>$id_pendaftaran,'sekolah_id'=>$this->session->userdata('sekolah_id'));
			}else{
				$m = $this->pendaftaran_kompetensi_pilihan_model;
				$cond = array('id_pendaftaran'=>$id_pendaftaran,'kompetensi_id'=>$kompetensi_id);				
			}			

			$m->set_status('3');
			$result = $dao->update($m,$cond);
			if(!$result){
				$this->db->trans_rollback();
				die('failed');
			}

			$this->db->trans_commit();

			$this->load_settlement_list();
		}
	}

?>