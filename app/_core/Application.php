<?php

	class Application{
		
		protected $controller = '';
		protected $action = 'index';
		protected $prams = [];
		private $config = null;

		public function __construct(){
			$this->config = new Config();
			$this->controller = $this->config->item('default_controller');

			$this->prepareURL();
			
			if(file_exists(CONTROLLER.$this->controller.'.php')){
				$this->controller = new $this->controller;				
				if(method_exists($this->controller, $this->action))
					call_user_func_array([$this->controller,$this->action],$this->prams);
			}
		}

		protected function prepareURL(){

			$request = trim($_SERVER['REQUEST_URI'],'/');

			if(!empty($request)){

				$base_url = explode('/',$this->config->item('base_url'));

				$_url = explode('/',$request);
				$url = [];

				foreach($_url as $val){										
					if(!in_array($val,$base_url)) $url[] = $val;					
				}				
				
				if(isset($url[0])) 
				{
					$this->controller = $url[0];
					unset($url[0]);
				}
				
				$this->controller .= 'Controller';

				if(isset($url[1]))
				{
					$this->action = $url[1];
					unset($url[1]);
				}

				$this->prams = !empty($url)?array_values($url):[];

			}
		}
	}


?>
