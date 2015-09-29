<fieldset><legend><h3> Data Permintaan penawaran</h3></legend>
<table class="wp-list-table widefat fixed striped posts">
<thead>
	<tr>
		<td>No Serial</td>
		<td>User</td>
		<td>Product</td>
		<td>Exp Time</td>
		<td>Action</td>
	</tr>
</thead>
<tbody>	
	<?php 
	
	global $wpdb;
	$t4=$wpdb->prefix.'list_quo';
	$sql_getquo="SELECT * FROM ".$t4;
	$get_quolist = $wpdb->get_results($sql_getquo, ARRAY_A );
	if (count($get_quolist) > 0) { 
		foreach ($get_quolist as $quo ) { 
			$get_permalink=get_permalink($quo['memberzone-penawaran-produk']);
			$postingan=get_post($quo['memberzone-penawaran-produk']);
			$expdate=substr($quo['exp_time'],0,10);
			$User=get_user_by('id',$quo['idcus']);
			$noquopay=$quo['id'].'-'.$quo['noquo'];
			?>
		<tr>
			<td>
				<?php if (date('Y-m-d')==$expdate) { ?>
					<strong>expired</strong>
				<?php }else{ 
					($quo['status']==1 || $quo['status']==4 || $quo['status']==5) ? $docid='i' : $docid='q';?>
					<a href="<?php echo(esc_url(admin_url('?di='.$docid.'&id='.encrypt_url($quo['id']))))?>"><?php echo($quo['noquo'])?></a>
				<?php }?>
			</td>
			<td><?php echo $User->user_login;?></td>
			<td>
			<a href="<?php echo $get_permalink;?>">
				<?php  echo $postingan->post_title;?>
			</a>
			</td>
			<td><?php echo($expdate)?></td>
			<td>
			<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
			<input type="hidden" name="id" value="<?php echo($quo['id']);?>" />
			<input name="action" type="hidden" value="memberzone_penawaran">
				<?php if (date('Y-m-d')==$expdate):?>
					<input class="button button-primary" name="memberzone-penawaran-kirim" type="submit" value="remove">
				<?php else: ?>
					<?php switch ($quo['status']) {
						case '1': ?>
						<strong>UNPAID</strong>
						<?php break;
						case '2': ?>
						<strong>unconfirmed</strong>
						<?php break;
						case '3':?>
						<input type="hidden" name="memberzone-penawaran-produk" value="<?php echo($quo['memberzone-penawaran-produk']);?>" />
						<input class="button button-primary" name="memberzone-penawaran-kirim" type="submit" value="invoice">
						<?php 
						break;
						case '4': ?>
						<input class="button button-primary" name="memberzone-penawaran-kirim" type="submit" value="remove">
						<a class="button button-primary" href="<?php echo '?ac='.md5($quo['id']).'&s='.encrypt_url(5);?>" >pulihkan</a>
						<?php 
						break;
						case '5':
						$sisane=getpay($noquopay,'sisa'); 
						$tglkonfirm=getpay($noquopay,'time');
						$stspay=getpay($noquopay,'status'); 
						$lentgl=intval(strlen($tglkonfirm)-1);
						$msg ='';
						if (substr($tglkonfirm,-1,1)=='y') {
							$msg .='<strong>terkonfirmasi '.substr($tglkonfirm,0,$lentgl).'</strong>';
						}else{
							add_thickbox();
							$toshow='pay';
							ob_start();				
							include MEMBERZONE_UI.'templates/memberzone-ui-thickbox.php';
							$msg .=ob_get_clean();
						}
						$msg .='<strong>';
						switch ($stspay) {
							case 5:
								if ($sisane < 0) {
									$msg .='<br/>STATUS : SISA TAGIHAN Rp '.$sisane.'<br/>';
								}else{
									$msg .='<br/>STATUS : LUNAS, kelebihan Rp '.$sisane.'<br/>';
								}
								break;
							case 6:
								$msg .='<br/>STATUS : LUNAS<br/>';
								if ($sisane > 0) {
									$msg .='kelebihan Rp '.$sisane.'<br/>';
								}
								break;
						}
						$msg .='</strong>';
						echo $msg;
						break;
						default: ?>	
						<input class="button button-primary" name="memberzone-penawaran-kirim" type="submit" value="acc">
						<?php 
						break;
						} ?>
				<?php endif; ?>
			</form>
			</td>
		</tr>
		<?php }
	}else{ ?>
	<tr>
		<td colspan="5">
			<h2><strong>Belum ada aktivitas</strong></h2>
		</td>
	</tr>
	<?php }?>
</tbody>
</table>
</fieldsetd>
	

