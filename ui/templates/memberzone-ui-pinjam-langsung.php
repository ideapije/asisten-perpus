<form action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="post">
<table>
	<tr>
		<td>Judul buku</td>
		<td><input type="text" name="post_id" class="regtablear-text keydown-book" /><span class="returnidbook"></span> </td>
	<tr >
		<td colspan="2">
			<div class="detailbook">Detail Buku akan muncul ketika judul sudah terisi</div>
		</td>
	</tr>
	</tr>
		<td>Kode RFID</td>
		<td><input type="number" name="uid" class="regtablear-text " /> </td>
	</tr>
		<td>
		<input type="hidden" name="action" value="memberzone_penawaran" />
		<input type="hidden" name="memberzone-penawaran-kirim" value="pinjamlangsung" />
		<button type="submit" class="memberzone-button memberzone-button-primary "> ajukan peminjaman</button></td>
		<td><button type="reset" class="memberzone-button "> reset</button> </td>
	</tr>

</table>
</form>