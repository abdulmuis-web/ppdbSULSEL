<?php

	class Config{

		private $_config = array();

		public function __construct(){			
			include APP.'configs'.DIRECTORY_SEPARATOR.'config.php';
			$this->_config = $config;
		}

		function set_item($item_name,$item_value){
			$this->_config[$item_name] = $item_value;
		}

		function item($item_name){
			return $this->_config[$item_name];
		}

	}
?>