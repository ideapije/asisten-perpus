<?php
/**
* tambahan
*/

class Member_tambahan {
    
    function count_req_quo(){
        $num=get_data_table('list_quo',array('id'),false,'y');
        $text='Permintaan Quotation'; ?>
        <li class="comment-count"> <a href="<?php echo(admin_url('options-general.php?page=memberzone'));?>"> <?php echo($num.' '.$text);?></a></li>
        <?php 
    }
    function hapus_pemberitahuan_update_wp_for_user(){
    	if (!current_user_can('update_core')) {
    		remove_action( 'admin_notices', 'update_nag', 3 );
    	}
    }

    function fungsi_init(){
    	$segment_url_3=getUriSegment(3);
    	if (isset($segment_url_3) && $segment_url_3=='post-new.php' && get_userrole()==='subscriber') {
    		wp_redirect(esc_url(admin_url('profile.php')));
    		exit();
    	}

		$user = wp_get_current_user();
        if (isset($_GET['ac']) || isset($_GET['s'])) {
            $larik=get_data_table('list_quo',array('id'),false,false);
            (isset($_GET['s']))? $ids=decrypt_url($_GET['s']) : $ids=3;
			if (current_user_can( 'manage_options' )) {
					$redirect='options-general.php?page=memberzone'; 
			}else{
					$redirect='admin.php?page=request-page'; 
			}
			$data=array('status'=>$ids ,'exp_time'=>duedate());
            if (is_array($larik) && count($larik) > 1) {
            	$cekid=array_map("return_md5",$larik);            
				if (array_search($_GET['ac'], $cekid)!==false) {
					$k=array_search($_GET['ac'], $cekid);
					$idq=$larik[$k];
					$post_id=get_post_idlistquo($idq);
					$postingan=get_post($post_id);
					update_data('list_quo',$data,array('id'=>$idq));
					wp_redirect(esc_url(admin_url($redirect)));
					exit;
					
				}
            }elseif (strlen($larik) > 0 && $_GET['ac']==md5($larik)) {
					$post_id=get_post_idlistquo($larik);
					$postingan=get_post($post_id);
					update_data('list_quo',$data,array('id'=>intval($larik)));
					wp_redirect(esc_url(admin_url($redirect)));
					exit;
            }
        }

        if (isset($_GET['e']) && !cekosong($_GET['e'])) {
			$switch=htmlspecialchars($_GET['e']);
        	switch ($switch) {
				case '1':
					echo "<script>alert('inputan tidak boleh kosong !');</script>";
					break;
				case '2':
					echo "<script>alert('gagal upload');</script>";
					break;
				case '3':
					echo "<script>alert('format gambar tidak sesuai, silahkan upload ulang');</script>";
					break;
				case '4':
					echo "<script>alert('gagal menghapus data :(');</script>";
					break;
				case '5':
					echo "<script>alert('Anda sudah pernah melakukan pemesanan buku ini');</script>";
					break;
				case '6':
					echo "<script>alert('Booking berhasil dilakukan, mohon tunggu sejenak untuk mendapat konfirmasi dari librarian');</script>";
					break;
				case '7':
					echo "<script>alert('Maaf konfirmasi pengambilan tidak valid');</script>";
					break;
				case '8':
					echo "<script>alert('Selamat konfirmasi pengambilan anda diterima');</script>";
					break;
        	}
        }
        
    }


    //set allow html
    public function allow_html(){
        // Disables Kses only for textarea saves
        foreach (array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description') as $filter) {
            remove_filter($filter, 'wp_filter_kses');
        }
        // Disables Kses only for textarea admin displays
        foreach (array('term_description', 'link_description', 'link_notes', 'user_description') as $filter) {
            remove_filter($filter, 'wp_kses_data');
        }
    }



    public function set_permalink()
    {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%/%post_id%');
        $wp_rewrite->flush_rules();
    }
     
function cetakpdf(){
    global $wpdb;
    $t4=$wpdb->prefix.'list_quo';
    if (isset($_GET['di']) && isset($_GET['id'])) {
        $idq=decrypt_url($_GET['id']);
        $data=get_list_quoby_id($idq,'y');
        $pdf=new PDf();
        if (isset($_GET['u']) && $_GET['u']==1) {
			update_data('list_quo',array('terunduh'=>1),array('id'=>$idq));
		}
		switch ($_GET['di']) {
            case 'q':
                $pdf->umum_quo($data);
                break;
            case 'i':
				$data['subtotal']=getdata_bykoland_id('list_quo','memberzone-total-tagihan','id',$idq);
                $pdf->umum_inv($data); 
                break;
        }
    }
}

//save metabox ===============================================================================================
    
