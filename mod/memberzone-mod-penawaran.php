<?php
class Memberzone_Module_Penawaran extends WP_Widget {
	private
		$plugin_name,
		$plugin_version;
	public function __construct() {

		parent::__construct(
			'memberzone_mod_penawaran',
			'Memberzone: Penawaran',
			array('description' => 'Formulir permintaan penawaran.')
		);
		
	}
	
	
	public function widget($args, $instance) {
		$get_opsi=get_cus_opsional();
		$post_id      = Memberzone_Base::get_post_id();
		$post_type    = get_post_type($post_id);

		$widget = $args['before_widget'];
		
		if (!empty($instance['title'])) {
			$widget .= $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}
		
		ob_start();
		include MEMBERZONE_UI . 'memberzone-ui-widget-penawaran.php';
		$widget .= ob_get_clean();
		
		$widget .= $args['after_widget'];
		
		if ($post_type != 'blog') {
			print $widget;
		}
	}
	
	public function form($instance) {
		$title = !empty($instance['title']) ? $instance['title'] : 'Permintaan Penawaran';
		ob_start();
		include MEMBERZONE_UI . 'memberzone-ui-swidget-penawaran.php';
		$form = ob_get_clean();
		print $form;
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		return $instance;
	}
	
	public function display_button() {
		$member_basic = Memberzone_Base::get_member_info(); 
		$member_extra = Memberzone_Base::get_member_extra();
		$post_id      = Memberzone_Base::get_post_id();
		
		ob_start();
		include MEMBERZONE_UI . 'memberzone-ui-penawaran.php';
		$penawaran = ob_get_clean();
		
		print $penawaran;
	}
	
