<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class front extends CI_Controller{

		public $active_controller;

		function __construct(){
			
			parent::__construct();

			$this->load->library(array('public_template','DAO','session'));
			$this->load->helper('url');
			$this->load->model(array('ketentuan_umum_model','ref_tipe_sekolah_model','global_model','pendaftaran_model'));
			$controller_list = $this->config->item('controller_list');
			$this->active_controller = $controller_list[0];

		}

		function securimage() {
		    $lib_path = APPPATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'securimage/';
		    require_once($lib_path.'securimage.php');
			$img = new Securimage();
			$img->show(); // alternate use: $img->show('/path/to/background.jpg');
		}

		function index(){

			$this->load->helper('date_helper');
			
			$_SYS_PARAMS = $this->global_model->get_system_params();

			$data['ketentuan_umum_rows'] = $this->ketentuan_umum_model->get_all_data();            
            $data['tipe_sekolah_rows'] = $this->ref_tipe_sekolah_model->get_all_data();
            $data['_SYS_PARAMS'] = $_SYS_PARAMS;
            $data['active_controller'] = $this->active_controller;

            $dao = $this->global_model->get_dao();

            $dao->set_sql_with_params("SELECT * FROM persyaratan_pendaftaran WHERE thn_pelajaran = ? AND tipe_sklh_id = ?");
            $data['persyaratan_pendaftaran_dao'] = $dao;
            

            $this->global_model->reinitialize_dao();

            $dao = $this->global_model->get_dao();

            $sql = "SELECT b.nama_jalur,c.nama_ktg_jalur,d.tgl_buka,d.tgl_tutup,d.status as status_jadwal FROM pengaturan_kuota_jalur as a 
					LEFT JOIN ref_jalur_pendaftaran as b ON (a.jalur_id=b.ref_jalur_id)
					LEFT JOIN ref_ktg_jalur_pendaftaran as c ON (a.ktg_jalur_id=c.ktg_jalur_id)
					INNER JOIN jadwal_jalur_pendaftaran as d ON (a.jalur_id=d.jalur_id AND a.tipe_sekolah_id=d.tipe_sklh_id)
					WHERE a.thn_pelajaran=? AND a.tipe_sekolah_id=?
					ORDER BY a.jalur_id,a.ktg_jalur_id ASC";

			$dao->set_sql_with_params($sql);
            $data['jalur_pendaftaran_dao'] = $dao;

			$this->public_template->render('front/index.php',$data);
			
		}

		function login(){			
			$this->load->helper('mix_helper');
		    $lib_path = APPPATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'securimage/';
		    require_once($lib_path.'securimage.php');

			$nopes = $this->security->xss_clean($this->input->post('login_nopes'));
			// $passphrase = $this->security->xss_clean($this->input->post('login_password'));			

			$row = $this->pendaftaran_model->login($nopes);

			$result = '';

			if(!empty($row['id_pendaftaran'])){

				// $delete_show_passphrase = false;

				// if(!empty($row['no_pendaftaran'])){
					
				// 	if(empty($passphrase))
				// 	{
				// 		$result = 'ERROR: Silahkan masukkan password anda!';
				// 		goto a;
				// 	}else if($passphrase!=$row['passphrase']){
				// 		$result = 'ERROR: Password anda salah!';
				// 		goto a;
				// 	}
				// 	$delete_show_passphrase = ($row['show_passphrase']=='1');
				// }


				$captcha = $this->input->post('secure_code');
				$img = new Securimage();
				if ($img->check($captcha) == false) {
					$result = 'ERROR: Kode Keamanan salah !';
					goto a;
				}

				$dao = $this->global_model->get_dao();

				$sec1 = microtime();
			    mt_srand((double)microtime()*1000000);
			    $sec2 = mt_rand(1000,9999);

			    $session_id = md5($sec2.$sec2);

			    $user_agent = $_SERVER['HTTP_USER_AGENT'];
			    $ip = get_ip();
			    $login_time = date('Y-m-d H:i:s');
			    $session_content = "{\"nopes\":\"".$row['id_pendaftaran']."\",
		    						\"sekolah_asal\":\"".$row['sekolah_asal']."\"}";


		    	// if($delete_show_passphrase){
		    	// 	$sql = "UPDATE pendaftaran SET show_passphrase='0' WHERE id_pendaftaran='".$nopes."'";
		    	// 	$result = $dao->execute(0,$sql);
		    	// 	if(!$result){
		    	// 		$result = 'failed';
		    	// 		goto a;
		    	// 	}
		    	// }

		    	$sql = "DELETE FROM user_logins WHERE user_id='".$nopes."'";
		    	$result = $dao->execute(0,$sql);
		    	
		    	if(!$result){
		    		$result = 'failed';
		    		goto a;
		    	}

		    	$sql = "INSERT INTO user_sessions 
		    			(session_id,user_id,user_type,user_agent,ip,login_time,session_content) 
		    			VALUES('".$session_id."','".$nopes."','registrant','".$user_agent."','".$ip."','".$login_time."','".$session_content."')";
		    	$result = $dao->execute(0,$sql);

		    	if(!$result){
		    		$result = 'failed';
		    		goto a;
		    	}


		    	$time= explode(" ", microtime());
		    	$last_access= (double) $time[1];

		    	$sql = "INSERT INTO user_logins 
		    			(session_id,user_id,user_type,ip,last_access,user_agent,login_time) 
		    			VALUES('".$session_id."','".$nopes."','registrant','".$ip."','".$last_access."','".$user_agent."','".$login_time."')";
		    	$result = $dao->execute(0,$sql);

		    	if(!$result){
		    		$result = 'failed';
		    		goto a;
		    	}

				$dt_session = array(
								'nopes'=>$nopes,
							   'nama'=>$row['nama'],
							   'alamat'=>$row['alamat'],
							   'jk'=>$row['jk'],							   
							   'id_kel'=>$row['kelurahan_id'],
							   'id_kec'=>$row['kecamatan_id'],
							   'id_dt2'=>$row['dt2_id'],
							   'nm_kel'=>$row['nama_kelurahan'],
							   'nm_kec'=>$row['nama_kecamatan'],
							   'nm_dt2'=>$row['nama_dt2'],
							   'id_sklh_asal'=>$row['sekolah_asal_id'],
							   'sklh_asal'=>$row['sekolah_asal'],
							   'gambar'=>$row['gambar'],
							   'waktu_login'=>$login_time,
							  );

				$this->session->set_userdata($dt_session);				

				$result = 'success';
				
			}else{
				$result = 'failed';
			}

			a:
			$data['result'] = $result;
			$this->load->view('front/login_result',$data);

		}

		function logout(){
			
			$dao = $this->global_model->get_dao();

			$nopes = $this->session->userdata('nopes');

			$sql = "DELETE FROM user_logins WHERE user_id='".$nopes."'";
	    	$result = $dao->execute(0,$sql);	    	

			$this->session->sess_destroy();

			redirect('front/');			
		}
	}
?>