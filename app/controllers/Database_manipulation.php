<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class database_manipulation extends CI_Controller{

		function __construct(){
			parent::__construct();
		}

		function index(){
			echo "there is no any activity here";
		}

		function update_pengaturan_dt2_sekolah(){
			$this->load->library('DAO');
			$this->load->model(array('global_model','pendaftaran_model'));
			$dao = $this->global_model->get_dao();
			$rows = $dao->execute(0,"SELECT * FROM pengaturan_dt2_sekolah")->result_array();

			foreach($rows as $row){
				$sql = "UPDATE pengaturan_dt2_sekolah SET status='".trim($row['status'])."' WHERE dt2_id='".$row['dt2_id']."' AND dt2_sekolah_id='".$row['dt2_sekolah_id']."'";
				$result = $dao->execute(0,$sql);
			}
		}

		function change_registrantName(){
			$this->load->library('DAO');
			$this->load->model(array('global_model','pendaftaran_model'));
			$dao = $this->global_model->get_dao();
			$rows = $dao->execute(0,"SELECT * FROM pendaftaran")->result_array();

			$this->db->trans_begin();

			$m = $this->pendaftaran_model;
			$i = date('Y');

			foreach($rows as $row){
				$new_name = 'DEMO PPDB '.$i;
				$m->set_nama($new_name);
				$result = $dao->update($m,array('id_pendaftaran'=>$row['id_pendaftaran']));
				if(!$result){
					$this->db->trans_rollback();
					die('Process terminated');
				}
				$i++;
			}

			$this->db->trans_commit();
		}

		function generate_randPass($unlength,$pslength){
			$this->load->library('DAO');
			$this->load->model(array('global_model','admins_model'));
			$this->load->helper('mix_helper');

			$dao = $this->global_model->get_dao();

			$m = $this->admins_model;

			$rows = $dao->execute(0,"SELECT a.sekolah_id,a.nama_sekolah,b.nama_dt2 FROM sekolah as a LEFT JOIN ref_dt2 as b 
									 ON (a.dt2_id=b.dt2_id)")->result_array();

			$this->db->trans_begin();
			
			$file = fopen(FCPATH.'school_accounts.txt', 'w');

			foreach($rows as $row){

				$username = generatePassword($unlength);
				$password = generatePassword($pslength);
				$admin_id = $this->global_model->get_incrementID('admin_id','admins');

				$m->set_admin_id($admin_id);
				$m->set_username($username);
				$m->set_password(md5($password));
				$m->set_type_fk('3');
				$m->set_fullname($row['nama_sekolah']);
				$m->set_status('1');
				$m->set_sekolah_id($row['sekolah_id']);
				$m->set_created_by('root');
				$m->set_created_time(date('Y-m-d H:i:s'));
				$m->set_modifiable('1');
				$result = $dao->insert($m);
				if(!$result){
					die('there is something wrong that killed the process!');
					$this->db->trans_rollback();
				}

				$text = $admin_id.";".$username.";".$password.";".$row['nama_sekolah'].";".$row['nama_dt2']."\n";
				fwrite($file,$text);

			}

			fclose($file);

			$this->db->trans_commit();

		}

	}
?>