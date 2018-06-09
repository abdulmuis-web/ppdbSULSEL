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
			if(is_null($this->session->userdata('admin_id'))){
				redirect('backoffice/login_page');
			}

			$data['form_id'] = 'account_form';	
			$data['active_url'] = str_replace('::','/',__METHOD__);
			$data['active_controller'] = $this->active_controller;
			$this->backoffice_template->render($this->active_controller.'/account/index',$data);	
		}

		function school_latlang(){
			if(is_null($this->session->userdata('admin_id'))){
				redirect('backoffice/login_page');
			}

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

		}


		//MANAGEMENT USER FUNCTION PACKET
		function management_user(){
			if(is_null($this->session->userdata('admin_id'))){
				redirect('backoffice/login_page');
			}
			$data['active_url'] = str_replace('::','/',__METHOD__);
			$data['list_of_data'] = $this->load->view($this->active_controller.'/management_user/list_of_data',array('rows'=>$this->get_user_data()),true);
			$this->backoffice_template->render($this->active_controller.'/management_user/index',$data);
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

		function get_schools(){
			$dt2 = $this->input->post('dt2');
			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();
			$rows = $dao->execute(0,"SELECT sekolah_id,nama_sekolah FROM sekolah WHERE dt2_id='".$dt2."'")->result_array();
			$this->load->view($this->active_controller.'/management_user/school_opts.php',array('rows'=>$rows));
		}

		function submit_user_data(){
			$this->load->model(array('admins_model'));

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();

			$act = $this->input->post('act');
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

			$this->load->view($this->active_controller.'/management_user/list_of_data',array('rows'=>$this->get_user_data()));
		}

		function delete_user_data(){
			$this->load->model(array('admins_model'));

			$id = $this->input->post('id');

			$this->global_model->reinitialize_dao();
			$dao = $this->global_model->get_dao();

			$m = $this->admins_model;
			$result = $dao->delete($m,array('admin_id'=>$id));
			if(!$result){
				die('ERROR: gagal menghapus data');
			}

			$this->load->view($this->active_controller.'/management_user/list_of_data',array('rows'=>$this->get_user_data()));
		}

		//END OF MANAGEMENT USER FUNCTION PACKET

		//MANAGEMENT SCHOOL FUNCTION PAKET
		function management_school(){
			if(is_null($this->session->userdata('admin_id'))){
				redirect('backoffice/login_page');
			}
			$data['active_url'] = str_replace('::','/',__METHOD__);
			$data['list_of_data'] = $this->load->view($this->active_controller.'/management_user/list_of_data',array('rows'=>$this->get_user_data()),true);
			$this->backoffice_template->render($this->active_controller.'/management_school/index',$data);
		}
	}
?>