	function detailbarang_save($post_id)
	{
        global $wpdb;
        $t1=$wpdb->prefix.'custom_meta_key';
        $get_metakey = $wpdb->get_results("SELECT meta_key FROM $t1", ARRAY_A );
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if(!isset($_POST['detailbrg_nonce']) || !wp_verify_nonce($_POST['detailbrg_nonce'],'detailbrg_box_nonce')) return;
        if(!current_user_can('edit_post')) return;
        if (is_array($get_metakey)) { //count($get_metakey) > 0 && 
            foreach ($get_metakey as $value) {
                if(isset($_POST[$value['meta_key']])){
                    update_post_meta($post_id,$value['meta_key'],wp_kses($_POST[$value['meta_key']],$allowed));    
                }
            }
       }
	}

function get_opsional($id=''){
        global $wpdb;
        $t3=$wpdb->prefix.'opsional_meta_key';
        $sql="SELECT opsional FROM $t3 WHERE id IN(".$id.")";
        $results=$wpdb->get_results($sql,ARRAY_A);
        $larik=array();
        if (count($results) > 0) {
            foreach ($results as $hasil) {
                $larik[]=$hasil['opsional'];
            }
            return implode(',', $larik);
        }
}


//========================================filter single postingan ============================================    
    
    function the_content_filter(){ 
		$idpost=Memberzone_Base::get_post_id();
		$post_thumbnail_id = get_post_thumbnail_id($idpost);
		$thumb_html_img=get_the_post_thumbnail($idpost,'post-thumbnail');		
		$postingan=get_post($idpost);
		$bukutersedia=get_post_meta($idpost,'bukutersedia',true);
		$get_opsi=get_alldata('custom_meta_key');
		$new_content='';
		(strlen($postingan->post_content)>255 && !is_single() && !is_page())? $new_content .=substr($postingan->post_content,0,255).'<a href="'.get_permalink().'" class="memberzone-button">Baca Selengkapnya</a>'  : $new_content .=$postingan->post_content;
		if (!is_page('Sistem pemesanan') || !is_page()) {       	
			if ($bukutersedia==1):
				if (is_user_logged_in()):
						add_thickbox();
						$toshow='formtawar';
						ob_start();				
						include MEMBERZONE_UI.'templates/memberzone-ui-thickbox.php';
						$new_content .=ob_get_clean();		
				else:
					add_thickbox();
					$toshow='login';
					ob_start();				
					include MEMBERZONE_UI.'templates/memberzone-ui-thickbox.php';
					$new_content .=ob_get_clean();
				endif;
			$new_content .='<br/>';
			endif;
        }
        return $new_content;
    }

    function add_meta_label(){
        $allpost=$_POST;
        $t4='opsional_meta_key';
        $t1='custom_meta_key';
        if (isset($_GET['b']) && !cekosong($allpost)) {
            switch ($_GET['b']) {
                case '1':
                    $dataopsi=array('meta_key'=>str_replace(' ', '_', $_POST['label']),'meta_label'=>$_POST['label'],'meta_type'=>$_POST['type'],'meta_max_val'=>25,'meta_opsional'=>$_POST['meta_opsional']);
                    insert_data($t1,$dataopsi);
                    break;
                case '2':
                    $dataopsi=array('meta_key'=>$_POST['mkey'],'opsional'=>$_POST['opsi']);
                    insert_data($t4,$dataopsi);
                    break;
                case '3':
                    delete_data($t1,array('id'=>$_POST['id']));
                    break;
                default:
                    return false;
                    break;
            }
            
        }else if (isset($_GET['d']) && !cekosong($_GET['d'])) {
            $idne=sanitize_text_field($_GET['d']);
            $val=explode('-', $idne);
            delete_data($t1,array('id'=>$val[0]));
            delete_data($t4,array('meta_key'=>$val[1]));
        }else if(isset($_GET['p']) && $_GET['p']==1){
            $allpost=$_POST;
			switch ($_POST['id']) {
				case '9':
				include MEMBERZONE_UI.'templates/memberzone-ui-confirm-pay.php';
				break;
			}
        }
    }
    		
