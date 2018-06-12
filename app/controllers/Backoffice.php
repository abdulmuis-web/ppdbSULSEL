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