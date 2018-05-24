<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
	$base_url .= "://".$_SERVER['HTTP_HOST'];
	$base_url .= preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME'])).'/';

	$config['assets_path'] = $base_url.'assets/';
	$config['css_path'] = $base_url.'assets/css/';
	$config['js_path'] = $base_url.'assets/js/';
	$config['img_path'] = $base_url.'assets/img/';	
	$config['font_path'] = $base_url.'assets/fonts/';
	$config['upload_path'] = $base_url.'upload/';

?>