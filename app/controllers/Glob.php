<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class glob extends CI_Controller{
		
		function __construct(){
			
			parent::__construct();

			$this->load->library(array('DAO'));			
			$this->load->model(array('global_model'));			
		}


		function get_village(){
			$district = $this->input->post('district');

			$dao = $this->global_model->get_dao();
			$village_rows = $dao->execute(0,"SELECT * FROM ref_kelurahan WHERE kecamatan_id='".$district."'")->result_array();
			$data['village_rows'] = $village_rows;
			$data['type'] = (!is_null($this->input->post('type'))?$this->input->post('type'):'0');
			$data['district'] = $district;
			$this->load->view('global/village_list',$data);
		}


	}
?>