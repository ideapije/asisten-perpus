<?php  if (isset($_POST)):
$user = wp_get_current_user();
$idsal=getdata_bykoland_id('member_saldo','id','idcus',$user->ID);
$id_listquo=decrypt_url($_POST['key']);
$exid=explode('-',$id_listquo);
$total_tagihan=getdata_bykoland_id('list_quo','memberzone-total-tagihan','id',$exid[0]);
$lengthbill=strlen($total_tagihan);
$recent_norek=getdata_bykoland_id('pay','norek','noquo',$id_listquo);
$recent_nabank=getdata_bykoland_id('pay','bank','noquo',$id_listquo);
$recent_anbank=getdata_bykoland_id('pay','an_rek','noquo',$id_listquo);
$idpay=getdata_bykoland_id('pay','id','noquo',$id_listquo);
$nom_sisa=getdata_bykoland_id('pay','sisa','noquo',$id_listquo);
$len_nom_sisa=strlen($nom_sisa);
($nom_sisa < 0) ? $inv_sisa=substr($nom_sisa,1,$len_nom_sisa) : $inv_sisa=$nom_sisa;

 ?>
	<form method="post" action="<?php echo esc_url(home_url('wp-admin/admin-post.php')); ?>">
	<input name="action" type="hidden" value="memberzone_penawaran">
	<table>
		<tr>
			<td>No. Rekening Tujuan</td>
			<td>
				<select name="idrektoko">
				<?php $listrek=get_alldata('bank_toko');
				if ($listrek) {
					foreach ($listrek as $key => $value) { ?>
					<option value="<?php echo $value['id'];?>"><?php echo $value['bank_an'].'-'.$value['bank_nama'].'-'.$value['bank_norek'];?></option>
					<?php }
				}else{?>
					<option value="0">Belum tersedia</option> 
				<?php }?>	
				</select>
			</td>
		</tr>
		<tr>
			<td><strong>Nama bank</strong></td>
			<td><input type="text" name="bank" value="<?php echo (cekosong($recent_nabank))? '' : $recent_nabank;?>" /></td>
		</tr>
		<tr>
			<td><strong>No. Rekening</strong></td>
			<td>
				<span style="float:left;" >
				<input type="number" name="norek" class="norek" value="<?php echo (cekosong($recent_norek))? '' : $recent_norek;?>"/>
				</span>
				<span style="float:left;" >
					<p style="color:#000;background:#F5D76E;padding:5px;">maksimal 18 karakter</p>
				</span>					
			</td>
		</tr>
		<tr>
			<td><strong>Atas nama Rekening</strong></td>
			<td><input type="text" name="an_rek" value="<?php echo (cekosong($recent_anbank))? '' : $recent_anbank;?>"/>
			</td>
		</tr>
		<tr>
			<td><strong>Nominal Pembayaran </strong></td>
			
			<td><input type="number" name="nominal" id="nombayar<?php echo $idsal;?>" value="<?php echo (cekosong($inv_sisa) || $nom_sisa > 0)? $total_tagihan : $inv_sisa;?>" />
			</td>
		</tr>
		<tr>
			<td><strong>Berita Acara </strong></td>
			<td>
				<textarea name="berita_acara"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<span id="lengthbill" style="display:none;"><?php echo ($lengthbill)? $lengthbill : '';?></span>
				<input type="hidden" value="<?php echo $idpay;?>" name="noid" />
				<input type="hidden" value="<?php echo $id_listquo;?>" name="noquo" />
				<input class="button button-primary" name="memberzone-penawaran-kirim" type="submit" value="konfirmasi">
			</td>
			<td>
				<a href="<?php echo esc_url(admin_url('/admin.php?page=request-page'));?>" class="memberzone-button">batal</a>
			</td>
		</tr>
	</table>
	</form>
<?php else: ?>
	<div class="notice" id="message" >
	<h3> terjadi kesalahan dalam sistem :( <a href="<?php echo esc_url(admin_url());?>" >kembali keberanda </a></h3>
	</div>
<?php endif;  ?>