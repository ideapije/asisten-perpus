<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class M_perpus extends CI_Model
{
	
	function __construct(){
		parent::__construct();
	}
	function install_db(){
		$this->db->query('CREATE DATABASE IF NOT EXISTS perpus');
	}

	function get_data_like($like='',$kol='',$tbl=''){
    $this->db->like($kol, $like);
    $query = $this->db->get($tbl);
    if ($query->num_rows() > 0) {
      return $query->result_array();
    }else{
      return false;
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
	function catalog($base_url='',$class='',$max='',$outside=false){
      $urls         =getUriSegments();
      $offset       =end($urls);
      (get_current_userdata())? $base_url='member' : $base_url='asisten';
      $pagination_config  =pagination_config($base_url,'lib_book',$max); 
      $this->pagination->initialize($pagination_config);
      $content ='';
      if ($outside) {
        $katalog=$outside;
      }else{
        $content .=search_input();
        $katalog  = $this->db->get('lib_book',$max,$offset)->result_array();
      }
      $content    .='<div class=" listcatalog">';
      if ($katalog && count($katalog)>0) {
        foreach ($katalog as $key => $value) {
          (strlen($value['lib_book_cover'])>=0 && strlen($value['lib_book_cover'])<=3)? $img_src=COVER_SRC.$value['lib_book_cover'].'.jpg' : $img_src=COVER_SRC.'cover-default.jpg';
        $content .='<div class="col-sm-6 col-md-4">';
        $content .='<div class="thumbnail">';
        $content .='<img src="'.$img_src.'" alt="'.$value['id'].'">';
        $content .='<div class="caption">';
        $content .='<h3>'.$value['lib_book_title'].'</h3>';
        $content .='<p> <strong>'.$value['lib_book_author'].'</strong></p>';
        $content .='<p><a href="'.site_url($base_url.'/detail/1/'.encrypt_url($value['id'])).'" class="btn btn-primary" role="button">Details</a> <a href="'.site_url('member/booking/'.encrypt_url($value['id'])).'" class="btn btn-success" role="button">Booking</a></p>';
        $content .='</div></div></div>';
		}
    return $content;
	}
}
	function detailbuku($table='',$idb='',$spesific=false,$generate=false){
		$query    =$this->db->get_where($table,array('id'=>$idb));
    $userdata =get_current_userdata();
    var_dump($userdata);
		if ($query->num_rows() > 0) {
			$data =$query->result_array();
			if ($generate) {
        switch ($table) {
          case 'lib_book':
            (strlen($data[0]['lib_book_cover'])>=0 && strlen($data[0]['lib_book_cover'])<=3)? $img_src=COVER_SRC.$data[0]['lib_book_cover'].'.jpg' : $img_src=COVER_SRC.'cover-default.jpg';
            $label     =label_buku();
            $tag_label ='<span class="label label-info ">'.$data[0]['lib_book_type'].'</span><span class="label label-info">'.$data[0]['KATEGORI'].'</span><span class="label label-info">'.$data[0]['lib_book_publisher'].'</span><hr>';            
            if (!$this->get_data_table('lib_book_action',array('user_id'=>$userdata['id'],'book_id'=>$data[0]['id']))) {
              $button    ='<a href="'.site_url('member/booking/'.encrypt_url($data[0]['id'])).'" class="btn btn-lg btn-success" rel="tooltip" title="Booking">Booking</a>';
            }
            break;
          case 'members':
            $img_src   =GAMBAR_SRC.'/user.png';
            $label     =label_member();
            $tag_label ='<span class="label label-info label-lg ">'.strtoupper(Jabatan($data[0]['idj'])).'</span>';
            $button    ='';
            break;
        }
        $content  ='<div class="col-md-4">';
        $content .='<img src="'.$img_src.'" alt="'.$data[0]['id'].'" class="col-xs-12">';
        $content .='</div>';
        $content .='<div class="col-md-8">';
        $content .= $tag_label; 
        $content .='<div class="row"><table class="table">';
        foreach ($label as $klabel => $valabel) {
          switch ($klabel) {
            case 'id_gender':
              ($data[0][$klabel]==1)? $isinya ='Laki-laki' : $isinya ='Perempuan';
              break;
            case 'idjbtn':
              $isinya =Jabatan($data[0][$klabel]);
              break;
            default:
              $isinya =$data[0][$klabel];
              break;
          }
          $content.='<tr><th>'.$valabel.'</th><td>'.$isinya.'</td></tr>';
        }
        $content .='</table></form></div><div class="row">';
        $content .=$button;
        $content .='</div></div>';
        return $content;
      }else{
        return ($spesific)? $data[0][$spesific] : $data;
      }
		}else{
			return false;
		}
	}
	function get_data_table($table='',$where=false,$generate=false){
    if (cektabel($table)) {
          $this->db->order_by('id', 'DESC');
          ($where)? $query  =$this->db->get_where($table,$where) : $query =$this->db->get($table);
          $template         =tmpl_table();
          $this->table->set_template($template);
          return ($generate)? $this->table->generate($query) : $query->result_array();
    }
    return false;
	}
  function send_sms_duedate(){
    $query=$this->db->get('lib_book_action');
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $key => $value) {
        $calculate =get_calculate_date($value['date_borrowed_exp']);
        if ((!IsNullOrEmptyString($value['date_borrowed_exp'])) && ($calculate >= -1 || $calculate > 0)) {
            $userdata =$this->get_data_table('members',array('id'=>$value['user_id']));
            $nohape =$userdata[0]['nohp'];    
            $data=array(
              'DestinationNumber'=>$nohape
              ,'SenderID'=>'pkm'
              ,'TextDecoded'=>'Segera mengembalikan buku '
              , 'CreatorID'=>'Gammu 1.28.90'
            ); 
            if (!IsNullOrEmptyString($nohape) && $value['sms_status']==0) {
                $this->db->insert('outbox',$data);
                ($calculate > 0)? $update_book_act=array('sms_status'=>1,'confirm_status'=>4) : $update_book_act=array('sms_status'=>1);
                $this->db->where('id',$value['id'])->update('lib_book_action',$update_book_act);
            }
        }
      }
    }
  }
  function count_act($act,$generate=false){
    if (in_array($act,array('0','1','2','3','4'))) {
      $this->db->order_by('id', 'DESC');
      $query =$this->db->get_where('lib_book_action',array('confirm_status'=>$act));
      return ($generate)? $query->result_array() : $query->num_rows();
    }else{
      return false;
    }
    
  }
}
