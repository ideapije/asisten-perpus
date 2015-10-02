<?php if (is_user_logged_in()):?>
<?php  
$akun=cek_usermeta(true);$userdata=get_userdata($akun->ID);
$metakey_user=array(
	'gender'	=>'Jenis kelamin'
	,'nim'		=>'NIM(Nomor Induk Mahasiswa)'
	,'prodi'	=>'Program Studi'
	,'angkatan'	=>'Angkatan'
	,'kelas'	=>'Kelas'
	,'nohp'		=>'No. Hp Pribadi'
	,'alamatasli'=>'Alamat asli'
	,'alamatdomisil'=>'Alamat domisil'); ?>
<h3>Tekan tombol Enter untuk menyimpan perubahan</h3>
<hr>
<form method="post" action="<?php echo esc_url(admin_url('admin-post.php'));?>">
<div class="memberzone-width-50">
<table>		
<tr>
	<td>Username</td>
	<td><input type="text" name="user_login" value="<?php echo $akun->user_login;?>"  id="txt-user_login" style="display:none;"/>
	<p class="profilval val-user_login" >
		<?php echo $akun->user_login;?>
		<a href="#" class="link-edit"  id="user_login">
			<i class="dashicons dashicons-edit"></i>
		</a>
	</p>
	</td>
</tr>
<tr><td>Nama panggilan</td>
	<td><input type="text" name="user_nicename" value="<?php echo $akun->user_nicename;?>"  id="txt-user_nicename" style="display:none;"/>	
	<p class="profilval val-user_nicename">
		<?php echo $akun->user_nicename;?>
		<a href="#" class="link-edit" id="user_nicename">
			<i class="dashicons dashicons-edit"></i>
		</a>
	</p>
	</td>
</tr>
<tr><td>Akun email</td>
	<td><input type="text" name="user_email" value="<?php echo $akun->user_email;?>"  id="txt-user_email" style="display:none;"/>
	<p class="profilval val-user_email">
		<?php echo $akun->user_email;?>
		<a href="#" class="link-edit"  id="user_email">
			<i class="dashicons dashicons-edit"></i>
		</a> 
	</p>
	</td>
</tr>
<tr>
	<td>mendaftar tanggal</td>
	<td><p class="profilval">
		<?php echo $akun->user_registered;?>
	</p>
	</td>
</tr>
</table>	
</div>
<div class="memberzone-width-50">
	<table >		
<?php foreach($metakey_user as $key => $value) : ?>
	<tr>
		<td><?php echo $value;?></td>
		<td><?php
			switch ($key) {
				case 'gender': ?>
				<select name="<?php echo $key;?>" id="txt-<?php echo $key;?>" class="regtablear-text" style="<?php echo (cekosong(get_the_author_meta($key, $akun->ID)))? 'display:block': 'display:none';?>">
					<option value="1">Laki-Laki</option>
					<option value="0">Perempuan</option>
				</select>
				<?php break;
				case 'nim': ?>
				<input type="number" name="<?php echo $key;?>" value="<?php echo get_the_author_meta($key, $akun->ID);?>"  id="txt-<?php echo $key;?>" class="regtablear-text input maxval" maxlength="8" style="<?php echo (cekosong(get_the_author_meta($key, $akun->ID)))? 'display:block': 'display:none';?>"/>
				<?php break; ?>
				<?php case 'nohp': ?>
				<input type="number" name="<?php echo $key;?>" value="<?php echo get_the_author_meta($key, $akun->ID);?>"  id="txt-<?php echo $key;?>" class="regtablear-text input" style="<?php echo (cekosong(get_the_author_meta($key, $akun->ID)))? 'display:block': 'display:none';?>"/>
				<?php break;
					default: ?>
					<input type="text" name="<?php echo $key;?>" value="<?php echo get_the_author_meta($key, $akun->ID);?>"  id="txt-<?php echo $key;?>" class="regtablear-text input" style="<?php echo (cekosong(get_the_author_meta($key, $akun->ID)))? 'display:block': 'display:none';?>"/>
				<?php break;
			}?>
		<p class="profilval <?php echo 'val-'.$key;?>">
			<span><?php echo get_the_author_meta($key, $akun->ID);?></span>
			<a href="#" class="link-edit"  id="<?php echo $key;?>">
			<i class="dashicons dashicons-edit"></i>
		</a> 
		</p>
		</td>		
	</tr>
<?php endforeach; ?>
</table>    
</div>
<input type="hidden" name="action" value="memberzone_penawaran" />
<input type="hidden" name="memberzone-penawaran-kirim" value="update_profiluser" />
<button class="memberzone-button memberzone-button-primary" type="submit">simpan perubahan</button>
</form>
<?php endif;?>
