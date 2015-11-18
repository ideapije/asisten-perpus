<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Asisten extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in')){
            redirect('member','refresh');
        }
        $this->m_perpus->send_sms_duedate();
		$this->enqueue->load_css_multi(array('bootstrap.min','thumbnail-gallery'));
		$this->enqueue->enqueue_js('jquery-1.9.1');
		$this->enqueue->enqueue_js('bootstrap.min');
		$this->enqueue->enqueue_js('jquery-perpus');
		$this->enqueue->loadcss();
		$this->enqueue->loadjs();
        $this->m_perpus->install_db();
        $me =get_class($this);
	}

	function modal($title='',$content='',$action=array()){
		$modal ='<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
  		$modal .='<div class="modal-dialog">';
    	$modal .='<div class="modal-content">';
      	$modal .='<div class="modal-header">';
        $modal .='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $modal .='<h4 class="modal-title" id="myModalLabel">'.$title.'</h4>';
      	$modal .='</div>';
      	$modal .='<div class="modal-body" style="color:#000;">';
      	$modal .=$content;
      	$modal .='</div>';
      	$modal .='<div class="modal-footer">';
        foreach ($action as $key => $value) {
        	$modal .='<button type="button" class="btn '.$value['class'].'">'.$value['text'].'</button>';
        }
      	$modal .='</div></div></div></div>';
      	echo $modal;
	}

	function index(){
		$this->form_validation->set_rules('uname','username','required');
		$this->form_validation->set_rules('pass','password','callback_cek_database');
		if($this->form_validation->run()==false){
			$this->home($data);
		}else{
			($this->session->userdata('logged_in'))? redirect('member') : $this->home();
		}
	}
	function home($page=false){
			$data['larik_menu']	=list_menu();
			$data['right_menu']	='<li><a href="#" class="btn btn-lg" data-toggle="modal" data-target="#myModal">Memberarea</a></li>';
			$modal_act			=array(array('text'=>'Lupa Password?','class'=>'btn-sm btn-primary'),array('text'=>'Minta Bantuan','class'=>'btn-sm btn-info'));
			$urls         =getUriSegments();
			$offset       =end($urls);
			$pagination_config  =pagination_config($me.'/index','lib_book',16); 
			$this->pagination->initialize($pagination_config);
			$katalog     = $this->db->get('lib_book',16,$offset)->result_array();
			$content     =search_input();
			$content    .='<div class=" listcatalog">';
      if ($katalog && count($katalog)>0) {
      	foreach ($katalog as $key => $value) {
        (strlen($value['lib_book_cover'])>=0 && strlen($value['lib_book_cover'])<=3)? $img_src=COVER_SRC.$value['lib_book_cover'].'.jpg' : $img_src=COVER_SRC.'cover-default.jpg';
        
        $content .='<div class="col-lg-3 col-md-4 col-xs-6 thumb">';
        $content .='<div class="thumbnail-cat">';
        $content .='<div class="caption-cat">';
        $content .='<h4>'.$value['lib_book_title'].'</h4>';
        $content .='<p> <strong>'.$value['lib_book_author'].'</strong>';
        $content .='<div class="btn-group btn-group-sm"><a href="'.site_url($me.'/detail/1/'.encrypt_url($value['id'])).'" class="btn btn-sm btn-primary" rel="tooltip" title="detail">Details</a>';
        $content .='<a href="'.site_url('member/booking/'.encrypt_url($value['id'])).'" class="btn btn-sm btn-success" rel="tooltip" title="Booking">Booking</a></div></p></div>';
        $content .='<img class="img-responsive" src="'.$img_src.'" alt="'.$value['id'].'"></div></div>';
      }
  }
      $content  .='<div class="container">'.$this->pagination->create_links().'</div>';
      $content  .='</div>';
			ob_start();
			include PAGES_INC_PATH.'login.php';
			$modal_content		=ob_get_clean();
			laod_view('template','menu',$data);

			($page)? $contents=$page : $contents =$content;
			$footer 	='Copyright &copy; ST3 TELKOM PURWOKERTO';

			$this->m_perpus->container($contents,$footer);
			$this->modal('Portal Memberarea',$modal_content,$modal_act);
	}
	function about()
	{
		ob_start();
		include PAGES_PATH.'about.php';
		$content 	=ob_get_clean();
		$this->home($content);
	}
	function reg(){
		$this->form_validation->set_rules('uname', 'uname','required|is_unique[members.uname]',array('is_unique'=>'This %s already exists'));
        $this->form_validation->set_rules('pass', 'pass', 'required');
		$this->form_validation->set_rules('passc', 'Password Confirmation', 'required|matches[pass]');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[members.email]',array('is_unique'=>'This %s already exists'));
		if ($this->form_validation->run()==false) {
			redirect($me.'?r=1');
		}else{
			$this->add('23');
		}
	}

	function cek_database($password){
		$uname 	=$this->input->post("uname");
		$hasil 	=$this->m_user->ceklogin($uname,$password);
		if ($hasil && is_array($hasil)) {
			if($hasil['acc']==1){				
				$sess_array	=array('id'=>$hasil['id'],'username'=>$hasil['uname'],'idj'=>$hasil['idj']);
				$this->session->set_userdata('logged_in',$sess_array);
				return true;
			}else{
				$this->form_validation->set_message('cek_database','maaf,akun anda sudah terdaftar,namun belum diterima');
				return false;
			}
		}else{
			$this->form_validation->set_message('cek_database','invalid username or password');
			return false;	
		}
	}

	function nosession($kasus){
		$alert ='<div class="bs-callout bs-callout-info">';
		switch ($kasus) {
			case '1':
				$alert .='<h4>Booking tidak bisa diproses</h4><p>Silahkan masuk sebagai anggota pada menu <a href="#" class="btn btn-lg" data-toggle="modal" data-target="#myModal"><strong>Memberarea</strong></a> Atau mendaftar jika belum mempunyai akun</p>';
				break;
		}	
  		$alert .='</div>';
		$this->home($alert);
	}

	function detail($table,$id=''){
		$list_table	=array('lib_book'=>'1','members'=>'2');
		$table 	 	=array_search($table, $list_table);
		$id 	 	=decrypt_url($id);
		$content 	=$this->m_perpus->detailbuku($table,$id,false,true);
		if ($content){
			$this->home($content);
		}else{
			show_404();
		}
	}
	
}





