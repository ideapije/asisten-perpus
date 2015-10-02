<?php
function getUriSegments() {
    return explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
}
function getUriSegment($n) {
    $segs = getUriSegments();
    return count($segs)>0 && count($segs) >= ($n-1 ) ? $segs[$n] : '';
}

//======================================== tambahkan metabox ============================================    
add_action( 'add_meta_boxes', 'detailbrg_box_add' );
function detailbrg_box_add(){
    add_meta_box( 'detailbrg-box-id', 'Data Produk Penawaran (informasi produk yang akan ditawarkan)', 'detail_barang', 'post', 'normal', 'high' );
}
function detail_barang($post){    
    $get_metakey=get_custom_metakey(); 
    wp_nonce_field('detailbrg_box_nonce','detailbrg_nonce'); 
    if ($get_metakey):
		include MEMBERZONE_UI.'templates/memberzone-ui-metabox-post.php';
    endif;
}

//do_action('show_user_profile',$profileuser);
//do_action('edit_user_profile',$profileuser);

add_action('show_user_profile','add_extra_social_links');
add_action('edit_user_profile','add_extra_social_links');

function add_extra_social_links(){
    $user = wp_get_current_user();
    include MEMBERZONE_UI.'memberzone-ui-profile.php';
}
add_action('personal_options_update','save_extra_sosial_links');
add_action('edit_user_profile_update','save_extra_sosial_links');

function save_extra_sosial_links(){
        $user = wp_get_current_user();
        $user_id=$user->ID;
        $larik=array('nohp','fax','attn','cc','ancus','telpacus','acus','anbil','telpabil','abil','anship','telpaship','aship');
        foreach ($larik as $key => $value) {
            update_user_meta( $user_id,$value, sanitize_text_field( $_POST[$value] ) );
        }
}

/*add_action( 'add_meta_boxes', 'visible_btn_quo' );
function visible_btn_quo(){
    add_meta_box( 'visible-btn-quo', 'Penampilan tombol quotation', 'visible_quo', 'post', 'side', 'high' );
}
function visible_quo($post){ 
	include MEMBERZONE_UI.'templates/memberzone-ui-visibe-button.php';
}*/


// widget code here

//add_action('wp_dashboard_setup', 'dashboard_quotation');

function dashboard_quotation() {
    if ( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $user = new WP_User( $user->ID );
        if ($user->caps['administrator']=='administrator') {
            global $wp_meta_boxes;
            wp_add_dashboard_widget('quotation_act_widget', 'Quotation Activity', 'quo_dashboard_act','normal','high');
        }
    }
}

function quo_dashboard_act() {
    include MEMBERZONE_UI.'templates/memberzone-ui-listquo.php';
}


add_action('wp_dashboard_setup', 'memberzone_dashboardnotif');

function memberzone_dashboardnotif() {
    if ( is_user_logged_in() ) {
		global $wp_meta_boxes;
		wp_add_dashboard_widget('memberzone_dash_notif', 'Memberzone Remainder', 'memberzone_notif','normal','high');
    }
}

function memberzone_notif() {
	$msg ='<div class="updated notice is-dismissible" id="message">';
	switch (get_userrole()) {
			case 'subscriber':
				if (cekalmat()) { 	
					$msg .='<a href="'.esc_url(admin_url('/admin.php?page=profil-page')).'"><h1>Perbaharui Data Pribadi</h1></a>';
				}
				break;
			case 'administrator':
				if ( !get_option( 'users_can_register' ) ) { 	
					$msg .='<p>Checklist membership dimenu <strong>Settings->General</strong> untuk memudahkan pengunjung mendaftar sebagai MEMBER '.get_bloginfo('name').'</p>';
				}
				break;
	}
	$msg .='<button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button>';
	$msg .='</div>';
	echo $msg;
}

