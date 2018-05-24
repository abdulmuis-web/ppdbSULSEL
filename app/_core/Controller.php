<?php
	class Controller{

		private static $instance;

		protected $view;
		protected $load = null;

		function __construct(){

			
			$this->load = new Loader();
		}

		public function view($viewName,$data=[]){			
			$this->view = new View($viewName,$data);
			return $this->view;
		}

		protected function load(){
			return $this->load;
		}
	}
?>