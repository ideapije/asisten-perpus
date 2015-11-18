<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Visitor extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

	function caribuku(){
		$book_title =$this->input->post('lib_book_title');
		if (isset($book_title)) {
			$katalog = $this->m_perpus->get_data_like($book_title,'lib_book_title','lib_book');
			if ($katalog) {
				($this->session->userdata('logged_in'))? $base_url='member/index' : $base_url='asisten/index';
				$content =$this->m_perpus->catalog($base_url,'col-lg-3 col-md-4 col-xs-6 thumb',16,$katalog);
			}else{
				$content ="<h1>Tidak ditemukan Hasil :(</h1>";
			}
			echo $content;
		}
	}



}