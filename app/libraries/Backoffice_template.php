<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	Class backoffice_template{

		private $_ci;

		function __construct(){
			$this->_ci =& get_instance();
			
		}

		function render($view,$data = null){

			$dao = $this->_ci->global_model->get_dao();
				
			$sql = "SELECT b.* FROM admin_privileges as a INNER JOIN (SELECT nav_id,reference,title,hierarchy,url,image,target,sequence_number 
					FROM admin_navigations WHERE(showed='1')) as b ON (a.nav_fk=b.nav_id) WHERE(type_fk='".$this->_ci->session->userdata('admin_type_id')."')
					ORDER BY b.sequence_number ASC";				
			$menu_rows = $dao->execute(0,$sql)->result_array();			

			$page_nav = array();
			$menu_tree = array();

			foreach($menu_rows as $row)
			{
			    $menu_tree[$row['nav_id']]=array('reference'=>($row['reference']==1?null:$row['reference']),
			    								 'title'=>$row['title'],
			    								 'hierarchy'=>$row['hierarchy'],
			    								 'url'=>$row['url'],
			    								 'image'=>$row['image'],
			    								 'url_target'=>$row['target'],
			    								 'li_class'=>($row['url']==$data['active_url']?'active':''),
			    								 );
			}

			$page_nav = $this->_ci->menu_management->parseMenuTree($menu_tree);
			
			$data['header_content'] = $this->_ci->load->view('backoffice_template/header_content',array('body_class'=>''),true);
			$data['navigation_content'] = $this->_ci->load->view('backoffice_template/navigation_content',array('page_nav'=>$page_nav,'no_menu'=>false),true);
			$data['footer_content'] = $this->_ci->load->view('backoffice_template/footer_content',array('containsTable'=>isset($data['containsTable']),'no_menu'=>false),true);
			$data['main_content'] = $this->_ci->load->view($view,$data,true);
			$this->_ci->load->view('backoffice_template',$data);
		}

		function monitor($view,$data){
			$dao = $this->_ci->global_model->get_dao();
			$data['header_content'] = $this->_ci->load->view('backoffice_template/header_content',array('body_class'=>'no-menu'),true);
			$data['navigation_content'] = $this->_ci->load->view('backoffice_template/navigation_content',array('no_menu'=>true),true);
			$data['footer_content'] = $this->_ci->load->view('backoffice_template/footer_content',array('containsTable'=>false,'no_menu'=>true),true);			
			$data['main_content'] = $this->_ci->load->view($view,$data,true);
			$this->_ci->load->view('backoffice_template',$data);
		}
	}
?>