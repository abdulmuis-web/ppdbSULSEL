<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require_once APPPATH.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'Backoffice_parent.php';

	class config extends Backoffice_parent{

		public $active_controller;

		function __construct(){
			parent::__construct();
			$this->active_controller = __CLASS__;
		}

		function account(){
			$this->aah->check_access();			
			$nav_id = $this->aah->get_nav_id(__CLASS__.'/account');
			$read_access = $this->aah->check_privilege('read',$nav_id);
			$update_access = $this->aah->check_privilege('update',$nav_id);
			
			if($read_access){
				$data['form_id'] = 'account_form';	
				$data['active_url'] = str_replace('::','/',__METHOD__);
				$data['active_controller'] = $this->active_controller;
				$data['update_access'] = $update_access;				
				$this->backoffice_template->render($this->active_controller.'/account/index',$data);	
			}else{
				$this->error_403();
			}
		}

		function school_latlang(){
			$this->aah->check_access();

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();

			$data['form_id'] = 'set_schoolLatLang_form';
			$data['api_key'] = $this->_SYS_PARAMS[3];
			$data['active_url'] = str_replace('::','/',__METHOD__);
			$data['active_controller'] = $this->active_controller;
			$data['sekolah_row'] = $dao->execute(0,"SELECT alamat,latitude,longitude FROM sekolah WHERE sekolah_id='".$this->session->userdata('sekolah_id')."'")->row_array();
			$this->backoffice_template->render($this->active_controller.'/school_latlang/index',$data);	
		}

		function set_school_latlang(){
			$this->aah->check_access();

			$this->load->model(array('sekolah_model'));

			$koordinat = explode(',',$this->security->xss_clean($this->input->post('input_koordinat')));
			$alamat = $this->security->xss_clean($this->input->post('input_alamat'));

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();

			$m = $this->sekolah_model;
			$m->set_latitude($koordinat[0]);
			$m->set_longitude($koordinat[1]);
			$m->set_alamat($alamat);
			$result = $dao->update($m,array('sekolah_id'=>$this->session->userdata('sekolah_id')));
			if(!$result){
				die('failed');
			}

			$dt_session['latitude'] = $koordinat[0];
			$dt_session['longitude'] = $koordinat[1];
			$this->session->set_userdata($dt_session);

			echo 'success';

		}

		function update_account(){
			$this->aah->check_access();

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/account');
			$update_access = $this->aah->check_privilege('update',$nav_id);

			if($update_access)
			{
				$this->load->model(array('admins_model'));

				$username = $this->security->xss_clean($this->input->post('input_username'));
				$password = md5($this->security->xss_clean($this->input->post('input_password')));			

				$m = $this->admins_model;
				$this->global_model->reinitialize_dao();
				$dao = $this->global_model->get_dao();

				if(!empty($username))
					$m->set_username($username);

				$m->set_password($password);			

				$result = $dao->update($m,array('admin_id'=>$this->session->userdata('admin_id')));
				if(!$result){
					die('failed');
				}

				if(!empty($username)){
					$dt_session['username'] = $username;
					$this->session->set_userdata($dt_session);
				}

				echo 'success';
			}else{
				echo 'ERROR: anda tidak diijinkan untuk merubah data!';
			}
		}


		function get_schools(){
			$dt2_id = $this->input->post('dt2_id');

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();
			$cond = "WHERE dt2_id='".$dt2_id."'";
			$cond .= (!is_null($this->input->post('tipe_sekolah_id'))?" AND tipe_sekolah_id='".$this->input->post('tipe_sekolah_id')."'":"");
			$sql = "SELECT sekolah_id,nama_sekolah FROM sekolah ".$cond;

			$rows = $dao->execute(0,$sql)->result_array();
			$this->load->view($this->active_controller.'/management_user/school_opts.php',array('rows'=>$rows));
		}


		//MANAGEMENT USER FUNCTION PACKET
		function management_user(){
			$this->aah->check_access();

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/management_user');
			$read_access = $this->aah->check_privilege('read',$nav_id);
			$add_access = $this->aah->check_privilege('add',$nav_id);
			$update_access = $this->aah->check_privilege('update',$nav_id);
			$delete_access = $this->aah->check_privilege('delete',$nav_id);

			if($read_access){
				$data['active_url'] = str_replace('::','/',__METHOD__);
				$data['containsTable'] = true;
				
				$data['add_access'] = $add_access;
				
				$data2['update_access'] = $update_access;
				$data2['delete_access'] = $delete_access;
				$data2['rows'] = $this->get_user_data();

				$data['list_of_data'] = $this->load->view($this->active_controller.'/management_user/list_of_data',$data2,true);
				$this->backoffice_template->render($this->active_controller.'/management_user/index',$data);
			}else{
				$this->error_403();
			}
		}

		function get_user_data(){
			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();
			$cond = "WHERE ";
			
			if($this->session->userdata('admin_type_id')=='1' || $this->session->userdata('admin_type_id')=='2'){
				$cond .= "a.type_fk<>'4' or a.type_fk<>'5'";
			}else{
				$cond .= "a.type_fk='4' and a.sekolah_id='".$this->session->userdata('sekolah_id')."'";
			}			

			$sql = "SELECT a.admin_id,a.username,a.email,a.status,a.fullname,DATE_FORMAT(a.modified_time,'%d-%m-%Y %h:%i') as last_modified,
					a.modified_by,a.type_fk,b.name as tipe_user,c.nama_sekolah FROM admins as a 
					LEFT JOIN user_types as b ON (a.type_fk=b.type_id) 
					LEFT JOIN sekolah as c ON (a.sekolah_id=c.sekolah_id)
					 ".$cond;
			
			$rows = $dao->execute(0,$sql)->result_array();
			return $rows;
		}

		function load_user_form(){
			$this->aah->check_access();

			$this->load->model(array('admins_model'));
			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();
			$admin_type_id = $this->session->userdata('admin_type_id');
			$act = $this->input->post('act');

			$id_name = 'admin_id';		    

		    $m = $this->admins_model;
		    $id_value = ($act=='edit'?$this->input->post('id'):'');
		    $curr_data = $dao->get_data_by_id($act,$m,$id_value);

		    $dt2_opts = array();
		    $sekolah_opts = array();
		    $display_schoolInputContainer = 'none';
		    $attr_inputDT2Id = 'disabled';
		    $attr_inputSekolahId = 'disabled';
		    $dt2_id = "";

		    if(($act=='edit' and ($curr_data['type_fk']=='3' or $curr_data['type_fk']=='4')) or $admin_type_id=='3'){
		    	
		    	$display_schoolInputContainer = 'block';
		    	$attr_inputDT2Id = 'required';
		    	$attr_inputSekolahId = 'required';
			    
		    }

		    if($admin_type_id!='3')
		    {
		    	$userTypeSQL = "SELECT * FROM user_types WHERE type_id<>'1' and type_id<>'5'";

		    	$dt2_opts = $dao->execute(0,"SELECT * FROM ref_dt2 WHERE provinsi_id='".$this->_SYS_PARAMS[1]."'")->result_array();

		    	if($act=='edit'){

		    		$row = $dao->execute(0,"SELECT dt2_id FROM sekolah WHERE sekolah_id='".$curr_data['sekolah_id']."'")->row_array();

		    		$sql = "SELECT sekolah_id,nama_sekolah FROM sekolah 
		    				WHERE dt2_id='".$row['dt2_id']."'";

		    		$sekolah_opts = $dao->execute(0,$sql)->result_array();
		    		$dt2_id = $row['dt2_id'];
		    	}
		    }
		    else
		    {
		    	$userTypeSQL = "SELECT * FROM user_types WHERE type_id='4'";
		    	$row = $dao->execute(0,"SELECT a.sekolah_id,a.nama_sekolah,a.dt2_id,b.nama_dt2 FROM sekolah as a 
		    							LEFT JOIN ref_dt2 as b ON (a.dt2_id=b.dt2_id) WHERE a.sekolah_id='".$this->session->userdata('sekolah_id')."'")->row_array();
		    	$dt2_opts = array(array('dt2_id'=>$row['dt2_id'],'nama_dt2'=>$row['nama_dt2']));
		    	$sekolah_opts = array(array('sekolah_id'=>$row['sekolah_id'],'nama_sekolah'=>$row['nama_sekolah']));
		    	
		    }

		    $user_type_rows = $dao->execute(0,$userTypeSQL)->result_array();
		    

		    $data['curr_data'] = $curr_data;
		    $data['active_controller'] = $this->active_controller;
		    $data['form_id'] = 'user-form';
		    $data['id_value'] = $id_value;
		    $data['user_type_rows'] = $user_type_rows;
		    $data['dt2_opts'] = $dt2_opts;
		    $data['sekolah_opts'] = $sekolah_opts;
		    $data['display_schoolInputContainer'] = $display_schoolInputContainer;
		    $data['attr_inputDT2Id'] = $attr_inputDT2Id;
		    $data['attr_inputSekolahId'] = $attr_inputSekolahId;
		    $data['admin_type_id'] = $this->session->userdata('admin_type_id');
		    $data['act'] = $act;
		    $data['dt2_id'] = $dt2_id;

			$this->load->view($this->active_controller.'/management_user/form_content',$data);
		}		

		function submit_user_data(){
			$this->aah->check_access();

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/management_user');
			$add_access = $this->aah->check_privilege('add',$nav_id);
			$update_access = $this->aah->check_privilege('update',$nav_id);
			$delete_access = $this->aah->check_privilege('delete',$nav_id);
			$act = $this->input->post('act');

			if(($act=='add' and $add_access) or ($act=='edit' and $update_access))
			{

				$this->load->model(array('admins_model'));

				$this->global_model->reinitialize_dao();
				$dao = $this->global_model->get_dao();

				
				$id = $this->input->post('id');
				$fullname = $this->security->xss_clean($this->input->post('input_fullname'));
				$type_fk = $this->security->xss_clean($this->input->post('input_type_fk'));
				$email = $this->security->xss_clean($this->input->post('input_email'));
				$phone_number = $this->security->xss_clean($this->input->post('input_phone_number'));			
				
				$username = '';
				if($act=='add' or ($act=='edit' and !is_null($this->input->post('check_username')))){
					//check username
					$username = $this->security->xss_clean($this->input->post('input_username'));
					$row = $dao->execute(0,"SELECT COUNT(1) n_row FROM admins WHERE username='".$username."'")->row_array();
					if($row['n_row']>0)
					{
						die('ERROR: username sudah terpakai');
					}
				}

				$password = '';
				if($act=='add' or ($act=='edit' and !is_null($this->input->post('check_password')))){
					$password = md5($this->security->xss_clean($this->input->post('input_password')));
				}

				$status = ($this->session->userdata('admin_type_id')!='3'?$this->input->post('input_status'):'1');
							
				$submit_user = $this->session->userdata('username');
				$submit_time = date('Y-m-d H:i:s');
				$modifiable = '1';

				$m = $this->admins_model;

				$m->set_fullname($fullname);
				$m->set_type_fk($type_fk);
				$m->set_email($email);
				$m->set_phone_number($phone_number);

				if(!empty($username))
					$m->set_username($username);

				if(!empty($password))
					$m->set_password($password);

				$m->set_status($status);

				if($type_fk=='3' or $type_fk=='4'){
					$sekolah_id = $this->security->xss_clean($this->input->post('input_sekolah_id'));
					$m->set_sekolah_id($sekolah_id);
				}

				if($act=='add')
				{
					$m->set_created_by($submit_user);
					$m->set_created_time($submit_time);
					$m->set_modifiable($modifiable);

					$result = $dao->insert($m);
					$label = 'menyimpan';
				}
				else
				{
					$m->set_modified_by($submit_user);
					$m->set_modified_time($submit_time);				

					$result = $dao->update($m,array('admin_id'=>$id));
					$label = 'merubah';
				}

				if(!$result)
				{
					die('ERROR: gagal '.$label.' data');
				}

				$data2['update_access'] = $update_access;
				$data2['delete_access'] = $delete_access;
				$data2['rows'] = $this->get_user_data();

				$this->load->view($this->active_controller.'/management_user/list_of_data',$data2);
			}else{
				echo 'ERROR: anda tidak diijinkan untuk '.($act=='add'?'menambah':'merubah').' data!';
			}
		}

		function delete_user_data(){
			$this->aah->check_access();

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/management_user');
			$update_access = $this->aah->check_privilege('update',$nav_id);
			$delete_access = $this->aah->check_privilege('delete',$nav_id);

			if($delete_access)
			{
				$this->load->model(array('admins_model'));

				$id = $this->input->post('id');

				$this->global_model->reinitialize_dao();
				$dao = $this->global_model->get_dao();

				$m = $this->admins_model;
				$result = $dao->delete($m,array('admin_id'=>$id));
				if(!$result){
					die('ERROR: gagal menghapus data');
				}

				$data2['update_access'] = $update_access;
				$data2['delete_access'] = $delete_access;
				$data2['rows'] = $this->get_user_data();

				$this->load->view($this->active_controller.'/management_user/list_of_data',$data2);

			}else{
				echo 'ERROR: anda tidak diijinkan untuk menghapus data!';
			}
		}

		//END OF MANAGEMENT USER FUNCTION PACKET


		//SCHEDULE FUNCTION PACKET
		function schedule(){
			$this->aah->check_access();

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/schedule');
			$read_access = $this->aah->check_privilege('read',$nav_id);

			if($read_access)
			{
				$this->global_model->reinitialize_dao();
				$dao = $this->global_model->get_dao();
				$data['active_url'] = str_replace('::','/',__METHOD__);				
				$data['form_id'] = "search-school-form";
				$data['active_controller'] = $this->active_controller;
				$data['containsTable'] = true;				

				$this->backoffice_template->render($this->active_controller.'/schedule/index',$data);
			}else{
				$this->error_403();
			}
		}

				
		function load_schedule1(){
			$this->load->helper(array('date_helper'));

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/schedule');
			$update_access = $this->aah->check_privilege('update',$nav_id);

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();
			
			$tipe_sekolah_rows = $dao->execute(0,"SELECT * FROM ref_tipe_sekolah")->result_array();
			
			$sql = "SELECT a.jalur_id,b.nama_jalur,c.tgl_buka,
					c.tgl_tutup,c.jadwal_id FROM pengaturan_kuota_jalur as a 
					LEFT JOIN ref_jalur_pendaftaran as b ON (a.jalur_id=b.ref_jalur_id)
					LEFT JOIN jadwal_jalur_pendaftaran as c ON (a.tipe_sekolah_id=c.tipe_sklh_id AND a.jalur_id=c.jalur_id) 
					WHERE a.thn_pelajaran='".$this->_SYS_PARAMS[0]."' AND a.tipe_sekolah_id=?";
			
			$dao->set_sql_with_params($sql);
			$jadwal_dao = $dao;

			$data['tipe_sekolah_rows'] = $tipe_sekolah_rows;
			$data2['update_access'] = $update_access;

			$list_of_data = array();
			$schedule_seq = 0;
			foreach($tipe_sekolah_rows as $row){
				$schedule_seq++;

				$params = array($row['ref_tipe_sklh_id']);
				$jadwal_dao->set_sql_params($params);
				$rows = $jadwal_dao->execute(1)->result_array();
				
				$data2['schedule_seq'] = $schedule_seq;
				$data2['rows'] = $rows;
				$data2['tipe_sekolah_id'] = $row['ref_tipe_sklh_id'];
				$list_of_data[$schedule_seq] = $this->load->view($this->active_controller.'/schedule/list_schedule1',$data2,true);
			}

			$data['list_of_data'] = $list_of_data;
			$this->load->view($this->active_controller.'/schedule/schedule1',$data);
		}

		function load_schedule2(){
			$this->load->helper(array('date_helper'));

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/schedule');
			$add_access = $this->aah->check_privilege('add',$nav_id);
			$update_access = $this->aah->check_privilege('update',$nav_id);
			$delete_access = $this->aah->check_privilege('delete',$nav_id);			
			
			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();			

			$tipe_sekolah_rows = $dao->execute(0,"SELECT * FROM ref_tipe_sekolah")->result_array();			
			
			$sql = "SELECT a.jadwal_id,b.nama_jalur,a.kegiatan,
					a.lokasi,a.tgl_buka,a.tgl_tutup,a.keterangan FROM jadwal_kegiatan_pendaftaran as a 
					LEFT JOIN ref_jalur_pendaftaran as b ON (a.jalur_id=b.ref_jalur_id)
					WHERE a.thn_pelajaran='".$this->_SYS_PARAMS[0]."' AND a.tipe_sklh_id=?";
						
			$dao->set_sql_with_params($sql);
			$jadwal_dao = $dao;

			$data['tipe_sekolah_rows'] = $tipe_sekolah_rows;			
			
			$data2['update_access'] = $update_access;
			$data2['delete_access'] = $delete_access;
			$data2['add_access'] = $add_access;

			$list_of_data = array();
			$schedule_seq = 0;
			foreach($tipe_sekolah_rows as $row){
				$schedule_seq++;

				$params = array($row['ref_tipe_sklh_id']);
				$jadwal_dao->set_sql_params($params);
				$rows = $jadwal_dao->execute(1)->result_array();
				
				$data2['schedule_seq'] = $schedule_seq;
				$data2['rows'] = $rows;
				$data2['tipe_sekolah_id'] = $row['ref_tipe_sklh_id'];
				$list_of_data[$schedule_seq] = $this->load->view($this->active_controller.'/schedule/list_schedule2',$data2,true);
			}

			$data['list_of_data'] = $list_of_data;
			$this->load->view($this->active_controller.'/schedule/schedule2',$data);
		}

		function load_schedule_form(){
			$this->load->helper('date_helper');

			$this->aah->check_access();

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();

			$type = $this->input->post('type');
			$act = $this->input->post('act');
			$id_value = ($act=='edit'?$this->input->post('id'):'');
			$schedule_seq = $this->input->post('schedule_seq');
			$tipe_sekolah_id = $this->input->post('tipe_sekolah_id');

			$data = array();
			$jalur_opts = array();
			
			if($type=='1'){				
				$this->load->model(array('jadwal_jalur_pendaftaran_model'));
				$m = $this->jadwal_jalur_pendaftaran_model;	    		
			}else{
				$this->load->model(array('jadwal_kegiatan_pendaftaran_model'));
				$m = $this->jadwal_kegiatan_pendaftaran_model;
				$jalur_opts = $dao->execute(0,"SELECT * FROM pengaturan_kuota_jalur as a LEFT JOIN ref_jalur_pendaftaran as b 
											   ON (a.jalur_id=b.ref_jalur_id) WHERE a.thn_pelajaran='".$this->_SYS_PARAMS[0]."' 
											   AND tipe_sekolah_id='".$tipe_sekolah_id."'")->result_array();
			}

			
    		$curr_data = $dao->get_data_by_id($act,$m,$id_value);
    		
    		$data['curr_data'] = $curr_data;
    		$data['form_id'] = 'form-schedule'.$type;
    		$data['id_value'] = $id_value;
    		$data['schedule_seq'] = $schedule_seq;
    		$data['act'] = $act;
			$data['active_controller'] = $this->active_controller;
			$data['jalur_opts'] = $jalur_opts;
			$data['tipe_sekolah_id'] = $tipe_sekolah_id;

			$this->load->view($this->active_controller.'/schedule/form_schedule'.$type,$data);
		}

		function submit_schedule_data(){
			$this->aah->check_access();
			$this->load->helper('date_helper');

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/schedule');
			$add_access = $this->aah->check_privilege('add',$nav_id);
			$update_access = $this->aah->check_privilege('update',$nav_id);
			$delete_access = $this->aah->check_privilege('delete',$nav_id);

			$act = $this->input->post('act');

			if(($act=='add' and $add_access) or ($act=='edit' and $update_access))
			{

				$type = $this->input->post('type');
				$id = $this->input->post('id');
				$tipe_sekolah_id = $this->input->post('tipe_sekolah_id');
				$schedule_seq = $this->input->post('schedule_seq');
				

				$this->global_model->reinitialize_dao();
				$dao = $this->global_model->get_dao();

				if($type=='1'){
					$this->load->model(array('jadwal_jalur_pendaftaran_model'));
					$tgl_buka = us_date_format($this->security->xss_clean($this->input->post('input_tgl_buka')));
					$tgl_tutup = us_date_format($this->security->xss_clean($this->input->post('input_tgl_tutup')));

					$m = $this->jadwal_jalur_pendaftaran_model;

					$m->set_tgl_buka($tgl_buka);
					$m->set_tgl_tutup($tgl_tutup);

					$result = $dao->update($m,array('jadwal_id'=>$id));
					if(!$result){
						die('ERROR: gagal merubah data');
					}


					$sql = "SELECT a.jalur_id,b.nama_jalur,c.tgl_buka,
							c.tgl_tutup,c.jadwal_id FROM pengaturan_kuota_jalur as a 
							LEFT JOIN ref_jalur_pendaftaran as b ON (a.jalur_id=b.ref_jalur_id)
							LEFT JOIN jadwal_jalur_pendaftaran as c ON (a.tipe_sekolah_id=c.tipe_sklh_id AND a.jalur_id=c.jalur_id) 
							WHERE a.thn_pelajaran='".$this->_SYS_PARAMS[0]."' AND tipe_sekolah_id='".$tipe_sekolah_id."'";

					$data['update_access'] = $update_access;
					$data['schedule_seq'] = $schedule_seq;
					$data['tipe_sekolah_id'] = $tipe_sekolah_id;
					$data['rows'] = $dao->execute(0,$sql)->result_array();

					$this->load->view($this->active_controller.'/schedule/list_schedule1',$data);

				}else{
					$this->load->model(array('jadwal_kegiatan_pendaftaran_model'));

					$jalur_id = $this->security->xss_clean($this->input->post('input_jalur_id'));
					$tipe_sekolah_id = $this->security->xss_clean($this->input->post('tipe_sekolah_id'));
					$kegiatan = $this->security->xss_clean($this->input->post('input_kegiatan'));
					$lokasi = $this->security->xss_clean($this->input->post('input_lokasi'));
					$tgl_buka = us_date_format($this->security->xss_clean($this->input->post('input_tgl_buka')));
					$tgl_tutup = us_date_format($this->security->xss_clean($this->input->post('input_tgl_tutup')));
					$keterangan = $this->security->xss_clean($this->input->post('input_keterangan'));

					$m = $this->jadwal_kegiatan_pendaftaran_model;
					$m->set_jalur_id($jalur_id);
					$m->set_kegiatan($kegiatan);
					$m->set_lokasi($lokasi);
					$m->set_tgl_buka($tgl_buka);
					$m->set_tgl_tutup($tgl_tutup);
					$m->set_keterangan($keterangan);

					if($act=='add'){
						$m->set_tipe_sklh_id($tipe_sekolah_id);
						$m->set_thn_pelajaran($this->_SYS_PARAMS[0]);
						$result = $dao->insert($m);
					}else{
						$result = $dao->update($m,array('jadwal_id'=>$id));
					}

					if(!$result)
					{
						die('ERROR: gagal '.$label.' data');
					}

					$sql = "SELECT a.jadwal_id,b.nama_jalur,a.kegiatan,
							a.lokasi,a.tgl_buka,a.tgl_tutup,a.keterangan FROM jadwal_kegiatan_pendaftaran as a 
							LEFT JOIN ref_jalur_pendaftaran as b ON (a.jalur_id=b.ref_jalur_id)
							WHERE a.thn_pelajaran='".$this->_SYS_PARAMS[0]."' AND a.tipe_sklh_id='".$tipe_sekolah_id."'";
					
					$data['add_access'] = $add_access;			
					$data['update_access'] = $update_access;
					$data['delete_access'] = $delete_access;
					$data['schedule_seq'] = $schedule_seq;
					$data['tipe_sekolah_id'] = $tipe_sekolah_id;
					$data['rows'] = $dao->execute(0,$sql)->result_array();

					$this->load->view($this->active_controller.'/schedule/list_schedule2',$data);

				}

			}else{
				echo 'ERROR: anda tidak diijinkan untuk '.($act=='add'?'menambah':'merubah').' data!';
			}
		}

		function delete_schedule_data(){
			$this->aah->check_access();

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/schedule');
			$add_access = $this->aah->check_privilege('add',$nav_id);
			$update_access = $this->aah->check_privilege('update',$nav_id);
			$delete_access = $this->aah->check_privilege('delete',$nav_id);

			if($delete_access)
			{
				$this->load->helper('date_helper');
				$type = $this->input->post('type');	
				$schedule_seq = $this->input->post('schedule_seq');
				$tipe_sekolah_id = $this->input->post('tipe_sekolah_id');
				
				$this->load->model(array('jadwal_kegiatan_pendaftaran_model'));
				$m = $this->jadwal_kegiatan_pendaftaran_model;

				$id = $this->input->post('id');

				$this->global_model->reinitialize_dao();
				$dao = $this->global_model->get_dao();

				$result = $dao->delete($m,array('jadwal_id'=>$id));

				if(!$result){
					die('ERROR: gagal menghapus data');
				}
								
				$sql = "SELECT a.jadwal_id,b.nama_jalur,a.kegiatan,
						a.lokasi,a.tgl_buka,a.tgl_tutup,a.keterangan FROM jadwal_kegiatan_pendaftaran as a 
						LEFT JOIN ref_jalur_pendaftaran as b ON (a.jalur_id=b.ref_jalur_id)
						WHERE a.thn_pelajaran='".$this->_SYS_PARAMS[0]."' AND a.tipe_sklh_id='".$tipe_sekolah_id."'";
				
				$data['add_access'] = $add_access;			
				$data['update_access'] = $update_access;
				$data['delete_access'] = $delete_access;
				$data['schedule_seq'] = $schedule_seq;
				$data['tipe_sekolah_id'] = $tipe_sekolah_id;
				$data['rows'] = $dao->execute(0,$sql)->result_array();

				$this->load->view($this->active_controller.'/schedule/list_schedule2',$data);

			}else{
				echo 'ERROR: anda tidak diijinkan untuk menghapus data!';
			}
		}

		//END OF SCHEDULE FUNCTION PACKET



		//QUOTA FUNCTION PACKET
		function quota(){
			$this->aah->check_access();

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/quota');
			$read_access = $this->aah->check_privilege('read',$nav_id);

			if($read_access)
			{
				$this->global_model->reinitialize_dao();
				$dao = $this->global_model->get_dao();
				$data['active_url'] = str_replace('::','/',__METHOD__);
				$data['form_id'] = "search-school-form";
				$data['active_controller'] = $this->active_controller;
				$data['containsTable'] = true;
				$this->backoffice_template->render($this->active_controller.'/quota/index',$data);
			}else{
				$this->error_403();
			}
		}

				
		function load_quota1(){

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/quota');
			$update_access = $this->aah->check_privilege('update',$nav_id);			
			
			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();			

			$tipe_sekolah_rows = $dao->execute(0,"SELECT * FROM ref_tipe_sekolah")->result_array();
			
			$sql = "SELECT a.*,b.nama_jalur,c.nama_ktg_jalur 
					FROM pengaturan_kuota_jalur as a 
					LEFT JOIN ref_jalur_pendaftaran as b ON (a.jalur_id=b.ref_jalur_id)
					LEFT JOIN ref_ktg_jalur_pendaftaran as c ON (a.ktg_jalur_id=c.ktg_jalur_id) 					
					WHERE a.thn_pelajaran='".$this->_SYS_PARAMS[0]."' AND a.tipe_sekolah_id=?";
			
			$dao->set_sql_with_params($sql);
			$jadwal_dao = $dao;

			$data['tipe_sekolah_rows'] = $tipe_sekolah_rows;
			$data2['update_access'] = $update_access;

			$list_of_data = array();
			$quota_seq = 0;
			foreach($tipe_sekolah_rows as $row){
				$quota_seq++;

				$params = array($row['ref_tipe_sklh_id']);
				$jadwal_dao->set_sql_params($params);
				$rows = $jadwal_dao->execute(1)->result_array();
				
				$data2['quota_seq'] = $quota_seq;
				$data2['rows'] = $rows;
				$data2['tipe_sekolah_id'] = $row['ref_tipe_sklh_id'];
				$data2['tipe_sekolah'] = $row['akronim'];
				$list_of_data[$quota_seq] = $this->load->view($this->active_controller.'/quota/list_quota1',$data2,true);
			}

			$data['list_of_data'] = $list_of_data;
			$this->load->view($this->active_controller.'/quota/quota1',$data);
		}

		function load_quota2(){
			
			$nav_id = $this->aah->get_nav_id(__CLASS__.'/quota');
			$add_access = $this->aah->check_privilege('add',$nav_id);
			$update_access = $this->aah->check_privilege('update',$nav_id);
			$delete_access = $this->aah->check_privilege('delete',$nav_id);

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();
						
			$sql = "SELECT a.pengaturan_kuota_id,a.jml_rombel,a.jml_siswa_rombel,(a.jml_rombel*a.jml_siswa_rombel) as jml_diterima,
					a.kuota_domisili,a.kuota_afirmasi,a.kuota_akademik,a.kuota_prestasi,a.kuota_khusus,a.jml_kuota,
					b.nama_sekolah FROM pengaturan_kuota_sma as a 
					LEFT JOIN sekolah as b ON (a.sekolah_id=b.sekolah_id)
					WHERE a.thn_pelajaran='".$this->_SYS_PARAMS[0]."'";			
			$rows = $dao->execute(0,$sql)->result_array();

			$data2['update_access'] = $update_access;
			$data2['delete_access'] = $delete_access;
			$data2['add_access'] = $add_access;			
			$data2['rows'] = $rows;

			$list_of_data = $this->load->view($this->active_controller.'/quota/list_quota2',$data2,true);

			$data['list_of_data'] = $list_of_data;
			$this->load->view($this->active_controller.'/quota/quota2',$data);
		}

		function load_quota3(){

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/quota');
			$add_access = $this->aah->check_privilege('add',$nav_id);
			$update_access = $this->aah->check_privilege('update',$nav_id);
			$delete_access = $this->aah->check_privilege('delete',$nav_id);

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();
						
			$sql = "SELECT a.pengaturan_kuota_id,a.jml_rombel,a.jml_siswa_rombel,(a.jml_rombel*a.jml_siswa_rombel) as jml_diterima,
					a.kuota_domisili,a.kuota_afirmasi,a.kuota_akademik,a.kuota_prestasi,a.kuota_khusus,a.jml_kuota,
					b.nama_sekolah,c.nama_kompetensi FROM pengaturan_kuota_smk as a 
					LEFT JOIN sekolah as b ON (a.sekolah_id=b.sekolah_id)
					LEFT JOIN kompetensi_smk as c ON (a.kompetensi_id=c.kompetensi_id)
					WHERE a.thn_pelajaran='".$this->_SYS_PARAMS[0]."'";

			$rows = $dao->execute(0,$sql)->result_array();

			$data2['update_access'] = $update_access;
			$data2['delete_access'] = $delete_access;
			$data2['add_access'] = $add_access;			
			$data2['rows'] = $rows;

			$list_of_data = $this->load->view($this->active_controller.'/quota/list_quota3',$data2,true);

			$data['list_of_data'] = $list_of_data;
			$this->load->view($this->active_controller.'/quota/quota2',$data);
		}

		function load_quota_form(){
			$this->load->helper('date_helper');

			$this->aah->check_access();

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();

			$type = $this->input->post('type');
			$act = $this->input->post('act');
			$id_value = ($act=='edit'?$this->input->post('id'):'');			

			$data = array();			
			
			

			if($type=='1'){				

				$quota_seq = $this->input->post('quota_seq');
				$tipe_sekolah_id = $this->input->post('tipe_sekolah_id');
				$tipe_sekolah = $this->input->post('tipe_sekolah');

				$this->load->model(array('pengaturan_kuota_jalur_model'));
				$m = $this->pengaturan_kuota_jalur_model;
				$curr_data = $dao->get_data_by_id($act,$m,$id_value);

				$sql = "SELECT SUM(jml_rombel*jml_siswa_rombel) as daya_tampung FROM pengaturan_kuota_".($tipe_sekolah_id=='1'?'sma':'smk');
				$row = $dao->execute(0,$sql)->row_array();

				$data['daya_tampung'] = $row['daya_tampung'];
				$data['tipe_sekolah_id'] = $tipe_sekolah_id;
				$data['tipe_sekolah'] = $tipe_sekolah;
				$data['quota_seq'] = $quota_seq;


			}else if($type=='2'){
				$this->load->model(array('pengaturan_kuota_sma_model'));
				$m = $this->pengaturan_kuota_sma_model;
				
				$curr_data = $dao->get_data_by_id($act,$m,$id_value);

				$dt2_id = "";
				$sekolah_opts = array();

				if($act=='edit'){
					$row = $dao->execute(0,"SELECT dt2_id FROM sekolah WHERE sekolah_id='".$curr_data['sekolah_id']."'")->row_array();
					$dt2_id = $row['dt2_id'];
					$sekolah_opts = $dao->execute(0,"SELECT sekolah_id,nama_sekolah FROM sekolah WHERE dt2_id='".$dt2_id."'")->result_array();
				}

				$data['dt2_opts'] = $dao->execute(0,"SELECT * FROM ref_dt2")->result_array();
				$data['sekolah_opts'] = $sekolah_opts;
				$data['dt2_id'] = $dt2_id;

			}else{
				$this->load->model(array('pengaturan_kuota_smk_model'));
				$m = $this->pengaturan_kuota_smk_model;
				
				$curr_data = $dao->get_data_by_id($act,$m,$id_value);

				$dt2_id = "";
				$sekolah_opts = array();

				if($act=='edit'){
					$row = $dao->execute(0,"SELECT dt2_id FROM sekolah WHERE sekolah_id='".$curr_data['sekolah_id']."'")->row_array();
					$dt2_id = $row['dt2_id'];
					$sekolah_opts = $dao->execute(0,"SELECT sekolah_id,nama_sekolah FROM sekolah WHERE dt2_id='".$dt2_id."'")->result_array();
				}

				$data['dt2_opts'] = $dao->execute(0,"SELECT * FROM ref_dt2")->result_array();
				$data['sekolah_opts'] = $sekolah_opts;
				$data['dt2_id'] = $dt2_id;
			}    	

    		$data['curr_data'] = $curr_data;
    		$data['form_id'] = 'form-quota'.$type;
    		$data['id_value'] = $id_value;
    		$data['act'] = $act;
			$data['active_controller'] = $this->active_controller;

			$this->load->view($this->active_controller.'/quota/form_quota'.$type,$data);
		}

		function submit_quota_data(){
			$this->aah->check_access();
			$this->load->helper('date_helper');

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/quota');
			$add_access = $this->aah->check_privilege('add',$nav_id);
			$update_access = $this->aah->check_privilege('update',$nav_id);
			$delete_access = $this->aah->check_privilege('delete',$nav_id);

			$act = $this->input->post('act');

			if(($act=='add' and $add_access) or ($act=='edit' and $update_access))
			{

				$type = $this->input->post('type');
				$id = $this->input->post('id');
				$tipe_sekolah_id = $this->input->post('tipe_sekolah_id');
				$tipe_sekolah = $this->input->post('tipe_sekolah');
				$quota_seq = $this->input->post('quota_seq');

				$this->global_model->reinitialize_dao();
				$dao = $this->global_model->get_dao();

				if($type=='1'){
					$this->load->model(array('pengaturan_kuota_jalur_model'));

					$jml_sekolah = str_replace(',','',$this->security->xss_clean($this->input->post('input_jml_sekolah')));
					$persen_kuota = str_replace(',','',$this->security->xss_clean($this->input->post('input_persen_kuota')));
					$jumlah_kuota = str_replace(',','',$this->security->xss_clean($this->input->post('input_jumlah_kuota')));

					$m = $this->pengaturan_kuota_jalur_model;

					$m->set_jml_sekolah($jml_sekolah);
					$m->set_persen_kuota($persen_kuota);
					$m->set_jumlah_kuota($jumlah_kuota);

					$result = $dao->update($m,array('pengaturan_kuota_id'=>$id));
					if(!$result){
						die('ERROR: gagal merubah data');
					}

					$sql = "SELECT a.*,b.nama_jalur,c.nama_ktg_jalur 
							FROM pengaturan_kuota_jalur as a 
							LEFT JOIN ref_jalur_pendaftaran as b ON (a.jalur_id=b.ref_jalur_id)
							LEFT JOIN ref_ktg_jalur_pendaftaran as c ON (a.ktg_jalur_id=c.ktg_jalur_id) 					
							WHERE a.thn_pelajaran='".$this->_SYS_PARAMS[0]."' AND a.tipe_sekolah_id='".$tipe_sekolah_id."'";

					$data['quota_seq'] = $quota_seq;
					$data['rows'] = $dao->execute(0,$sql)->result_array();
					$data['tipe_sekolah_id'] = $tipe_sekolah_id;
					$data['tipe_sekolah'] = $tipe_sekolah;
					$data['update_access'] = $update_access;
					
					$this->load->view($this->active_controller.'/quota/list_quota1',$data);

				}else if($type=='2'){
					$this->load->model(array('pengaturan_kuota_sma_model'));

					$sekolah_id = $this->security->xss_clean($this->input->post('input_sekolah_id'));
					$jml_rombel = str_replace(',','',$this->security->xss_clean($this->input->post('input_jml_rombel')));
					$jml_siswa_rombel = str_replace(',','',$this->security->xss_clean($this->input->post('input_jml_siswa_rombel')));
					$kuota_domisili = str_replace(',','',$this->security->xss_clean($this->input->post('input_kuota_domisili')));
					$kuota_afirmasi = str_replace(',','',$this->security->xss_clean($this->input->post('input_kuota_afirmasi')));
					$kuota_akademik = str_replace(',','',$this->security->xss_clean($this->input->post('input_kuota_akademik')));
					$kuota_prestasi = str_replace(',','',$this->security->xss_clean($this->input->post('input_kuota_prestasi')));
					$kuota_khusus = str_replace(',','',$this->security->xss_clean($this->input->post('input_kuota_khusus')));
					$jml_kuota = str_replace(',','',$this->security->xss_clean($this->input->post('input_jml_kuota')));

					$m = $this->pengaturan_kuota_sma_model;

					$m->set_sekolah_id($sekolah_id);
					$m->set_jml_rombel($jml_rombel);
					$m->set_jml_siswa_rombel($jml_siswa_rombel);
					$m->set_kuota_domisili($kuota_domisili);
					$m->set_kuota_afirmasi($kuota_afirmasi);
					$m->set_kuota_akademik($kuota_akademik);
					$m->set_kuota_prestasi($kuota_prestasi);
					$m->set_kuota_khusus($kuota_khusus);
					$m->set_jml_kuota($jml_kuota);

					if($act=='add'){						
						$m->set_thn_pelajaran($this->_SYS_PARAMS[0]);
						$result = $dao->insert($m);
					}else{
						$result = $dao->update($m,array('pengaturan_kuota_id'=>$id));
					}

					if(!$result)
					{
						die('ERROR: gagal '.$label.' data');
					}

					$sql = "SELECT a.pengaturan_kuota_id,a.jml_rombel,a.jml_siswa_rombel,(a.jml_rombel*a.jml_siswa_rombel) as jml_diterima,
							a.kuota_domisili,a.kuota_afirmasi,a.kuota_akademik,a.kuota_prestasi,a.kuota_khusus,a.jml_kuota,
							b.nama_sekolah FROM pengaturan_kuota_sma as a 
							LEFT JOIN sekolah as b ON (a.sekolah_id=b.sekolah_id)
							WHERE a.thn_pelajaran='".$this->_SYS_PARAMS[0]."'";

					$rows = $dao->execute(0,$sql)->result_array();

					$data['update_access'] = $update_access;
					$data['delete_access'] = $delete_access;
					$data['add_access'] = $add_access;			
					$data['rows'] = $rows;

					$this->load->view($this->active_controller.'/quota/list_quota2',$data);					
				}
				else
				{

				}

			}else{
				echo 'ERROR: anda tidak diijinkan untuk '.($act=='add'?'menambah':'merubah').' data!';
			}
		}

		function delete_quota_data(){
			$this->aah->check_access();

			$nav_id = $this->aah->get_nav_id(__CLASS__.'/schedule');
			$add_access = $this->aah->check_privilege('add',$nav_id);
			$update_access = $this->aah->check_privilege('update',$nav_id);
			$delete_access = $this->aah->check_privilege('delete',$nav_id);

			if($delete_access)
			{
				$this->load->helper('date_helper');
				$type = $this->input->post('type');	
				$id = $this->input->post('id');


				if($type=='2')
				{
					$this->load->model(array('pengaturan_kuota_sma_model'));
					$m = $this->pengaturan_kuota_sma_model;
				}else{
					$this->load->model(array('pengaturan_kuota_smk_model'));
					$m = $this->pengaturan_kuota_smk_model;
				}
				

				$this->global_model->reinitialize_dao();
				$dao = $this->global_model->get_dao();

				$result = $dao->delete($m,array('pengaturan_kuota_id'=>$id));

				if(!$result){
					die('ERROR: gagal menghapus data');
				}

				if($type=='2'){
					$sql = "SELECT a.pengaturan_kuota_id,a.jml_rombel,a.jml_siswa_rombel,(a.jml_rombel*a.jml_siswa_rombel) as jml_diterima,
							a.kuota_domisili,a.kuota_afirmasi,a.kuota_akademik,a.kuota_prestasi,a.kuota_khusus,a.jml_kuota,
							b.nama_sekolah FROM pengaturan_kuota_sma as a 
							LEFT JOIN sekolah as b ON (a.sekolah_id=b.sekolah_id)
							WHERE a.thn_pelajaran='".$this->_SYS_PARAMS[0]."'";

					$rows = $dao->execute(0,$sql)->result_array();

					$data['update_access'] = $update_access;
					$data['delete_access'] = $delete_access;
					$data['add_access'] = $add_access;			
					$data['rows'] = $rows;					
				}else{

				}

				$this->load->view($this->active_controller.'/quota/list_quota'.$type,$data);

			}else{
				echo 'ERROR: anda tidak diijinkan untuk menghapus data!';
			}
		}

		//END OF QUOTA FUNCTION PACKET
	}
?>