<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class backoffice_parent extends CI_Controller{

		public $active_controller;

		function __construct(){
			
			parent::__construct();

			$this->load->library(array('backoffice_template','DAO','session','menu_management'));
			$this->load->helper(array('url'));
			$this->load->model(array('global_model'));
						
			$this->_SYS_PARAMS = $this->global_model->get_system_params();

			$lib_path = APPPATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'smartui/';
			
			require_once($lib_path.'SmartUtil.php');
			require_once($lib_path.'SmartUI.php');

			// smart UI plugins
			require_once($lib_path.'Widget.php');
			require_once($lib_path.'DataTable.php');
			require_once($lib_path.'Button.php');
			require_once($lib_path.'Tab.php');
			require_once($lib_path.'Accordion.php');
			require_once($lib_path.'Carousel.php');
			require_once($lib_path.'SmartForm.php');
			require_once($lib_path.'Nav.php');
			
			SmartUI::$icon_source = 'fa';

			// register our UI plugins
			SmartUI::register('widget', 'Widget');
			SmartUI::register('datatable', 'DataTable');
			SmartUI::register('button', 'Button');
			SmartUI::register('tab', 'Tab');
			SmartUI::register('accordion', 'Accordion');
			SmartUI::register('carousel', 'Carousel');
			SmartUI::register('smartform', 'SmartForm');
			SmartUI::register('nav', 'Nav');						
		}

	}

?>