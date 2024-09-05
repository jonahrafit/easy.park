<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_Controller extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/Load
	 *	- or -
	 * 		http://example.com/index.php/Load/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/Load/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct() {
		parent::__construct();
		if(!$this->session->has_userdata('compte')){
			redirect(site_url());
		}
		$this->load->helper('url'); 
		$this->load->helper('assets');
		$this->load->library('pagination');
		date_default_timezone_set('utc');
	}
	
	public function slugify($text, $divider='-'){
		$text = preg_replace('~[^\pL\d]+~u',$divider,$text);
		$text = iconv('utf-8','us-ascii//TRANSLIT',$text);
		$text = preg_replace('~[^-\w]+~','',$text);
		$text = trim($text,$divider);
		$text = preg_replace('~-+~',$divider,$text);
		$text = strtolower($text);
		if(empty($text)){
			return 'n-a';
		}
		return $text;
	}
}