   /*function add_footer_template() {
		ob_start();				
		include MEMBERZONE_UI . 'templates/memberzone-ui-footer.php';
		$new_content = ob_get_clean();
		echo $new_content;
	}*/
	//remove wp admin bar
	function remove_admin_bar() {
	if (!current_user_can('administrator') && !current_user_can( 'manage_options' )) {
		show_admin_bar(false);
		}
	}
	
	function pesan_setelahregister($message){
		if (strpos($message, 'Register') !== FALSE) {
			$newMessage = "Hallo! Terima kasih telah mencoba bergabung bersama kami di<strong>".get_bloginfo('name').'</strong>';
			return '<p class="message register">' . $newMessage . '</p>';
		}
		else {
			return $message;
		}
	}
	
	function page_about_quo(){
		 ob_start();         
        include MEMBERZONE_UI . 'templates/memberzone-ui-about-quo.php';
        $profilpage = ob_get_clean();
        $post = array(          
                'post_content' =>$profilpage,
                'post_name' =>'Tentang Penawaran',
                'post_status' => 'publish',
                'post_title' => 'Sistem pemesanan',
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
                'post_type' => 'page'
        );
        if (!get_page_by_title('Sistem pemesanan')) {
			wp_insert_post($post);   
        }else{
            $page = get_page_by_title( 'Sistem pemesanan' );
            $post['ID']=$page->ID;
            wp_update_post($post);
        }
	}
	
