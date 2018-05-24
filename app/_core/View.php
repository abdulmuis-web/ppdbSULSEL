<?php
	
	class View{
		protected $view_file;
		protected $view_data;
		private $config = null;

		public function __construct($view_file,$view_data){
			$this->config = new Config();
			$this->view_file = $view_file;
			$this->view_data = $view_data;
		}

		public function render(){
			$exts = explode(',',$this->config->item('ext'));			

			foreach($exts as $ext){
				if(file_exists(VIEW.$this->view_file.'.'.$ext))
				{
					$status = true;					
					break;
				}
			}

			if($status){
				include VIEW . $this->view_file.'.'.$ext;
			}
		}
	}
?>