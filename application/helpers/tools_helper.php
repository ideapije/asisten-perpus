<?php defined('BASEPATH') OR exit('No direct script access allowed');
function laod_view($folder='',$page='',$data=array()){
        $ci   =& get_instance();
        (strlen($folder)> 0)? $load_view=$folder.'/'.$page.'.php' : $laod_view=$page.'.php';
        if (file_exists(VIEW_PATH.$load_view)) {
            $ci->load->view($load_view,$data);
        }else{
          echo "Gagal Memuat Antarmuka :(";
        }

    }
    function tmpl_table(){
        $template = array(
        'table_open'  => '<table class="table-responsive table table-bordered">',
        'thead_open'  => '<thead>',
        'thead_close'         => '</thead>',
        'heading_row_start'     => '<tr>',
        'heading_row_end'       => '</tr>',
        'heading_cell_start'    => '<th>',
        'heading_cell_end'      => '</th>',
        'tbody_open'  => '<tbody>',
        'tbody_close'         => '</tbody>',
        'row_start'   => '<tr>',
        'row_end'     => '</tr>',
        'cell_start'  => '<td>',
        'cell_end'    => '</td>',
        'row_alt_start'         => '<tr>',
        'row_alt_end'         => '</tr>',
        'cell_alt_start'        => '<td>',
        'cell_alt_end'        => '</td>',
        'table_close'         => '</table>'
        );
        return $template;
    }

function sendemail($id='',$p=false,$msg=false){
        $ci=& get_instance();
      $user=getmng_byid(23,$id);
      $confr=encrypt_url($id);
      
      if ($p) {
        $m ='<html><head></head><body><h1>Hello '.$user['uname'].'</h1><br><p> terima kasih sudah bergabung dalam keanggotaan perpus st 3 telkom, untuk memastikan keaktifan akun ini, klik tombol dibawah ini';
        $m.='<a href="'.site_url('asisten/acc/'.$confr).'"><h1>Verifikasi AKUNKU</h1></a>';
        $m.= 'jika sudah dilakukan, segera login dengan username = '.$user['uname'].' dan password ='.$mm.' pada alamat berikut <a href="http://localhost/perpus/asisten">http://localhost/perpus/asisten</a></p></body></html>';
        $pesan=$m;
      }else if($msg) {
        $subject='RESET PASSWORD Anggota perpus ST3 Telkom';
        $pesan=$msg;
      }else{
        $subject='Pendaftaran Anggota perpus ST3 Telkom';
        $pesan='';
      }
      $from='14102065@st3telkom.ac.id';
      $to=$user['email'];
      $config['protocol']  = "smtp";
      $config['smtp_host'] ='smtp.mandrillapp.com';
      $config['smtp_port'] ='587';
      $config['smtp_user'] ='pangkalanbun16@gmail.com'; 
      $config['smtp_pass'] ='DQilYcLI5D9Ldn0DydSudA';
      $config['charset'] = "utf-8";
      $config['newline'] = "\r\n";
      $ci->email->initialize($config);
      $ci->email->set_newline("\r\n");
      $ci->email->set_mailtype('html');
      $ci->email->from($from);
      $ci->email->to($to);
      $ci->email->subject($subject);
      $ci->email->message($pesan);
      $ci->email->send();
}
function encrypt_url($string) {
  $key = "MAL_979805"; //key to encrypt and decrypts.
  $result = '';
  $test = "";
   for($i=0; $i<strlen($string); $i++) {
     $char = substr($string, $i, 1);
     $keychar = substr($key, ($i % strlen($key))-1, 1);
     $char = chr(ord($char)+ord($keychar));

     $test[$char]= ord($char)+ord($keychar);
     $result.=$char;
   }

   return urlencode(base64_encode($result));
}

function decrypt_url($string) {
    $key = "MAL_979805"; //key to encrypt and decrypts.
    $result = '';
    $string = base64_decode(urldecode($string));
   for($i=0; $i<strlen($string); $i++) {
     $char = substr($string, $i, 1);
     $keychar = substr($key, ($i % strlen($key))-1, 1);
     $char = chr(ord($char)-ord($keychar));
     $result.=$char;
   }
   return $result;
}

