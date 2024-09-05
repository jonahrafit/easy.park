<?php
	if(!defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('css_url')) {
		function css_url($file) {
			return base_url() . 'assets/css/'.$file;
		}
	}

	if(!function_exists('lib_url')) {
		function lib_url($file) {
			return base_url() . 'assets/lib/' . $file;
		}
	}

	if(!function_exists('img_url')) {
		function img_url($file) {
			return base_url() . 'assets/img/'.$file;
		}
	}
	
	if(!function_exists('chart_url')) {
		function chart_url($file) {
			return base_url() . 'assets/chart/'.$file;
		}
	}
	
	if(!function_exists('select2_url')) {
		function select2_url($file) {
			return base_url() . 'assets/select2/'.$file;
		}
	}
	
?>