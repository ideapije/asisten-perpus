<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Member extends CI_Controller
{	
	function __construct()
	{
		ob_start();
		parent::__construct();
		$urls	=getUriSegments();
		if(!$this->session->userdata('logged_in')){
			(in_array('booking', $urls))? $redirect ='asisten/nosession/1' : $redirect='asisten';
			redirect($redirect,'refresh');
        }
        $this->m_perpus->send_sms_duedate();
      	$this->enqueue->load_css_multi(array('bootstrap.min','thumbnail-gallery'));
		$this->enqueue->load_js_multi(array('jquery-1.9.1','jquery-perpus','bootstrap.min'));
		$this->enqueue->loadcss();
		$this->enqueue->loadjs();
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
		$this->load->library('upload', $config);
		
	}
	function index($page=false){	
		$footer				='Copyright &copy; ST3 TELKOM PURWOKERTO';
		$session_data 		= $this->session->userdata('logged_in');
		$data['username']	= $session_data['username'];
		$data['userlabel']	= array('email'=>'Email','nim'=>'Nomer Induk Mahasiswa','nama_asli'=>'Nama Lengkap','alamat'=>'Alamat Lengkap','alamat_domisil'=>'Alamat Domisil','alamat_asli'=>'Alamat Asli','asal_institusi'=>'Asal Institusi','tgl_lahir'=>'Tanggal lahir');
		$data['userdata']	= $this->m_user->userdata();
		$data['larik_menu']	= list_menu();
		$data['right_menu'] ='<li><a href="'.site_url('member/logout').'" class="btn btn-lg" >logout</a></li>';
		$urls         =getUriSegments();
		$offset       =end($urls);
		$pagination_config  =pagination_config('member/index','lib_book',16); 
		$this->pagination->initialize($pagination_config);
			$katalog     = $this->db->get('lib_book',16,$offset)->result_array();
			$content     =search_input();
			$content    .='<div class=" listcatalog">';
			if ($katalog && count($katalog)>0) {
				foreach ($katalog as $key => $value) {
					(strlen($value['lib_book_cover'])>=0 && strlen($value['lib_book_cover'])<=3)? $img_src=COVER_SRC.$value['lib_book_cover'].'.jpg' : $img_src=COVER_SRC.'cover-default.jpg';
					$content .='<div class="col-lg-3 col-md-4 col-xs-6 thumb">';
					$content .='<div class="thumbnail-cat">';$content .='<div class="caption-cat">';
					$content .='<h4>'.$value['lib_book_title'].'</h4>';
					$content .='<p> <strong>'.$value['lib_book_author'].'</strong>';
					$content .='<div class="btn-group btn-group-sm"><a href="'.site_url('member/detail/1/'.encrypt_url($value['id'])).'" class="btn btn-sm btn-primary" rel="tooltip" title="detail">Details</a>';
					$content .='<a href="'.site_url('member/booking/'.encrypt_url($value['id'])).'" class="btn btn-sm btn-success" rel="tooltip" title="Booking">Booking</a></div></p></div>';
					$content .='<img class="img-responsive" src="'.$img_src.'" alt="'.$value['id'].'"></div></div>';
				}
			}
	      $content  .='<div class="container">'.$this->pagination->create_links().'</div>';
    	  $content  .='</div>';		
		($page)? $isinya=$page : $isinya=$content;
		laod_view('template','menu',$data);
		$this->m_perpus->container($isinya,$footer);
	}
	function troli($user_id=false,$filter=false){
		$userdata =$this->m_user->userdata();
		($user_id)? $userid =$user_id : $userid=$userdata[0]['id'];
		($filter && is_array($filter))? $data=$filter : $data=$this->m_perpus->get_data_table('lib_book_action',array('user_id'=>$userid));
		$content ='';
		if ($data && count($data)>0) {
			$content .='<ul class="media-list">';
			foreach ($data as $key => $value) {
				$detail_buku 	=$this->m_perpus->get_data_table('lib_book',array('id'=>$value['book_id']));
				$detail_member 	=$this->m_perpus->get_data_table('members',array('id'=>$value['user_id']));
				$calculatexp	=get_calculate_date($value['date_borrowed_exp']);
				if ($calculatexp < 0) {
					$masapeminjam =$calculatexp.' Hari Lagi';
				}else if ($calculatexp ==0) {
					$masapeminjam =' Sudah jatuh Tempo';
				}else if ($calculatexp > 0) {
					$masapeminjam ='Sudah Telat '.$calculatexp.' Hari';
				}
				$content .='<li class="media">';
				$content .='<a class="pull-left col-xs-3" href="'.site_url('member/detail/1/'.encrypt_url($value['book_id'])).'">';
				$content .='<img class="media-object col-xs-12" src="'.COVER_SRC.$detail_buku[0]['lib_book_cover'].'.jpg" alt="'.$detail_buku[0]['lib_book_title'].'">';
				$content .='</a>';
				$content .='<div class="media-body">';
				$content .='<h4 class="media-heading">'.$detail_buku[0]['lib_book_title'].'</h4>';

				$action_member ='';
				(IsNullOrEmptyString($detail_member[0]['uname']))? $member_identity_name=$detail_member[0]['nama_asli'] : $member_identity_name=$detail_member[0]['uname'];
				$content .='<p style="font-size:24px;">Pelaku : <a href="'.site_url('member/detail/2/'.encrypt_url($value['user_id'])).'"><strong>'.$member_identity_name.'</strong></a></p>';
				$content .='<span class="label label-primary">Memulai Aktivitas pada :'.$value['date_booking'].'</span>';			
				switch ($value['confirm_status']) {
					case '0':
						$content .='<span class="label label-info">'.strtoupper('belum terkonfirmasi').'</span>';
						$content .='<p>pemesanan pada tanggal <strong>'.$value['date_booking'].'</strong></p>';
						$content .='<hr/><h3>Status Buku : Belum siap dipinjam</h3>';
						$action_admin	='<a href="'.site_url('member/aksi/1/'.encrypt_url($value['id'])).'" class="btn btn-lg btn-primary">Konfirmasi pemesanan</a>';
						break;
					case '1':
						$content .='<span class="label label-info">'.strtoupper('sudah terkonfirmasi').'</span>';
						$content .='<p style="font-size:24px;">Peminjaman sudah dapat diproses </p>';
						$content .='<hr/><h3>Status Buku : Siap dipinjam</h3>';
						$action_admin	  ='<a href="'.site_url('member/aksi/2/'.encrypt_url($value['id'])).'" class="btn btn-lg btn-info">Pinjamkan</a>';
						break;
					case '2':
						$content 		.='<span class="label label-danger">'.strtoupper('masa expired '.$value['date_borrowed_exp']).'</span>';
						$content 		.='<p>Mohon mengembalikan Buku dengan waktu yang telah ditentukan</p>';
						$content		.='<hr/><h3>Status Buku : Terpinjam </h3><h3>Masa Peminjaman : '.$masapeminjam.'</h3>';
						$action_admin	 ='<a href="'.site_url('member/aksi/3/'.encrypt_url($value['id'])).'" class="btn btn-lg btn-success">Menerima Pengembalian</a>';
						break;
					case '3':
						$content 		.='<span class="label label-danger">'.strtoupper('masa expired '.$value['date_return']).'</span>';
						$content 		.='<p>Terima Kasih sudah mengembalikan Buku :)</p>';
						$content		.='<hr/><h3>Status Buku : SUdah dikembalikan</h3>';
						break;
					case '4':
						$content 		.='<span class="label label-danger">'.strtoupper('masa expired '.$value['date_borrowed_exp']).'</span>';
						$content 		.='<h3>waktu Peminjaman sudah habis segera lakukan Pengembalian</h3>';
						$content 		.='<hr/><h3>Tagihan Denda : Rp'.($calculatexp*1000).'</h3>';
						break;
				}
				(is_admin())? $content .=$action_admin : $content.=$action_member;
				$content .='</div></li>';
			}
			$content .='</ul>';
		}
		$this->index($content);
	}

function rate(){
	$id_sent=preg_replace("/[^0-9]/","",$_REQUEST['id']);
	if (isset($id_sent) && !is_null($id_sent)) {
		$kdbuku=spesifickolbyid($id_sent,29,'kdbuku');
		$vote_sent=preg_replace("/[^0-9]/","",$_REQUEST['stars']);
		$rem=$_SERVER['REMOTE_ADDR'] ;
		if ($this->session->userdata('logged_in')) {
			$session_data=$this->session->userdata('logged_in');
			$cq=$this->db->get_where('ratings',array('id'=>$session_data['id'],'kdbuku'=>$kdbuku))->num_rows();
			if ($cq>0) { ?>
				<div class="alert alert-warning">maaf anda sudah melakukan testimoni pada buku yang berjudul <strong><?php echo spesifickolbyid($id_sent,18,'judul_buku');?></strong></div>
			<?php }else{	
				$rate=array(
					'kdbuku'=>$kdbuku,
					'id'=>$session_data['id'],
					'total_value'=>$vote_sent,
					'date'=>date('Y-m-d H:i:s')
				);
				$query=$this->db->insert('ratings',$rate);
				if ($query && spesifickolbyid($id_sent,30,'idboking','idboking') && cekid($id_sent,29)) {
					$this->db->where('idboking',$id_sent)->delete('antrian');									
					$this->db->where('idboking',$id_sent)->delete('pesanbuku');
					return 'berhasil';
					//redirect('member/view/22?w='.$id_sent);
				}else{
					return 'error :(';
					//return false;
				}
			}
		}
	}
}


function uploadimg($mng='',$fkol=''){
	if (cekosong(array($mng,$fkol))) {
		//show_404();
		return false;
	}else{
		if ($this->upload->do_upload('userfile')){
			$dataimg=$this->upload->data();
			if (cekimg($mng,$fkol)) {
				$idimg=cekimg($mng,$fkol);
				$this->db->where('idimg',$idimg)->update('image',array('src'=>$dataimg['full_path']));
				
			}else{
				$idimg=$this->m_perpus->settable('image',array('src'=>$dataimg['full_path'],'alt'=>$fkol,'mng'=>$mng));
			}
			return $idimg;
		}
	}
}

function container($container='',$footer=''){
		$content ='<div class="container">';
		$content .=$container;
    	$content .='</div>';
		$content .='<div id="footer">';
    	$content .='<div class="container">';
		$content .='<p class="text-muted">'.$footer.'</p>';
    	$content .='</div></div>';
    	echo $content;
}
function logout(){
   		$this->session->unset_userdata('logged_in');
   		$this->session->sess_destroy();
   		redirect('asisten', 'refresh');
 }
	function booking($idb=''){
		$idb =decrypt_url($idb);
		$userdata = $this->m_user->userdata();
		$cek =$this->db->get_where('lib_book_action',array('user_id'=>$userdata[0]['id'],'book_id'=>$idb));
		if ($cek->num_rows() > 0) {
			redirect('member/info/1?b='.encrypt_url($idb));
		}else{
			$data=array(
				'user_id'=>$userdata[0]['id']
				,'book_id'=>$idb
			);
			$this->db->insert('lib_book_action',$data);
			redirect('member/troli');
		}
	}
 function info($kasus=''){
 	switch ($kasus) {
 		case '1':
 			if (isset($_GET['b']) && $title=$this->m_perpus->detailbuku('lib_book',decrypt_url($_GET['b']),'lib_book_title')) {
 				$this->index('Anda sudah melakukan pemesanan Buku '.$title);
 			}
 			break;
 	}
 }
 function aksi($param=false){
 	if ($param) {
 		$urls 	=getUriSegments();
 		$id 	=decrypt_url(end($urls));
 		switch ($param) {
 			case '1':
 				$this->db->where('id',$id)->update('lib_book_action',array('confirm_status'=>1));
 				break;
 			case '2':
 				$this->db->where('id',$id)->update('lib_book_action',array('date_borrowed'=>date('Y-m-d'),'date_borrowed_exp'=>duedate(),'confirm_status'=>2));
 				break;
 			case '3':
 				$this->db->where('id',$id)->update('lib_book_action',array('date_return'=>date('Y-m-d'),'confirm_status'=>3));
 				break;
 		}
 		(is_admin())? $redirect_url='member/activity' : $redirect_url ='member/troli';
 		redirect($redirect_url);
 	}else{
 		show_404();	
 	}
 	
 }
 	function detail($table,$id=''){
		$list_table	=array('lib_book'=>'1','members'=>'2');
		$table 	 	=array_search($table, $list_table);
		$id 	 	=decrypt_url($id);
		$content 	=$this->m_perpus->detailbuku($table,$id,false,true);
		if ($content){
			$this->index($content);
		}else{
			show_404();
		}
	}

	function anggota(){
		if (is_admin()) {
				$data= $this->db->get('members')->result_array();
				$content ='<table class="table"><thead><tr><td>Jabatan</td><td>Username</td><td>NIM</td><td>email</td><td>No.Handphone</td><td>Gender</td><td>Aksi</td></tr></thead>';
				foreach ($data as $key => $value) { 
					$content .='<tr>';
					($value['id_gender']==1)? $gender ='Laki-Laki' : $gender ='Perempuan';
					$content .='<td>'.Jabatan($value['idjbtn']).'</td><td>'.$value['uname'].'</td><td>'.$value['nim'].'</td><td>'.$value['email'].'</td><td>'.$value['nohp'].'</td><td>'.$gender.'</td>';
					$content .='<td><div class="btn-group"><button type="button" class="btn btn-default">edit</button>';
					$content .='<a href="'.site_url('member/acc/'.encrypt_url($value['id'])).'" class="btn btn-success">';
					(IsNullOrEmptyString($value['acc']) || $value['acc']==0)? $content .='Aktifkan' : $content.='Non Aktifkan';
					$content .='</a></div></td>';
					$content .='</tr>';
				}	
				$content .='</table>';
				$this->index($content);
		}else{
			show_404();
		}
	}

	function acc($idm=false)
	{
		$idm =decrypt_url($idm);
		if ($idm && $data=$this->m_perpus->get_data_table('members',array('id'=>$idm),false)) {
			(IsNullOrEmptyString($data[0]['acc']) || $data[0]['acc']==0)? $acc=1 : $acc=0; 
			$this->db->where('id',$idm)->update('members',array('acc'=>$acc));
			redirect('member/anggota');
		}else{
			show_404();
		}
	}
	function activity(){
		if (is_admin()) {  
			$jml_unconfirmed=$this->m_perpus->count_act('0');
			$jml_booking 	=$this->m_perpus->count_act('1');
			$jml_pinjam 	=$this->m_perpus->count_act('2');
			$jml_kembali 	=$this->m_perpus->count_act('3');
			$jml_telat 		=$this->m_perpus->count_act('4');
			$content ='<div class="col-md-3 col-sm-4 col-xs-6"><div class="dummy"></div>';
			$content .='<a href="'.site_url('member/listact/'.encrypt_url('0')).'" class="thumbnail-adm purple"><h1>'.$jml_unconfirmed.'</h1> Belum terkonfirmasi</a></div>';
			$content .='<div class="col-md-3 col-sm-4 col-xs-6"><div class="dummy"></div>';
			$content .='<a href="'.site_url('member/listact/'.encrypt_url('1')).'" class="thumbnail-adm purple"><h1>'.$jml_booking.'</h1> Booking</a></div>';
			$content .='<div class="col-md-3 col-sm-4 col-xs-6"><div class="dummy"></div>';
			$content .='<a href="'.site_url('member/listact/'.encrypt_url('2')).'" class="thumbnail-adm purple"><h1>'.$jml_pinjam.'</h1> Peminjaman</a></div>';
			$content .='<div class="col-md-3 col-sm-4 col-xs-6"><div class="dummy"></div>';
			$content .='<a href="'.site_url('member/listact/'.encrypt_url('3')).'" class="thumbnail-adm purple"><h1>'.$jml_kembali.'</h1> Pengembalian</a></div>';
			$content .='<div class="col-md-3 col-sm-4 col-xs-6"><div class="dummy"></div>';
			$content .='<a href="'.site_url('member/listact/'.encrypt_url('4')).'" class="thumbnail-adm purple"><h1>'.$jml_telat.'</h1> Telat Mengembalikan</a></div>';				
			$this->index($content);
		}else{
			show_404();
		}
	}

	function listact($act=false)
	{
		$cek =array('0','1','2','3','4');
		$act =decrypt_url($act);
		if (in_array($act, $cek)) {
			$data =$this->m_perpus->count_act($act,true);
			$this->troli(false,$data);
		}else{
			show_404();
		}
	}
}
