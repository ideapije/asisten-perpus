<?php

class Memberzone_Base {
	protected
		$loader,
		$plugin_name,
		$plugin_version;
	
	public function __construct() {
		$this->plugin_name    = 'memberzone';
		$this->plugin_version = '1.0.0';
		
		$this->load_dependencies();
		$this->define_hooks();
	}
	
	private function define_hooks() {
		$admin_hooks = new Memberzone_Admin($this->plugin_name, $this->plugin_version);
		$this->loader->add_action('wp_enqueue_scripts', $this, 'enqueue_styles' );
		$this->loader->add_action('admin_menu', $admin_hooks, 'create_option_menu');
		$this->loader->add_action('admin_init', $admin_hooks, 'register_settings');

		//$this->loader->add_action('widgets_init', 'Memberzone_Module_Penawaran', 'register_widgets');
		$this->loader->add_action('admin_post_memberzone_penawaran', 'Memberzone_Module_Penawaran', 'processing');
		
		$this->loader->add_action('init','Member_tambahan', 'set_permalink');		
		//$this->loader->add_action('init','Member_tambahan', 'cetakpdf');		
		$this->loader->add_action( 'admin_head','Member_tambahan','hapus_pemberitahuan_update_wp_for_user', 1 );
		$this->loader->add_action('init','Member_tambahan', 'fungsi_init');		
		$this->loader->add_action('save_post','Member_tambahan', 'detailbarang_save');
		$this->loader->add_action('the_content','Member_tambahan', 'the_content_filter');
		$this->loader->add_action('init', 'Member_tambahan', 'add_meta_label');
		$this->loader->add_action('init', 'Member_tambahan', 'allow_html');
		//$this->loader->add_action('dashboard_glance_items','Member_tambahan','count_req_quo');	
		$this->loader->add_action('login_message','Member_tambahan', 'pesan_setelahregister');
		$this->loader->add_action('init','Member_tambahan','page_about_quo');
		$this->loader->add_filter('comments_open','Member_tambahan','disable_comment_onpage'); 
		$this->loader->add_action('admin_menu','Member_tambahan','submenu_post_opsional'); 
		$this->loader->add_action('admin_menu','Member_tambahan','admin_menu_list_booking'); 
		$this->loader->add_action('admin_menu','Member_tambahan','memberzone_data_rfid'); 
		$this->loader->add_action('admin_menu','Member_tambahan','memberzone_peminjaman_langsung'); 

		$this->loader->add_action('admin_menu','Member_tambahan','memberzone_cus_request'); 
		$this->loader->add_action('admin_menu','Member_tambahan','hapus_menu_dashboard_kecuali_admin'); 
		
		$this->loader->add_action('admin_bar_menu','Member_tambahan','toolbar_link_to_qoutation', 999 );
		
		
		/*$this->loader->add_shortcode('register_form','Member_tambahan','memberzone_form_registrasi');
		$this->loader->add_shortcode('login_form','Member_tambahan','memberzone_login_form');
		$this->loader->add_action('init','Member_tambahan','memberzone_login_member');
		$this->loader->add_action('init','Member_tambahan','memberzone_add_new_member');*/
		
		//$this->loader->add_action('plugins_loaded','Member_tambahan','remove_admin_bar');	
	}
	
	protected function get_plugin_name() {
		return $this->plugin_name;
	}
	
	protected function get_plugin_version() {
		return $this->plugin_version;
	}
	
	protected function load_dependencies() {
		require_once MEMBERZONE_LIB . 'memberzone-loader.php';
		require_once MEMBERZONE_LIB . 'memberzone-admin.php';
		
		require_once MEMBERZONE_MOD . 'memberzone-mod-penawaran.php';
		require_once MEMBERZONE_MOD . 'memberzone-mod-tambahan.php';
		
		require_once MEMBERZONE_MOD . 'memberzone-mod-functions.php';
		$this->loader = new Memberzone_Loader();
	}
	
