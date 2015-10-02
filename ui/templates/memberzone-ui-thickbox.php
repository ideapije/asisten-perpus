<?php 
$content='';$selector='';$label='';$css_class='thickbox';
if (isset($_GET['action']) && $_GET['action']==='edit'):
	$params=array('post'=>$_GET['post'],'action'=>'edit');
	$permalink=esc_url(admin_url('post.php?')).http_build_query($params, '', "&");
else: 
	$permalink=esc_url(admin_url('/post-new.php'));
endif;
if (isset($toshow) && !cekosong($toshow)) {
	switch ($toshow) {
		case 'pinjamkan':
			$content .='<form method="post" action="'.esc_url(admin_url('admin-post.php')).'">';
			$content .='<table>';
			$content .='<tr>';
			$content .='<td><strong name="post_id">'.$postingan->post_title.'</strong></td>';
			$content .='<td><select name="uid">';
			$optio_uid=getdata_bykoland_id('uid_book','uid','id_link_uid',$vbody['post_id']);
			$optio_id=getdata_bykoland_id('uid_book','id','id_link_uid',$vbody['post_id']);

			if ($optio_uid && is_array($optio_uid))  {
				
				foreach ($optio_uid as $kouid => $valuid) {
					$content .='<option value="'.$optio_id[$kouid].'">'.$optio_uid[$kouid].'</option>';	
					
				}
			}else if ($optio_uid) {				
				$content .='<option value="'.$optio_id.'">'.$optio_uid.'</option>';	
			}
			$content .='</select></td>';
			$content .='</tr>';
			$content .='<tr>';
			$content .='<td colspan="2"><input type="hidden" value="'.memberzone_enkrip($vbody['id']).'" name="id_booking" /></td>';	
			$content .='</tr>';
			$content .='<tr>';
			$content .='<td colspan="2">
			<input type="hidden" value="memberzone_penawaran" name="action" />
			<input type="hidden" name="memberzone-penawaran-kirim" value="insertdata" />
			<input type="hidden" name="tabel" value="log_peminjaman" />
			
			<button type="submit" class="memberzone-button memberzone-button-primary">pinjamkan</button>
			</td>';	
			$content .='</tr>';
			$content .='</table>';
			$content .='</form>';
			$selector=$vbody['id'];
			$label='pinjamkan';
			$css_class='thickbox button button-primary';
			break;
		case 'image':
			$content .='<img src="'.$valimg['url'].'"  />';
			$label=$valimg['url'];
			$selector=$valimg['id'];			
			break;
		case 'add_metabox':
			$selector='1';
			$label='Tambal Opsional';

			$css_class=$css_class.' memberzone-button';
			ob_start();
			include MEMBERZONE_UI.'dashboard-admin/post-admin/add-metabox.php';
			$content .=ob_get_clean();
			break;
		case 'login':
			$selector='login';
			$css_class=$css_class.' memberzone-button memberzone-button-primary memberzone-width-100';
			$label='Login untuk booking buku';
			if (get_option( 'users_can_register')): 
				$content .='<span id="imgurl" style="display:none;">'.MEMBERZONE_AST.'images/ajax-loader.gif'.'</span>';
				$content .='<p style="color:#000;background:#F5D76E;padding:5px;">';
				$content .='Belum memilki akun? klik <a href="'.wp_registration_url().'" class="button button-primary " > mendaftar</a> untuk menjadi anggota';
				$content .='</p>';
			else:
				$content .='<p style="color:#000;background:#F5D76E;padding:5px;">';
				$content .='Belum memilki akun? silahkan hubungi email ini <a href="mailto:'.bloginfo("admin_email").'"></a> untuk mendaftarkan anda sebagai anggota';
				$content .='</p>';
			endif;
			break;
		case 'formtawar':
			$selector ='tawar-'.$idpost;
			$image    =wp_get_attachment_image_src( get_post_thumbnail_id($idpost), 'single-post-thumbnail' );
			$label='Form Pemesanan Buku';
			$css_class=$css_class.' memberzone-button memberzone-button-primary memberzone-width-100';
			$content .='<form method="post" action="'.esc_url(admin_url('admin-post.php')).'">';
			$content .='<table >';
			
			$content .='<tr>';
			$content .='<td rowspan="10" width="200"><img src="'.$image[0].'" class="thumb-small" width="75%"/></td>';
			$content .='<td colspan="2"><h3>'.$postingan->post_title.'</h3></td>';
			$content .='</tr>';
			$content .='<tr>';
			$content .='<td><label>Judul buku</label></td><td><strong>: '.$postingan->post_title.'</strong></td>';
			$content .='</tr>';
			
		
			if (count($get_opsi)>0) {
				foreach($get_opsi as $keyopsi => $valopsi) {
					$content .='<tr>';
					switch ($valopsi['meta_opsional']) {
						case 1:
							$content .='<td><label>'.$valopsi["meta_label"].'</label></td><td> :';
							$opsional =get_opsional_custom_metakey($valopsi['meta_key'],$idpost);

							foreach($opsional as $valop) {
									$content .='&nbsp<input type="radio" name="'.$valopsi['meta_key'].'" value="'.$valop['id'].'" class="'.$valopsi['meta_key'].'" />&nbsp'.$valop['opsional'];
							}
							$content .='</td>';
							break;
						default:
							if ($valopsi['meta_key']!=='bukutersedia') {
								$content .='<td><label>'.$valopsi["meta_label"].'</label></td><td><strong>: '.get_post_meta($idpost,$valopsi['meta_key'],true).'</strong></td>';
							}
							break;
					}
					$content .='</tr>';
				}
			}
			
			$content .='<tr>';
			$content .='<td><input class="btn-send-quo memberzone-button memberzone-button-primary memberzone-width-100" name="memberzone-penawaran-kirim" type="submit" value="Booking"></td>';
			$content .='</tr>';
			$content .='</table>';
			$content .='<input name="id" type="hidden" value="'.memberzone_enkrip($idpost).'">';
			$content .='<input name="action" type="hidden" value="memberzone_penawaran">';
			$content .='</form >';
			break;
	}
}
?>
<a href="#TB_inline?width=800&height=400&inlineId=pay-content-<?php echo $selector;?>" class="<?php echo $css_class;?>"><?php echo $label;?></a>
<div id="pay-content-<?php echo $selector;?>" style="display:none;">
	<div class="thickbox-info" >
	<?php 
	if($toshow=='login'):
	$args = array(
				//'echo'           => false,
				'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
				'form_id'        => 'loginform',
				'label_username' => __( 'Username' ),
				'label_password' => __( 'Password' ),
				'label_remember' => __( 'Remember Me' ),
				'label_log_in'   => __( 'Log In' ),
				'id_username'    => 'user_login',
				'id_password'    => 'user_pass',
				'id_remember'    => 'rememberme',
				'id_submit'      => 'wp-submit',
				'remember'       => true,
				'value_username' => '',
				'value_remember' => false
	);
	$content .=wp_login_form($args);
	endif;
	echo $content;?>
	</div>
</div>