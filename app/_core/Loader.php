<?php
	
	class Loader{

		function __construct(){

		}

		private function generate_array($params){
			return is_array($params)?$params:[$params];
		}

		function library($libraries){
			$libraries = $this->generate_array($libraries);
			foreach($libraries as $library){
				include APP.DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.$library.'.php';
			}
		}

		function model($models){
			$models = $this->generate_array($models);
			foreach($models as $model){
				include APP.DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.$library.'.php';	
			}
		}
	}

?>