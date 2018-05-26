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
			$controller_list = $this->config->item('controller_list');
			$this->active_controller = $controller_list[1];
			
			$this->tipe_sekolah_rows = $this->ref_tipe_sekolah_model->get_all_data();		

			foreach($this->ref_tipe_sekolah_model->get_all_data() as $row){
				$this->tipe_sekolah_arr[$row['ref_tipe_sklh_id']] = $row['akronim'];
			}
			
			$this->jalur_pendaftaran_rows = $this->ref_jalur_pendaftaran_model->get_all_data();

			foreach($this->jalur_pendaftaran_rows as $row){
				$this->jalur_pendaftaran_arr[$row['ref_jalur_id']] = $row['nama_jalur'];
			}

			$this->tabs = array('Panduan','Aturan','Jadwal','Prosedur','Daftar','Hasil','Data','Kuota');
			$this->tabs_view = array('guidance','regulation','schedule','procedure','registration','result','statistic','quota','registration_data');

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
			$breadcrumbs = array(
							array('url'=>base_url(),'text'=>'Home','active'=>false),
							array('url'=>base_url().'stage/'.$stage,'text'=>$this->tipe_sekolah_arr[$stage],'active'=>false),
						);
			if($path==''){
				$breadcrumbs[] = array('url'=>'#','text'=>'Info Umum','active'=>true);
			}else{
				$breadcrumbs[] = array('url'=>base_url().'stage/'.$stage.'/'.$path,'text'=>$this->jalur_pendaftaran_arr[$path],'active'=>false);
				$breadcrumbs[] = array('url'=>'#','text'=>$this->tabs[$tab],'active'=>true);
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

				if(!is_null($this->session->userdata('nopes')))
				{
					$dao = $this->global_model->get_dao();
					$nopes = $this->session->userdata('nopes');

					$sql = "SELECT a.tipe_ujian_smp,a.tpt_lahir,a.tgl_lahir,a.nm_orang_tua,a.nil_pkn,a.nil_bhs_indonesia,
							a.nil_bhs_inggris,a.nil_matematika,a.nil_ipa,a.nil_ips,a.tot_nilai,a.dt2_id,
							a.status,a.no_pendaftaran,b.dt2_kd
							FROM pendaftaran as a 
							LEFT JOIN (SELECT dt2_id,dt2_kd FROM ref_dt2) as b ON (a.dt2_id=b.dt2_id)
							WHERE a.id_pendaftaran='".$nopes."'";

					$peserta_row = $dao->execute(0,$sql)->row_array();
					
					if($peserta_row['status']=='0')
					{
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

						$bidang_kejuaraan_opts = "<option value=''></option>";

						if($path==4){
							$tingkat_kejuaraan_rows = $dao->execute(0,"SELECT * FROM ref_tingkat_kejuaraan")->result_array();
							$bidang_kejuaraan_rows = $dao->execute(0,"SELECT * FROM ref_bidang_kejuaraan")->result_array();					

							foreach($bidang_kejuaraan_rows as $row){
								$bidang_kejuaraan_opts .= "<option value='".$row['ref_bdg_kejuaraan_id']."'>".$row['bidang_kejuaraan']."</option>";
							}

							$data['tingkat_kejuaraan_rows'] = $tingkat_kejuaraan_rows;
							$data['tingkat_kejuaraan_rows'] = $tingkat_kejuaraan_rows;					
						}

						$data['bidang_kejuaraan_opts'] = $bidang_kejuaraan_opts;
					}else{

						$sql = "SELECT a.id_pendaftaran,a.nama,a.jk,e.nm_sekolah as sekolah_asal,
								a.alamat,b.nama_kecamatan,c.nama_dt2,d.nama_jalur,
								d.nama_tipe_sekolah,d.akronim,d.nama_zona,a.no_pendaftaran 
								FROM pendaftaran as a 
								LEFT JOIN ref_kecamatan as b ON (a.kecamatan_id=b.kecamatan_id) 
								LEFT JOIN ref_dt2 as c ON (a.dt2_id=c.dt2_id) 
								LEFT JOIN (SELECT w.id_pendaftaran,x.nama_jalur,y.nama_tipe_sekolah,y.akronim,z.nama_zona FROM pendaftaran_jalur_pilihan as w 
									LEFT JOIN ref_jalur_pendaftaran as x ON (w.jalur_id=x.ref_jalur_id) 
									LEFT JOIN ref_tipe_sekolah as y ON (w.tipe_sekolah_id=y.ref_tipe_sklh_id) 
									LEFT JOIN zona_wilayah as z ON (w.zona_id=z.zona_id)) as d ON (a.id_pendaftaran=d.id_pendaftaran) 
								LEFT JOIN sekolah_asal as e ON (a.sekolah_asal_id=e.kd_sekolah)
								WHERE a.id_pendaftaran='".$nopes."';";

						$registrasi_row = $dao->execute(0,$sql)->row_array();


						$sql = "SELECT b.nama_sekolah FROM pendaftaran_sekolah_pilihan as a LEFT JOIN sekolah as b ON (a.sekolah_id=b.sekolah_id) 
								WHERE id_pendaftaran='".$nopes."'";
						$sekolah_pilihan_rows = $dao->execute(0,$sql)->result_array();
						$sekolah_pilihan_arr = array();
						foreach($sekolah_pilihan_rows as $row){
							$sekolah_pilihan_arr[] = $row['nama_sekolah'];
						}

						$data['no_peserta'] = $registrasi_row['id_pendaftaran'];
						$data['nama'] = $registrasi_row['nama'];
						$data['jk'] = $registrasi_row['jk'];
						$data['sekolah_asal'] = $registrasi_row['sekolah_asal'];;
						$data['alamat'] = $registrasi_row['alamat'];;
						$data['kecamatan'] = $registrasi_row['nama_kecamatan'];;
						$data['nm_dt2'] = $registrasi_row['nama_dt2'];
						$data['sekolah_pilihan_arr'] = $sekolah_pilihan_arr;
						$data['jalur_pendaftaran']['nama_jalur'] = $registrasi_row['nama_jalur'];
						$data['tipe_sekolah'] = array('nama_tipe_sekolah'=>$registrasi_row['nama_tipe_sekolah'],'akronim'=>$registrasi_row['akronim']);
						$data['nm_zona'] = $registrasi_row['nama_zona'];
						$data['no_registrasi'] = $registrasi_row['no_pendaftaran'];

					}

					$view = $peserta_row['status']=='0'?$this->tabs_view[$tab_id]:$this->tabs_view[8];
				}else{
					$view = "warning";
				}
			}else{
				$view = $this->tabs_view[$tab_id];
			}

			$data['stage'] = $stage;
			$data['path'] = $path;
			$data['tab_id'] = $tab_id;
		
			$this->load->view($this->active_controller.'/'.$view,$data);
		}

		function get_village_destSchool(){
			$district = explode('_',$this->input->post('district'));
			$stage = $this->input->post('stage');
			$path_quota = $this->input->post('path_quota');

			$dao = $this->global_model->get_dao();
			
			// $kelurahan_rows = $dao->execute(0,"SELECT * FROM ref_kelurahan WHERE kecamatan_id='".$district[0]."'")->result_array();

			$sql = "SELECT a.kecamatan_id,a.zona_id,b.nama_zona FROM pengaturan_zona as a LEFT JOIN zona_wilayah as b ON (a.zona_id=b.zona_id)
					WHERE a.zona_id=(SELECT zona_id FROM pengaturan_zona WHERE kecamatan_id='".$district[0]."')";
			$pengaturan_zona_rows = $dao->execute(0,$sql)->result_array();
			
			$zona = array();
			$sekolah_rows = array();
			if(count($pengaturan_zona_rows)>0)
			{
				$sql = "SELECT sekolah_id,nama_sekolah FROM sekolah WHERE tipe_sekolah_id='".$stage."' AND (";
				$s = false;
				foreach($pengaturan_zona_rows as $row){
					if(!$s) $zona = array($row['zona_id'],$row['nama_zona']);
					$sql .= ($s?" OR ":"")." kecamatan_id='".$row['kecamatan_id']."'";					
					$s = true;
				}
				$sql .=")";
				
				$sekolah_rows = $dao->execute(0,$sql)->result_array();				
			}

			// $data['kelurahan_rows'] = $kelurahan_rows;
			$data['sekolah_rows'] = $sekolah_rows;
			$data['type'] = (!is_null($this->input->post('type'))?$this->input->post('type'):'0');
			$data['district'] = $district[0];
			$data['path_quota'] = $path_quota;
			$data['zona'] = $zona;

			$this->load->view($this->active_controller.'/villages_and_destSchool',$data);

		}

		function submit_reg(){

			$this->load->model(array('pendaftaran_model','pendaftaran_dokumen_kelengkapan_model','pendaftaran_jalur_pilihan_model','pendaftaran_sekolah_pilihan_model',
									 'pendaftaran_nilai_un_model','pendaftaran_prestasi_model','log_status_pendaftaran_model'));

			$tipe_sekolah = $this->input->post('input_tipe_sekolah');
			$jalur_pendaftaran = $this->input->post('input_jalur_pendaftaran');
			$no_peserta = $this->input->post('input_no_peserta');
			$nama = $this->input->post('input_nama');
			$jk = $this->input->post('input_jk');
			$sekolah_asal = $this->input->post('input_sekolah_asal');
			$alamat = $this->input->post('input_alamat');
			$nm_dt2 = $this->input->post('input_dt2');			
			$dt2_id = $this->input->post('input_dt2_id');

			$x_kecamatan = explode('_',$this->security->xss_clean($this->input->post('input_kecamatan')));
			$kecamatan_id = $x_kecamatan[0];
			$nm_kecamatan = $x_kecamatan[1];

			$no_telp = $this->security->xss_clean($this->input->post('input_no_telp'));

			$jml_sekolah = $this->input->post('input_jml_sekolah');
			$n_berkas = $this->input->post('input_n_berkas');

			$nil_pkn = $this->input->post('input_nil_pkn');
			$nil_bhs_indonesia = $this->input->post('input_nil_bhs_indonesia');
			$nil_bhs_inggris = $this->input->post('input_nil_bhs_inggris');
			$nil_matematika = $this->input->post('input_nil_matematika');
			$nil_ipa = $this->input->post('input_nil_ipa');
			$nil_ips = $this->input->post('input_nil_ips');
			$tot_nilai = $this->input->post('input_tot_nilai');

			//begin transaction

			$this->db->trans_begin();

			$dao = $this->global_model->get_dao();

			$no_registrasi = $this->generate_regnumb($dt2_id,$tipe_sekolah,$jalur_pendaftaran);

			//update pendaftaran
			$m = $this->pendaftaran_model;
			$m->set_no_telp($no_telp);
			$m->set_kecamatan_id($kecamatan_id);
			$m->set_waktu_pendaftaran(date('Y-m-d H:i:s'));
			$m->set_status('1');
			$m->set_no_pendaftaran($no_registrasi);
						
			$result = $dao->update($m,array('id_pendaftaran'=>$no_peserta));
			if(!$result){
				$this->db->trans_rollback();
				return 'failed';
			}

			//insert pendaftaran_jalur_pilihan
			$m = $this->pendaftaran_jalur_pilihan_model;
			$m->set_id_pendaftaran($no_peserta);
			$m->set_jalur_id($jalur_pendaftaran);
			$m->set_tipe_sekolah_id($tipe_sekolah);			

			$result = $dao->insert($m);
			if(!$result){
				$this->db->trans_rollback();
				return 'failed';
			}


			//insert pendaftaran_sekolah_pilihan
			$sekolah_pilihan_arr = array();
			$m = $this->pendaftaran_sekolah_pilihan_model;
			$m->set_id_pendaftaran($no_peserta);
			for($i=1;$i<=$jml_sekolah;$i++){
				$sekolah_pilihan = $this->security->xss_clean($this->input->post('input_sekolah_tujuan'.$i));
				if($sekolah_pilihan!='')
				{
					$x_sekolah_pilihan = explode('_',$sekolah_pilihan);
					$m->set_sekolah_id($x_sekolah_pilihan[0]);

					$sekolah_pilihan_arr[] = $x_sekolah_pilihan[1];

					$result = $dao->insert($m);
					if(!$result){
						$this->db->trans_rollback();
						return 'failed';
					}
				}
			}

			//insert pendaftaran_dokumen_kelengkapan
			$m = $this->pendaftaran_dokumen_kelengkapan_model;
			$m->set_id_pendaftaran($no_peserta);
			$m->set_status('0');
			for($i=1;$i<=$n_berkas;$i++){
				if(!is_null($this->input->post('berkas'.$i))){

					$berkas = $this->input->post('berkas'.$i);
					$m->set_dokumen($berkas);
					$result = $dao->insert($m);
					if(!$result){
						$this->db->trans_rollback();
						return 'failed';
					}

				}
			}

			//insert pendaftaran_nilai_un
			$m = $this->pendaftaran_nilai_un_model;
			$m->set_id_pendaftaran($no_peserta);
			$m->set_nil_pkn($nil_pkn);
			$m->set_nil_bhs_indonesia($nil_bhs_indonesia);
			$m->set_nil_bhs_inggris($nil_bhs_inggris);
			$m->set_nil_matematika($nil_matematika);
			$m->set_nil_ipa($nil_ipa);
			$m->set_nil_ips($nil_ips);
			$m->set_tot_nilai($tot_nilai);
			$result = $dao->insert($m);
			if(!$result){
				$this->db->trans_rollback();
				return 'failed';
			}


			//insert pendaftaran_prestasi
			if($jalur_pendaftaran=='4'){

				$n_tingkat_kejuaraan = $this->input->post('input_n_tingkat_kejuaraan');

				$m = $this->pendaftaran_prestasi_model;
				$m->set_id_pendaftaran($no_peserta);

				for($i=1;$i<=$n_tingkat_kejuaraan;$i++){
					if(!is_null($this->input->post('tingkat_kejuaraan'.$i))){

						$tingkat_kejuaraan = $this->input->post('tingkat_kejuaraan'.$i);
						$n_prestasi = $this->input->post('input_n_prestasi');
						for($j=1;$j<=$n_prestasi;$j++){

							$bidang = $this->input->post('bidang'.$i.'_'.$j);
							$nm_kejuaraan = $this->input->post('nm_kejuaraan'.$i.'_'.$j);
							$penyelenggara = $this->input->post('penyelenggara'.$i.'_'.$j);
							$peringkat = $this->input->post('peringkat'.$i.'_'.$j);
							$thn_kejuaraan = $this->input->post('thn_kejuaraan'.$i.'_'.$j);

							$m->set
						}

					}
				}


			}


			//insert registration log
			$m = $this->log_status_pendaftaran_model;
			$m->set_id_pendaftaran($no_peserta);
			$m->set_thn_pelajaran($this->_SYS_PARAMS[0]);
			$m->set_status('0');
			$m->set_jalur_id($jalur_pendaftaran);
			$m->set_created_time(date('Y-m-d H:i:s'));
			$result = $dao->insert($m);
			if(!$result){
				$this->db->trans_rollback();
				return 'failed';
			}

		
			$this->db->trans_commit();
			//end of transaction


			//prepare output
			$data['no_peserta'] = $no_peserta;
			$data['nama'] = $nama;
			$data['jk'] = $jk;
			$data['sekolah_asal'] = $sekolah_asal;
			$data['alamat'] = $alamat;
			$data['kecamatan'] = $nm_kecamatan;
			$data['nm_dt2'] = $nm_dt2;			
			$data['sekolah_pilihan_arr'] = $sekolah_pilihan_arr;
			$data['jalur_pendaftaran'] = $this->ref_jalur_pendaftaran_model->get_by_id($jalur_pendaftaran);
			$data['tipe_sekolah'] = $this->ref_tipe_sekolah_model->get_by_id($tipe_sekolah);
			$data['nm_zona'] = $nm_zona;
			$data['no_registrasi'] = $no_registrasi;

			$this->load->view($this->active_controller.'/'.$this->tabs_view[8],$data);

		}

		function generate_regnumb($dt2_id,$stage,$path){
			
			$new_numb = date('y').'.'.substr($dt2_id,2,2).'.'.$stage.$path;

			$dao = $this->global_model->get_dao();
			$row = $dao->execute(0,"SELECT MAX(no_pendaftaran) last_numb FROM pendaftaran WHERE no_pendaftaran LIKE '".$new_numb."%'")->row_array();

			$new_order = 1;
			if(!empty($row['last_numb'])){
				$last_order = substr($row['last_numb'],9,4);
				$new_order += $last_order;
			}

			$new_numb .= '.'.sprintf('%04s',$new_order);

			return $new_numb;
		}

		function reg_receipt_pdf($regnumb){

		}

		function reg_receipt_print($regnumb){
			
		}

	}
?>