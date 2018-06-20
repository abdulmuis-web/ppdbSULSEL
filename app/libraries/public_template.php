<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	Class public_template{

		private $_ci;

		function __construct(){
			$this->_ci =& get_instance();
		}

		function render($view,$data = null){
			$this->_ci->load->model('global_model');
			
			$_SYS_PARAMS = $this->_ci->global_model->get_system_params();

			if($_SYS_PARAMS[6]=='yes'){
				$data['header_content'] = $this->_ci->load->view('template/header_content',$data,true);
				$data['navigation_content'] = $this->_ci->load->view('template/navigation_content',$data,true);
				$data['footer_content'] = $this->_ci->load->view('template/footer_content',$data,true);
				$data['main_content'] = $this->_ci->load->view($view,$data,true);
				$this->_ci->load->view('template',$data);
			}else{
				$this->_ci->load->view('locked_page',array());
			}
		}
	}
?>