function cek_daftar_booking($iduid=''){
    if (!cekosong($iduid)) {
        global $wpdb;
        $member_basic = Memberzone_Base::get_member_info(); 
        $t5           = $wpdb->prefix.'perpus_booking';
        $sql          = "SELECT * FROM `$t5` WHERE `$t5`.`id_uid_book`=$iduid AND `$t5`.`user_id`=$member_basic->ID";
        $query        = $wpdb->get_results($sql,ARRAY_A);
        return $query;
    }
}

 function get_meta_values( $key = '', $type = 'post', $status = array('publish','draft') ) {
  global $wpdb;

  if( empty( $key ) )
  return;
  $status = implode(',', $status);
  $r = $wpdb->get_col( $wpdb->prepare( "
    SELECT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s' 
    AND p.post_status IN ({$status})
    AND p.post_type = '%s'
    LIMIT 10", $key, $type ) );

 return $r;
}

function cekosong($allpost){
    $empty=array();
    if (is_array($allpost)) {
        foreach ($allpost as $k=>$field) {
        $rtrf=rtrim($field);
            if ((!strlen($field)) || (empty($rtrf)) || ($rtrf==='0') || is_null($rtrf)) {
                $empty[]=$k;
            }
        }
        if (count($empty) > 0){  return $empty;
        }else{ return false; }
    }else{ 
        $rtrf=rtrim($allpost);
        if ((empty($rtrf)) || (!strlen($allpost)) || ($rtrf==='0') || is_null($rtrf)) { return true;
        }else{ return false; }
    }
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

function get_noquo($id=false){
    global $wpdb;
    $t4=$wpdb->prefix.'list_quo';
    if ($id) {
        $get_noquo = $wpdb->get_results("SELECT * FROM $t4 WHERE id='$id'", ARRAY_A );   
    }else{
        $get_noquo = $wpdb->get_results("SELECT * FROM $t4 ORDER BY noquo DESC LIMIT 1", ARRAY_A );   
    }
    if (count($get_noquo) > 0) {
        foreach ($get_noquo as $val) {
            return $val['noquo'];
        }
    }
    return false;
}


function get_list_quoby_id($idq='',$foruser=false){
        if (!cekosong($idq)) {
            global $wpdb;
            $t4=$wpdb->prefix.'list_quo';
            if ($foruser && !current_user_can( 'manage_options' )) {
            	$user=wp_get_current_user();
            	$sqlquo="SELECT * FROM $t4 WHERE id=$idq AND idcus=$user->ID";
            }else{
				$sqlquo="SELECT * FROM $t4 WHERE id=$idq";
            }
            $get_lquo=$wpdb->get_results($sqlquo,ARRAY_A);
            foreach ($get_lquo as $key => $value) {
                $getval=array_map('detail_quo_val', $value,array_keys($value));
            }
            $data=array(
                'tgl'=>date('Y-m-d'),
                'attn'=>esc_attr(get_the_author_meta('attn', $getval[2]['id'])),
                'kdquo'=>$getval[1]['seri'],
                'memberzone-penawaran-produk'=>$getval[2]['id'],
                'cc'=>esc_attr(get_the_author_meta('cc', $getval[2]['id'])),
                'telp'=>esc_attr(get_the_author_meta('nohp', $getval[2]['id'])),
                'ancus'=>esc_attr(get_the_author_meta('ancus', $getval[2]['id'])),
                'telpacus'=>esc_attr(get_the_author_meta('telpacus', $getval[2]['id'])),
                'acus'=>esc_attr(get_the_author_meta('acus', $getval[2]['id'])),
                'anbil'=>esc_attr(get_the_author_meta('anbil', $getval[2]['id'])),
                'telpabil'=>esc_attr(get_the_author_meta('telpabil', $getval[2]['id'])),
                'alamat_bill'=>esc_attr(get_the_author_meta('abil', $getval[2]['id'])),
                'anship'=>esc_attr(get_the_author_meta('anship', $getval[2]['id'])),
                'telpaship'=>esc_attr(get_the_author_meta('telpaship', $getval[2]['id'])),
                'alamat_ship'=>esc_attr(get_the_author_meta('aship', $getval[2]['id'])),
                'faks'=>esc_attr(get_the_author_meta('fax', $getval[2]['id'])),
                'id_user'=>$getval[2]['id'],
                'penerima'=>$getval[2]['uname'],
                'email'=>$getval[2]['email'],
                'qty'=>$getval[4],
                'disc'=>$getval[3]['diskon'],
                'price'=>$getval[3]['hrgd'],
                'subtotal'=>intval($getval[3]['hrg']*$getval[4]),
                'produk'=>$getval[3]['title'],
                'notebrg'=>$getval[3]['notebrg'],
                'opsional'=>$getval[5]
                ,'id'=>$getval[0],
                'status'=>$getval[9],
                'exp_time'=>$getval[7],
                'noquo'=>$getval[1]['asli']
            );
            return $data;
        }
        return false;
}

function get_listbooking_by_user(){
	global $wpdb;
	$t4        =$wpdb->prefix.'perpus_booking';
	$user      =Memberzone_Base::get_member_info();
	$sqlquo    ="SELECT * FROM $t4 WHERE `user_id`=$user->ID AND `booking_status` NOT IN(5)";
	$result    =$wpdb->get_results($sqlquo,ARRAY_A);
	return $result;
}


function get_data_table($tabel='',$kol=array(),$id=false,$count=false){
    global $wpdb;
    $tabel=$wpdb->prefix.$tabel;
    if (is_array($kol)) {
        $select=implode(',', $kol);
    }
    $nkol=count($kol);
    ($id)? $sql="SELECT $select FROM $tabel WHERE id=$id" : $sql="SELECT $select FROM $tabel";
    $query=$wpdb->get_results($sql,ARRAY_A);
    if (count($query) > 0 && !cekosong($kol)) {
        if ($count) {
            return count($query);
        }else{
            $send=array();$wew=array();
            foreach ($query as $value) {
                for ($x=0; $x < $nkol; $x++) { 
                    $send[$kol[$x]]=$value[$kol[$x]];
                }
                if (count($kol)==1) {
                    $wew[]=$value[$kol[0]];
                }else{
                    $wew[]=$send;
                }
            }
            if (count($kol)==1 && count($query)==1) {
                return implode('',$send);
            }else{
                return $wew;
            }
        }
    }
    return false;
}
function return_md5($val){
    return md5($val);
}
function return_sanitize_text($val){
    return sanitize_text_field($val);
}




/** 
 * Retrieve a post given its title. 
  * 
 * @uses $wpdb 
 * 
 * @param string $post_title Page title 
 * @param string $output Optional. Output type. OBJECT, ARRAY_N, or ARRAY_A. 
 * @return mixed 
 */ 
 function get_post_by_title($page_title, $output = OBJECT) { 
      global $wpdb; 
        $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='post'", $page_title )); 
         if ( $post ) 
             return get_post($post, $output);  
        return null; 
} 

function get_keys_for_duplicate_values($my_arr, $clean = false) {
    if ($clean) {
        return array_unique($my_arr);
    }

    $dups = $new_arr = array();
    foreach ($my_arr as $key => $val) {
      if (!isset($new_arr[$val])) {
         $new_arr[$val] = $key;
      } else {
        if (isset($dups[$val])) {
           $dups[$val][] = $key;
        } else {
           $dups[$val] = array($key);
        }
      }
    }
    return $dups;
}

function send_mail_attc($to, $from, $name, $subject, $msg, $attachment = FALSE) {
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: '.$name.'<'. $from .'>' . "\r\n";
    if (file_exists($attachment)) {
        $attachments=array($attachment);
        wp_mail($to, $subject, $msg, $headers, $attachments);
        return true;
    }
    return false;
}


function recursiveRemoveDirectory($directory)
{
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) { 
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
}

function detail_quo_val($item,$key){
    $postid=array();
    switch ($key) {
        case 'noquo':
            $no=array();
            $no['asli']=$item;
            $no['seri']='THC/QUO/'.date('m').'/'.date('d').'/'.$item;
            $new_content =$no;
            break;
        case 'memberzone-penawaran-produk':
            $postid['id']=$item;
            $postingan=get_post($item);
            $met_dis=get_post_meta($item,'met_dis', true);
            $brgdiskon=get_post_meta($item,'brgdiskon', true);
            $hrgp=get_post_meta($item,'hrgp', true);
            $brghrg=get_post_meta($item,'brghrg', true);
            if (strlen($hrgp) > 0 && $brghrg > $hrgp) {
                $price=$hrgp;
            }else{
                $price=$brghrg;
            }
			$postid['title']=$postingan->post_title;
            $postid['notebrg']=get_post_meta($item,'noteprod', true);
            $postid['hrgd']=$price;
            $postid['hrg']=$price;
            switch ($met_dis) {
                case '6':
                    $postid['diskon']='Rp '.$brgdiskon.',-';
                break;
                case '7':
                    $postid['diskon']=$brgdiskon.' %';
                break;
            }
            $new_content =$postid;
        break;
        case 'idcus':
            $users=array();
            $user=get_user_by('id',$item);
            $users['id']=$item;
            $users['uname']=$user->user_login;
            $users['email']=$user->user_email;
            $new_content =$users;
        break;
        default:
            $new_content .=$item;
        break;
    }
    return $new_content;
}

function get_custom_metakey($id=false) {
	global $wpdb;
	$t1=$wpdb->prefix.'custom_meta_key';	
	if ($id) {
        $query="SELECT * FROM $t1 WHERE id='$id'"; //
    }else{
        $query="SELECT * FROM $t1"; //
    }
    $result=$wpdb->get_results($query, ARRAY_A );
	return $result;
}
function get_cus_opsional($kol=false){
	global $wpdb;	
	$t1=$wpdb->prefix.'custom_meta_key';
	if ($kol) {
		$query="SELECT $kol FROM $t1 WHERE meta_opsional=1"; 
		$result=$wpdb->get_results($query, ARRAY_A );
		$send=array();
		foreach($result as $row) {
			$send[]=$row[$kol];
		}
		$result=$send;
	}else{
		$query="SELECT * FROM $t1 WHERE meta_opsional=1"; 
		$result=$wpdb->get_results($query, ARRAY_A );
	}
	return $result;
	
}

function get_opsional_custom_metakey($m_key='',$post_id) {
	if(cekosong($m_key)){
		return false;
	}else{
        global $wpdb;
        $send=array();
        switch ($m_key) {
            case 'id_uid_book':
                $tabel = $wpdb->prefix.'uid_book';
                $query = "SELECT * FROM $tabel WHERE post_id=$post_id";
                $result=$wpdb->get_results($query, ARRAY_A );
                foreach ($result as $key => $value) {
                        $send[$key]['id']=$value['id'];
                        $send[$key]['opsional']=$value['uid'];
                }
                break;
            default:
                $tabel = $wpdb->prefix.'opsional_meta_key';
                $query = "SELECT * FROM $tabel WHERE meta_key='$m_key'";
                $result=$wpdb->get_results($query, ARRAY_A );
                foreach ($result as $key => $value) {
                    
                        $send[$key]['id']=$value['id'];
                        $send[$key]['opsional']=$value['opsional'];
                    
                }
                break;
        }
		return $send;
	}
	
}



function wp_exist_post_by_title($title_str) {
	global $wpdb;
	return $wpdb->get_row("SELECT * FROM wp_posts WHERE post_title = '" . $title_str . "'", 'ARRAY_A');
}

function unset_larik($larik,$unset) {
	foreach($unset as $value) {
		unset($larik[$value]);
	}
	return $larik;
}
function get_message_user() {
	global $wpdb;$t5=$wpdb->prefix.'pesan';
	$user=wp_get_current_user();
	$query="SELECT * FROM $t5 WHERE iduser=$user->ID";
	$result=$wpdb->get_results($query,ARRAY_A);
	return $result;
}
function get_alldata($tabel=''){  
    if (!cekosong($tabel)) {
        global $wpdb;   
        $tabel=$wpdb->prefix.$tabel;
        if ($result=$wpdb->get_results("SELECT * FROM $tabel",ARRAY_A)) {
            return $result;
        }
    }
    return false;
    
}
function insert_data($tabel='',$data=array(),$noprefix=false){	
	if (!cekosong($tabel)) {
		global $wpdb;	
        if (!$noprefix) {
            $tabel=$wpdb->prefix.$tabel;   
        }
		$wpdb->insert($tabel,$data);
	}
	
}
function update_data($tabel='',$data=array(),$id=array()) {
		global $wpdb;	
		$tabel=$wpdb->prefix.$tabel;
		return ($wpdb->update($tabel,$data,$id))? true : false;
}
function delete_data($tabel='',$id=array()) {
	if (!cekosong($tabel) && !cekosong($id)) {
		global $wpdb;	
		$tabel=$wpdb->prefix.$tabel;
		return $wpdb->delete($tabel,$id);
	}
}

function duedate(){
    
	$duedate=date_create(date('Y-m-d'));
	if (intval(get_option('memberzone_marketer')['exp_time']) <=60 ) {
        $n=get_option('memberzone_marketer')['exp_time'];
        $exptime=$n.' minutes';
    }else if (is_null(get_option('memberzone_marketer')['exp_time'])) {
        $exptime='3 hours';
    }else{
        $n=get_option('memberzone_marketer')['exp_time'];
        $n=intval($n/60);
        $exptime=$n.' hours';
    }
	date_add($duedate,date_interval_create_from_date_string($exptime));
	return date_format($duedate,'Y-m-d h:i:s');
}

function duedate_pinjam(){
    
    $duedate=date_create(date('Y-m-d'));
    date_add($duedate,date_interval_create_from_date_string('3 days'));
    return date_format($duedate,'Y-m-d h:i:s');
}

function  get_post_idlistquo($id) {
	global $wpdb;
	$tabel=$wpdb->prefix.'list_quo';
	$sql="SELECT `memberzone-penawaran-produk` FROM $tabel WHERE id=$id";
	$result=$wpdb->get_results($sql,ARRAY_A);
	if ($result && count($result) > 0) {
		foreach($result as $value) {
			return $value['memberzone-penawaran-produk'];
		}
		
	}
	
}

function cek_usermeta($get=false){
	$user = wp_get_current_user();
	$data=get_user_meta($user->ID);
	if ($get) {
		return wp_get_current_user();
	}else{
		return cekosong($data);
	}
}


//menambahkan menu dashboard untuk pengguna subscriber
add_action('admin_menu','my_profilmenu');

function my_profilmenu(){
	add_menu_page('Profilku', 'Data Pribadi', 'subscriber', 'profil-page', 'profilpage');
}

function profilpage(){
	ob_start();				
	include MEMBERZONE_UI.'templates/memberzone-ui-profil-user.php';
	$new_content = ob_get_clean();		
	echo $new_content;	
}


//menambahkan custom style 
function custom_admin_head() { ?>
	<link rel="stylesheet" type="text/css" href="<?php echo MEMBERZONE_AST.'css/memberzone.css';?>">
<?php 
}

add_action( 'admin_head', 'custom_admin_head' );
//menambahkan custom javascript dan jquery
function custom_admin_footer() { ?>
	<script src="<?php echo MEMBERZONE_AST . 'js/jquery-1.9.1.js';?>"></script>
	<script src="<?php echo MEMBERZONE_AST . 'js/jquery.maxlength.js';?>"></script>
	<script src="<?php echo MEMBERZONE_AST . 'js/j-admin.js';?>"></script>
	
<?php 
}
add_action( 'admin_footer', 'custom_admin_footer' );

function getpay($noquo,$kol) {
	$user = wp_get_current_user();
	global $wpdb;
	$tabel=$wpdb->prefix.'pay';
	if (current_user_can( 'manage_options' )) {
		$sql="SELECT * FROM $tabel WHERE noquo='$noquo'";
	}else{
		$sql="SELECT * FROM $tabel WHERE iduser=$user->ID AND noquo='$noquo'";
	}
	$result=$wpdb->get_results($sql,ARRAY_A);
	if (is_array($result) && count($result) > 0 ) {
		foreach($result as $value) {
			return $value[$kol];
		}
	}
}

function count_url() {
	$path = $_SERVER['REQUEST_URI'];  
	$itung=intval(count(explode('/',$path))-1);
	return $itung;
}

function cekalmat() {
	$user = wp_get_current_user();
	$cek=array('nohp','fax','attn','cc','ancus','telpacus','acus','anbil','telpabil','abil','anship','telpaship','aship');
	$count=0;
	foreach($cek as $value) {
		if (cekosong(get_the_author_meta($value, $user->ID))) {
			$count++;
		}
	}
	if ($count > 0) {
		return true;
	}
	return false;
}
function get_userrole() {
	$user = wp_get_current_user();
	$user = new WP_User($user->ID);
	if (is_user_logged_in()) {
		if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
			foreach ( $user->roles as $role ){
				return $role;
			}
		}
	}
	
}



//------------------------field registrasi dan login --------------------------------

function memberzone_reg_field(){
		ob_start(); ?>
		<h3 class="memberzone_header"><?php _e('Register New Account');?></h3>
	<?php
		memberzone_show_error_messages(); ?>
		<form id="memberzone_registration_form" class="memberzone_form" action="" method="POST">
			<fieldset>
				<p>
					<label for="memberzone_user_Login"><?php _e('Username'); ?></label>
					<input name="memberzone_user_login" id="memberzone_user_login" class="required" type="text"/>
				</p>
				<p>
					<label for="memberzone_user_email"><?php _e('Email'); ?></label>
					<input name="memberzone_user_email" id="memberzone_user_email" class="required" type="email"/>
				</p>
				<p>
					<label for="memberzone_user_first"><?php _e('First Name'); ?></label>
					<input name="memberzone_user_first" id="memberzone_user_first" type="text"/>
				</p>
				<p>
					<label for="memberzone_user_last"><?php _e('Last Name'); ?></label>
					<input name="memberzone_user_last" id="memberzone_user_last" type="text"/>
				</p>
				<p>
					<label for="password"><?php _e('Password'); ?></label>
					<input name="memberzone_user_pass" id="password" class="required" type="password"/>
				</p>
				<p>
					<label for="password_again"><?php _e('Password Again'); ?></label>
					<input name="memberzone_user_pass_confirm" id="password_again" class="required" type="password"/>
				</p>
				<p>
					<input type="hidden" name="memberzone_register_nonce" value="<?php echo wp_create_nonce('memberzone-register-nonce'); ?>"/>
					<input type="submit" value="<?php _e('Register Your Account'); ?>"/>
				</p>
			</fieldset>
		</form>
	<?php
		return ob_get_clean();
	}
	
	function memberzone_login_field(){
		ob_start(); ?>
		<h3 class="memberzone_header"><?php _e('Login'); ?></h3>
		<?php memberzone_show_error_messages();?>
		<form id="memberzone_login_form"  class="memberzone_form"action="" method="post">
			<fieldset>
				<p>
					<label for="memberzone_user_Login">Username</label>
					<input name="memberzone_user_login" id="memberzone_user_login" class="required" type="text"/>
				</p>
				<p>
					<label for="memberzone_user_pass">Password</label>
					<input name="memberzone_user_pass" id="memberzone_user_pass" class="required" type="password"/>
				</p>
				<p>
					<input type="hidden" name="memberzone_login_nonce" value="<?php echo wp_create_nonce('memberzone-login-nonce'); ?>"/>
					<input id="memberzone_login_submit" type="submit" value="Login"/>
				</p>
			</fieldset>
		</form>
	<?php
		return ob_get_clean();
	}
	
	function error_errors() {
		static $wp_error;
		return isset($wp_error)? $wp_error : ($wp_error=new WP_Error(null,null,null));
	}
	function memberzone_show_error_messages() {
		if ($codes=memberzone_errors()->get_error_codes() ) {
			$cetak ='<div class="memberzone_errors" >';
			foreach($codes as $code) {
				$message =memberzone_errors()->get_error_message($code);
				$cetak .='<span class="error"><strong>'.__('Error').'</strong>:'.$message.'</span><br/>';
			}
			$cetak .='<div>';
			return $cetak;
			
		}
		
	}
    function get_list_fields($tabel='')
    {
        if (!cekosong($tabel)) {
            global $wpdb;
            $tabel=$wpdb->prefix.$tabel;
            $kolom=array();
            $result=$wpdb->get_results("SHOW COLUMNS FROM $tabel",ARRAY_A);
            $result2=$wpdb->get_col( "DESC " . $tabel, 0 );
            if ($result) {
                foreach ($result as $column_name) {
                    $kolom[]=$column_name['Field'];
                }
                return $kolom;
            }elseif ($result2) {
				foreach($result2 as $col) {
					$kolm[]=$col;
				}
				return $kolm;
            }
            //$result=$wpdb->query("COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = $tabel",ARRAY_A);
        }
        return false;
    }
	function is_numberik_inlarik($val) {
		if (is_numeric($val)) {
			return intval($val);
		}else{
			return $val;
		}
	}
	
	function  getdata_bykoland_id($tabel='',$kol='',$kolid='',$id='',$noprefix=false){
		if (!cekosong(array($tabel,$kol,$kolid,$id))) {
			global $wpdb;
            if (!$noprefix) {
                $tabel=$wpdb->prefix.$tabel;
            }
            $hasil=$wpdb->get_results("SELECT * FROM $tabel WHERE $kolid='$id'",ARRAY_A);
            if ($hasil) {
				$send=array();
            	foreach($hasil as $key =>$value) {
					$send[]=$value[$kol];
            	}
            	if (count($send)===1) {
            		return implode($send,'');
            	}else{
					return $send;
            	}
            }
		}
		return false;
	}	
	
	
	function return_explode_noquo($val) {
		$val=explode('-',$val);
		return $val[1];
	}
	
	function get_diff_timestamp($start_ts, $end_ts) {
		$diff = $end_ts - $start_ts;
		return $diff;
		//return round($diff / 86400);
	}
	function get_mysaldo() {
		$user=wp_get_current_user();
		$sisa=getdata_bykoland_id('member_saldo','sisa','idcus',$user->ID);
		$pakai=getdata_bykoland_id('member_saldo','pakai_total','idcus',$user->ID);
		$total=getdata_bykoland_id('member_saldo','total','idcus',$user->ID);
		if ($pakai!==$total && $sisa> 0 ) {
			return $sisa;
		}elseif ($pakai==0 && $total > 0) {
			return $total;
		}else{
			return false;
			
		}
	}
	function memberzone_enkrip( $q ) {
		$cryptKey  = 'Iw$nF1rm4w@n';
		$qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
		return( $qEncoded );
	}
	function memberzone_dekrip( $q ) {
		$cryptKey  = 'Iw$nF1rm4w@n';
		$qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
		return( $qDecoded );
	}
	function get_date_diff($date2){
        $date1=date('Y-m-d');
        if (!cekosong(array($date1,$date2))) {
            $diff = abs(strtotime($date2) - strtotime($date1));
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            return array($years,$months,$days);
        }
        return false;
    }

    function get_calculate_date($duedate){
         $now = time(); // or your date as well
         $duedate = strtotime($duedate);
         $datediff = $now - $duedate;
         return floor($datediff/(60*60*24));
    }