function is_admin(){
  $ci =& get_instance();
  if ($ci->session->userdata('logged_in')) {
      $session_data=$ci->session->userdata('logged_in');
      if ($session_data['idj']==='1') {
        return true;
      }else{
        return false;
      }
  }else{
      return false;
  }
}
function pagination_config($url='',$table='',$per=''){
        $ci=&get_instance(); 
        //pagination settings
        $config['base_url']       = site_url($url);
        $config['total_rows']     = $ci->db->count_all($table);
        $config['per_page']       = $per;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['full_tag_open'] = '<ul class="pagination pagination-lg">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $config['anchor_class'] = 'follow_link';
        return $config;
}
function emailadm($id=false)
{
  $ci=& get_instance();
  if ($id) {
    $email=spesifickolbyid($id,23,'email');
    return $email;
  }else{
  $query=$ci->db->select(array('id','email'))->get_where('members',array('idjbtn'=>'1'))->result_array();
  if (count($query) > 0) {
    foreach ($query as $value) {
        $send[]=array('email'=>$value['email'],'id'=>$value['id']);
      }
    return $send;
  }
  }
}
function getUriSegments() {
    return explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
}

function IsNullOrEmptyString($question){
    return (!isset($question) || trim($question)==='');
}



function search_input(){
  ob_start();
  include VIEW_PATH.'inc/search-input.php';
  return ob_get_clean();
}

function duedate(){
  $ci =& get_instance();
  if ($userdata=$ci->session->userdata('logged_in')) {
      $duedate=date_create(date('Y-m-d'));
      ($userdata['idj']=='3')? $exptime='7 days' : $exptime='3 days';
      date_add($duedate,date_interval_create_from_date_string($exptime));
      return date_format($duedate,'Y-m-d');
  }
  return false;
}


function get_calculate_date($duedate){
    $now = time(); // or your date as well
    $duedate = strtotime($duedate);
    $datediff = $now - $duedate;
    return floor($datediff/(60*60*24));
}
function label_buku(){
  return array(
          'lib_book_title'=>'Judul Buku'
          ,'lib_book_author'=>'Pengarang'
          ,'lib_book_type'=>'Type Buku'
          ,'lib_book_isbn'=>'ISBN'
          ,'lib_book_publisher'=>'Nama Penerbit'
          ,'lib_book_publisher_city'=>'Kota Penerbit'
          ,'lib_book_publish_year'=>'Tahun Terbit'
          ,'lib_book_details'=>'Detail Buku'
          ,'lib_book_state'=>'Negara Pembuat'
          ,'KATEGORI'=>'Kategory Buku'
          ,'lib_book_info'=>'Informasi lain'
          );
}

function label_member(){
  return array(

          'uname'=>'Username'
          ,'nama_asli'=>'Nama Lengkap'
          ,'nim'=>'Nomor Induk Mahasiswa'
          ,'email'=>'Alamat Email'
          ,'nohp'=>'No. Handphone'
          ,'idjbtn'=>'Jabatan Pengguna'
          ,'id_gender'=>'Gender'
          ,'tgl_lahir'=>'Tanggal Lahir'
          ,'alamat_domisil'=>'Alamat Domisil'
          ,'alamat_asli'=>'Alamat Asli'
          ,'asal_institusi'=>'Asal Institusi'
  );
}

function cektabel($table=''){
  $ci =& get_instance();
  $list_table =$ci->db->query("SHOW TABLES")->result_array();
  if (count($list_table)>0) {
    foreach ($list_table as $key => $value) {
        if ($value['Tables_in_perpus']==$table) {
            return true;
        }
    }
  }
  return false;
}

function list_menu(){
  $ci =& get_instance();
  if ($userdata=$ci->session->userdata('logged_in')) {
      if (is_admin()) {
        $list =array(
            array('label'=>'Katalog','link'=>site_url('member'))
            ,array('label'=>'Daftar Aktivitas','link'=>site_url('member/activity'))
            ,array('label'=>'Daftar Anggota','link'=>site_url('member/anggota'))
            ,array('label'=>'Profilku','link'=>site_url('member/detail/2/'.encrypt_url($userdata['id'])))
        );
      }else{
          $list =array(
            array('label'=>'Katalog','link'=>site_url('member'))
            ,array('label'=>'Troli','link'=>site_url('member/troli'))
            ,array('label'=>'Profilku','link'=>site_url('member/detail/2/'.encrypt_url($userdata['id'])))
          );
      }
  }else{
    $list =array(
        array('label'=>'Beranda','link'=>site_url('asisten')),
        array('label'=>'Tentang Kami','link'=>site_url('asisten/about'))
      );
  }
  return $list;
}
function get_current_userdata(){
  $ci =& get_instance();
  if ($userdata=$ci->session->userdata('logged_in')) {
      return array('id'=>$userdata['id'],'username'=>$userdata['username'],'jabatan'=>Jabatan($userdata['idj']));
  }else{
    return false;
  }
}
function Jabatan($idj){
    $list_jabatan =array('admin'=>'1','Mahasiswa'=>'2','dosen'=>'3','karyawan'=>'4');
    return array_search($idj, $list_jabatan);
}