	public function processing(){		
		global $wpdb;
		$id=$_POST['id'];
		$data=get_list_quoby_id($id);
		switch ($_POST['memberzone-penawaran-kirim']) {
			case 'Booking':
				$member_basic = Memberzone_Base::get_member_info();
				$postingan	  = get_post(memberzone_dekrip($_POST['id']));
				$data  = array_map('return_sanitize_text', $_POST);
				$unset = array('memberzone-penawaran-kirim','action','id');
				$data  = unset_larik($data,$unset);
				$data['user_id']		  =$member_basic->ID;
				$data['post_id']		  =intval(memberzone_dekrip($_POST['id']));
				$data['booking_inquired'] =date('Y-m-d h:i:s');
				$data['booking_expired']  =duedate();
				$data['booking_status']=1;
					ob_start();
					include MEMBERZONE_UI . 'email/memberzone-ui-penawaran-email.php';
					$email = ob_get_clean();
				if (!cek_daftar_booking($data['id_uid_book'])) {
					Memberzone_Base::post_email(
							get_option('memberzone_marketer'),
							get_option('admin_email'),
							$member_basic->user_email,
							'Pemesanan Buku berjudul ' .$postingan->post_title ,
							$email
						);
					insert_data('perpus_booking',$data);
					$no=6;
				}else{
					$no=5;
				}
				$permalink=get_permalink(memberzone_dekrip($_POST['id']));
				wp_redirect($permalink.'?e='.$no);
				exit();
				break;
			case 'perbaharui':
				if (isset($_POST['tabel']) && !cekosong($_POST['tabel'])) {
					$kolid=$_POST['kolid'];$id=$_POST['id'];$tabel=$_POST['tabel'];$data=array();
					$allpost=$_POST;
					$unset=array('memberzone-penawaran-kirim','action','permalink','id','tabel','kolid');
					$data=unset_larik($allpost,$unset);
					switch ($_POST['tabel']) {
						case 'custom_meta_key':
							($data['meta_opsional']==='true')? $data['meta_opsional']=1 : $data['meta_opsional']=0;
							break;
						case 'perpus_booking':
							$id=memberzone_dekrip($_POST['id']);
							$data['booking_expired']=duedate();
							break;
					}
					update_data($_POST['tabel'],$data,array($kolid=>$id));
				}				
				echo $_POST['permalink'];
				break;
			case 'insertdata':
				$allpost=$_POST;
				if (!cekosong($allpost)) {
					$unset=array('memberzone-penawaran-kirim','action','permalink','tabel');
					$data=unset_larik($allpost,$unset);
					switch ($_POST['tabel']) {
						case 'custom_meta_key':
							($data['meta_opsional']==='true')? $data['meta_opsional']=1 : $data['meta_opsional']=0;
							$data=array_merge($data,array('meta_key'=>str_replace(' ', '_', $_POST['meta_label'])));
							insert_data($_POST['tabel'],$data);
							break;
						case 'opsional_meta_key':
							if ($data['meta_key']=='id_uid_book') {
								insert_data('uid_book',array('status_tersedia'=>0,'uid'=>$data['opsional'],'post_id'=>intval($data['post_id'])));
							}else{
								unset($data['post_id']);
								insert_data($_POST['tabel'],$data);
							}							
							break;
						case 'log_peminjaman':
							$idbooking=memberzone_dekrip($data['id_booking']);
							$data['uid']=intval($data['uid']);
							$data['id_booking']=intval($idbooking);
							$data['waktu_harus_kembali']=duedate_pinjam();
							update_data('uid_book',array('status_uid'=>1),array('id'=>$data['uid']));
							update_data('perpus_booking',array('booking_status'=>3),array('id'=>$data['id_booking']));
							insert_data($_POST['tabel'],$data);
							wp_redirect(esc_url(admin_url('admin.php?page=list-booking-page')));
							exit();
							break;
						case 'log_kembalian':
							$data['id_peminjaman']=memberzone_dekrip($data['id_peminjaman']);
							$log_pinjam_exp		=getdata_bykoland_id('log_peminjaman','waktu_harus_kembali','id',$data['id_peminjaman']);
							$log_pinjam_expdate =substr($log_pinjam_exp,0,10);					
							$count_telat        =get_calculate_date($log_pinjam_expdate); 
							if ($count_telat > 0) {
								$data['jml_telat']=$count_telat;
							}
							insert_data($_POST['tabel'],$data);
							break;
						default:
							insert_data($_POST['tabel'],$data);
						break;
					}				
				}
				echo $_POST['permalink'];
				break;
			case 'deletedata':
				$allpost=$_POST;
				switch ($allpost['tabel']) {
					case 'custom_meta_key':
						delete_data($allpost['tabel'],array($allpost['kolid']=>$allpost['id']));
						delete_data('opsional_meta_key',array($allpost['kolid']=>$allpost['id']));
						break;
				}
				echo $_POST['permalink'];
				break;
			case 'get_idlinked_rfid':
				$tabel =$wpdb->prefix;
				$data=array();
				if (isset($_POST['jenis'])) {
					switch ($_POST['jenis']) {
					case '1':
						$blogusers =get_users('role=subscriber');
						foreach ( $blogusers as $user ) {
							$data[]=array('ID'=>$user->ID,'isi'=>$user->user_login);
						}
						echo json_encode($data);
						break;
					case '2':
						$args = array(
							'post_type' => array('post')
							,'post_status' => array('publish')
						);
						$the_query = new WP_Query($args);
						while ( $the_query->have_posts() ) : $the_query->the_post(); 
							$data[]=array('ID'=>$the_query->post->ID,'isi'=>$the_query->post->post_title);
						endwhile;
						echo json_encode($data);
						// Reset Post Data
						wp_reset_postdata();
						break;
					}

					
				}
				break;
			case 'update_profiluser':
				if(decrypt_url($_POST['id'])==$user->ID) {
					$allpost=$_POST;
					foreach($allpost as $key=> $value) {
						if (!cekosong($value)) {
							wp_update_user(array( 'ID' => $user->ID, $key => $value ));
							update_user_meta($user->ID,$key,$value);
						}
					}
				}
				wp_redirect(esc_url(admin_url('admin.php?page=profil-page')));
				exit();
				break;
			case 'cekpinjam':
				if (!cekosong($_POST)) {
					$data=array_map('return_sanitize_text', $_POST);
					$id_uid_book=getdata_bykoland_id('uid_book','id','uid',$data['uid']);
					if ($idbooking=getdata_bykoland_id('log_peminjaman','id_booking','uid',$id_uid_book)) {
						update_data('perpus_booking',array('booking_status'=>3),array('id'=>$idbooking));
						$no=8;						
					}else{
						$no=7;
					}
				}
				echo 'admin.php?page=request-page&e='.$no;
				break;
			case 'cekembali':
				if (!cekosong($_POST)){
					$data=array_map('return_sanitize_text', $_POST);
					if ($peminjaman_id=getdata_bykoland_id('log_kembalian','id_peminjaman','id_peminjaman',memberzone_dekrip($data['id_peminjaman']))) {
						$idbooking=getdata_bykoland_id('log_peminjaman','id_booking','id',$peminjaman_id);
						update_data('perpus_booking',array('booking_status'=>6),array('id'=>$idbooking));
						$no=10;
					}else{
						$no=9;
					}
				}
				echo 'admin.php?page=request-page&e='.$no;
				break;
		}
	}
	public function register_widgets() {
		register_widget('Memberzone_Module_Penawaran');
	}
	
	public function to_arp($larik=array()) {
		$arp = "http://email.jvm.co.id/a.php/sub/9/c35tv8";
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_USERAGENT, 'ARPR');
		curl_setopt($curl, CURLOPT_URL, $arp);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $larik);
		curl_exec($curl);
		curl_close($curl);
	}
}

/* Akhir dari berkas memberzone-mod-penawaran.php */