    function submenu_post_opsional(){
            //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
            //add_posts_page('Buat Opsional', 'Opsional', 'write', 'opsional-page', array(__CLASS__,'submenu_post_opsional_callback'));
            add_submenu_page('edit.php','Buat Opsional','Buat Opsional','manage_options','opsional-page',array(__CLASS__,'submenu_post_opsional_callback'));        //
    }
    function submenu_post_opsional_callback(){
        ob_start();         
        include MEMBERZONE_UI . 'templates/memberzone-ui-opsional.php';
        $opsionalpage = ob_get_clean();
        echo $opsionalpage;
    }
	function hapus_menu_dashboard_kecuali_admin() {
		if (current_user_can('level_10')) {
			return;
		}else{
			global $menu, $submenu, $user_ID;
			$the_user = new WP_User($user_ID);
			reset($menu); $page = key($menu);
			while ((__('Dashboard') != $menu[$page][0]) && next($menu))
				$page = key($menu);
				if (__('Dashboard') == $menu[$page][0]) unset($menu[$page]);
					reset($menu); $page = key($menu);			
					while (!$the_user->has_cap($menu[$page][1]) && next($menu))
						$page = key($menu);
					if (preg_match('#wp-admin/?(index.php)?$#',$_SERVER['REQUEST_URI']) && ('index.php' != $menu[$page][2]))
						wp_redirect(get_option('siteurl') . '/wp-admin/post-new.php');
		}
	}
	//menambahkan menu bar penawaran
	function toolbar_link_to_qoutation( $wp_admin_bar ) {
		if (get_userrole()==='subscriber') {
			$args = array(
				'id'    => 'Pemesananku',
				'title' => 'Daftar Pemesananku',
				'href'  =>esc_url(admin_url('admin.php?page=request-page')) ,
				'meta'  => array( 'class' => 'my-req-quo' )
			);
			$wp_admin_bar->add_node( $args );
		}
	}
	
	
	//
	function admin_menu_list_booking() {
		
		add_menu_page('booking buku', 'Daftar Booking buku', 'manage_options', 'list-booking-page', array(__class__,'list_booking_call_back'),'dashicons-money');
	}
	function list_booking_call_back(){
		if (ini_get('date.timezone')) {
    echo 'date.timezone: ' . ini_get('date.timezone');
}
		$thead_data=array('user_id'=>'Username','post_id'=>'Buku','booking_inquired'=>'waktu masuk','booking_expired'=>'waktu jatuh tempo','booking_status'=>'status data','id'=>'Aksi');
		$btn_aksi='Terkonfirmasi';
		$thead ='</tr>';	
		foreach($thead_data as $khead =>$vhead) {
			$thead .='<td>';
			$thead .=$vhead;
			$thead .='</td>';
		}
		$thead .='</tr>';
		$tbody_data=get_alldata('perpus_booking');
		$tbody ='';
		if ($tbody_data) {
			foreach($tbody_data as $kbody =>$vbody) {
			$postingan =get_post($vbody['post_id']);
			$user=get_user_by('id',$vbody['user_id']);
			$tbody .='<tr>';
			foreach ($thead_data as $kolom => $label) {
				switch ($kolom) {
					case 'user_id':
						$tbody .='<td>'.$user->user_login.'</td>';
						break;
					case 'post_id':
						$tbody .='<td>'.$postingan->post_title.'</td>';
						break;
					case 'booking_status':
						switch ($vbody[$kolom]) {
							case 1:
								$btn_aksi='<button type="button" class="memberzone-button memberzone-button-primary btn-acc-booking" id="'.$vbody['id'].'">Disetujui</button>';
								$tbody .='<td>Menunggu tanggapan</td>';
								break;
							case 2:
								add_thickbox();
								$toshow='pinjamkan';
								ob_start();				
								include MEMBERZONE_UI.'templates/memberzone-ui-thickbox.php';
								$btn_aksi =ob_get_clean();
								$tbody .='<td>Disetujui</td>';
								break;
							case 3:
								$tbody .='<td><strong>TERPINJAM</strong></td>';
								add_thickbox();
								$toshow='dpeminjaman';
								ob_start();				
								include MEMBERZONE_UI.'templates/memberzone-ui-thickbox.php';
								$btn_aksi =ob_get_clean();
								break;
						}
						break;

					case 'id':
						$tbody .='<td><span id="ak'.$vbody[$kolom].'si" style="display:none;">'.memberzone_enkrip($vbody[$kolom]).'</span>'.$btn_aksi.'</td>';
						break;
					case 'booking_expired':
						switch ($vbody['booking_status']) {
							case 3:
								$new_exptime=getdata_bykoland_id('log_peminjaman','waktu_harus_kembali','id_booking',$vbody['id']);
								($new_exptime)? $tbody .='<td>'.$new_exptime.'</td>' : $tbody .='<td>'.$vbody[$kolom].'</td>';	
								break;
							default:
								$tbody .='<td>'.$vbody[$kolom].'</td>';	
								break;
						}
						break;
					case 'booking_inquired':
						switch ($vbody['booking_status']) {
							case 3:
								$new_timeinqured=getdata_bykoland_id('log_peminjaman','waktu_masuk','id_booking',$vbody['id']);
								($new_timeinqured)? $tbody .='<td>'.$new_timeinqured.'</td>' : $tbody .='<td>'.$vbody[$kolom].'</td>';	
								break;
							default:
								$tbody .='<td>'.$vbody[$kolom].'</td>';
								break;
						}
						break;
					default:
						$tbody .='<td>'.$vbody[$kolom].'</td>';
						break;
					}
				}	
				$tbody .='</tr>';
			}
		}
		ob_start();				
		include MEMBERZONE_UI.'templates/memberzone-ui-list-booking.php';
		$content =ob_get_clean();			
		echo $content;
	}
	

function memberzone_cus_request(){
	add_menu_page('Pemesananku', 'Data Penawaran', 'subscriber', 'request-page', array(__CLASS__,'memberzone_cus_request_page'),'dashicons-list-view');
}

function memberzone_cus_request_page(){ 
		$data=get_listbooking_by_user();
		$new_content ='<table>';
		if ($data) {
			foreach ($data as $key => $value) {
			$new_content .='<tr><td>';	
				$image     =wp_get_attachment_image_src( get_post_thumbnail_id($value['post_id']), 'single-post-thumbnail' );
				$url_img   =$image[0];
				$permalink =get_permalink($value['post_id']);
				$post      =get_post($value['post_id']);
				
				$list_title 	=$post->post_title;
				switch ($value['booking_status']) {
					case 1:
						$list_time 		=$value['booking_expired'];
						$list_content	='Mohon kesabarannya untuk menunggu konfirmasi dari admin';
						$list_status	='Belum Terkonfirmasi Admin';
						//$list_action	='<a href="#" class="memberzone-button memberzone-button-primary">tinggalkan pesan</a>';
						break;
					case 2:
						$list_time 		=$value['booking_expired'];
						$list_content	='Selamat pemesanan anda sudah diketahui admin, <h3>Segera ambil buku '.$post->post_title.' diperpustakaan <h3>';
						$list_status	='Terkonfirmasi';
						$list_action	='<div class="txt'.$value['id'].'uid"><div/>';
						$list_action	.='<a href="#" class="memberzone-button memberzone-button-primary btn-recieved-book" id="'.$value['id'].'">konfirmasi pengambilan</a>';
						break;
					case 3:
						$log_pinjam_in=getdata_bykoland_id('log_peminjaman','waktu_masuk','id_booking',$value['id']);
						$d1 = new DateTime($log_pinjam_in);
						$log_pinjam_exp=getdata_bykoland_id('log_peminjaman','waktu_harus_kembali','id_booking',$value['id']);
						$d2 = new DateTime($log_pinjam_exp);
						$list_time 		= 'Tanggal kadaluarsa peminjaman <br/>'.$log_pinjam_exp;
						$list_content	='peminjaman berhasil dilakukan, kembalikan buku sesuai waktu yang sudah ditentukan <br/>';
						$id_rfid =getdata_bykoland_id('log_peminjaman','uid','id_booking',$value['id']);					
						$no_rfid =getdata_bykoland_id('uid_book','uid','id',$id_rfid);					
						$list_content	.='Kode RFID : <strong>'.$no_rfid.'</strong>';
						//$list_content .=$d1->diff($d2);
						
						$list_status	='Terpinjam';
						//$list_action	='<a href="#" class="memberzone-button memberzone-button-primary btn-recieved-book">konfirmasi pengambilan</a>';
						break;
				}
					ob_start();		
					include MEMBERZONE_UI.'templates/memberzone-ui-front-page.php';
					$new_content .=ob_get_clean();
			$new_content .='</td></tr>';
			}
		}else{
			$new_content    .='<tr><td>';
			$list_content    ='Mari uji coba langkah mudah memesan buku diperpustakaan';
			$list_action	 ='<a href="'.esc_url(home_url()).'" class="memberzone-button memberzone-button-primary">jelajahi sekarang</a>';
			$list_time	 	 =date('Y-m-d h:i:s');
			$list_status     ='kosong';
				ob_start();		
				include MEMBERZONE_UI.'templates/memberzone-ui-front-page.php';
				$new_content .=ob_get_clean();
			$new_content .='</tr></td>';
		}
		$new_content .='</table>';
		echo $new_content;	
	}


function memberzone_data_rfid(){
	add_menu_page('Data RFID', 'Daftar RFID', 'manage_options', 'rfid-page', array(__CLASS__,'memberzone_data_rfid_page'),'dashicons-list-view');
}
function memberzone_data_rfid_page()
{
	$data =get_alldata('uid_book');
	$thead_data=array('id'=>'aksi','uid'=>'kode rfid','type_uid'=>'jenis kode rfid','id_link_uid'=>'id terkait rfid');
	$thead ='<tr>';
	foreach ($thead_data as $khead => $valhead) {
		$thead .='<td>'.$valhead.'</td>';
	}
	$thead .='</tr>';
	$tbody ='<tr>';
	$tbody .='<td><input type="button" class="memberzone-button memberzone-button-primary btn-create-rfid" value="Tambah" /></td>';
	$tbody .='<td><input type="number" class="maxval uid" maxlength="25" /></td>';
	$tbody .='<td><select class="slc-jenis-uid">';
	$tbody .='<option value="0">pilih jenis rfid</option>';
	$tbody .='<option value="1">kartu anggota</option>';
	$tbody .='<option value="2">Buku</option>';
	$tbody .='</select></td>';
	$tbody .='<td><select class="show-id-linked">';
	$tbody .='</select></td>';
	$tbody .='<tr>';
	if ($data) {
		foreach ($data as $key => $value) {
			$tbody .='<tr>';	
			foreach ($thead_data as $kol => $isi) {
				$tbody .='<td>';
				$tbody .=$value[$kol];
				$tbody .='</td>';
			}
			$tbody .='</tr>';
		}
	}
	ob_start();				
	include MEMBERZONE_UI.'templates/memberzone-ui-list-booking.php';
	$content =ob_get_clean();
	echo $content;
}
function memberzone_peminjaman_langsung(){
	add_menu_page('Peminjam langsung', 'Langsung pinjam', 'subscriber', 'borrow-page', array(__CLASS__,'memberzone_langsung_pinjam_page'),'dashicons-list-view');
}
function memberzone_langsung_pinjam_page()
{
	echo "langsung pinjam";
}
	
}