	public function enqueue_styles() {
		wp_enqueue_style($this->plugin_name, MEMBERZONE_AST . 'css/memberzone.css', array(), $this->plugin_version, 'all');
		wp_enqueue_script('jquery-1.9.1', MEMBERZONE_AST . 'js/jquery-1.9.1.js', array('jquery'));
		wp_enqueue_script('j-admin', MEMBERZONE_AST . 'js/j-admin.js', array('jquery'), $this->plugin_version, false );
		
		/*if (isset($_GET['page']) && $_GET['page']=='request-page') {
			
		}*/
		wp_enqueue_script('jquery.maxlength', MEMBERZONE_AST . 'js/jquery.maxlength.js',array('jquery'));
		
	}
	
	
	public function get_member_info() {
		$data = wp_get_current_user();
		return $data;
	}
	
	public function get_member_extra() {
		$data['NAMALENGKAP'] = 'tri arum azhary';
		//get_cimyFieldValue(get_current_user_id(), 'NAMALENGKAP');
		$data['HANDPHONE']   = '085726720879';
		//get_cimyFieldValue(get_current_user_id(), 'HANDPHONE');
		$data['PERUSAHAAN']  = 'cv bintang kejora';
		//get_cimyFieldValue(get_current_user_id(), 'PERUSAHAAN');
		$data['ALAMAT']      = 'Jl. DI panjaitan no.128';
		//get_cimyFieldValue(get_current_user_id(), 'ALAMAT');
		return $data;
	}
	
	public function get_post_id() {
		global $wp_query;	
		return $wp_query->post->ID;
	}
	function get_content($url){
     	$data = curl_init();
     	curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
     	curl_setopt($data, CURLOPT_URL, $url);
     	$hasil = curl_exec($data);
     	curl_close($data);
     	return $hasil;
	}
	
		
	public function post_email($to, $sender, $email, $subject, $message) {
		$headers  = 'MIME-Version: 1.0' . "\r\n";
    	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: ' . $sender . ' <' . $email . '>' . "\r\n";
		$subject = $subject;
		wp_mail($to, $subject, $message, $headers);
	}

	
	public function post_email_att($to,$subject, $message,$post_id,$doc_id) {
		ob_start();
		//global $wpdb;
		$namafile = 'Quotation No.'.$post_id.'.pdf';
		$fileType = "application/x-pdf";
		$infoweb=get_option('memberzone_marketer');
		$headers ='From: ' . $infoweb['email'] . ' <' . bloginfo('name') . '>' . "\r\n";
   		$fileContent = Memberzone_Base::get_content(site_url('/pdf/?di='.$doc_id.'&id='.encrypt_url($post_id)));   
   		$data = chunk_split(base64_encode($fileContent));
		
   		$semi_rand = md5(time());
   		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
   		$headers .= "MIME-Version: 1.0\n" .
              "Content-Type: multipart/mixed;\n" .
              " boundary=\"{$mime_boundary}\"";
   		$pesan = "This is a multi-part message in MIME format.\n\n" .
            "--{$mime_boundary}\n" .
            "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
            "Content-Transfer-Encoding: 7bit\n\n" .
            $message . "\n\n";
   		$data = chunk_split(base64_encode($fileContent));
   		$pesan .= "--{$mime_boundary}\n" .
             "Content-Type: {$fileType};\n" .
             " name=\"{$namafile}\"\n" .
             "Content-Disposition: attachment;\n" .
             " filename=\"{$namafile}\"\n" .
             "Content-Transfer-Encoding: base64\n\n" .
             $data . "\n\n" .
             "--{$mime_boundary}--\n"; 
        mail($to, $subject, $pesan, $headers);
		//wp_mail($to, $subject, $message, $headers,$attachments);
		// wp_mail( $to, $subject, $message, $headers, $attachments );
	}
	
	public function run() {
		$this->loader->load();
	}

	
	
}

/* Akhir dari berkas base.php */
