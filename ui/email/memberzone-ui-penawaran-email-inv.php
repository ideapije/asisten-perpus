<<!DOCTYPE html>
<html>
<head>
	<title>Pdf Invoice-<?php echo $id;?></title>
</head>
<body>
<p>
	Berikut kami lampirkan dokumen Penagihan <strong><?php echo($data['produk']);?></strong><br/>
	untuk mengkonfirmasi pembayaran silahkan klik link Berikut <strong> <a href="<?php echo esc_url(home_url('/'.$data['postid'].'?kf='.encrypt_url($data['postid'])));?>">Konfirmasi pembayaran </a>
	</strong>
	<hr/>
	Batas maximal pembayaran jatuh pada <strong><?php echo $data['exp_time'];?></strong> atau 3 hari setelah persetujuan berhasil dilakukan <br/>
</p>
<br/>
Terima kasih
Salam,
Java Multi Mandiri
</body>
</html>
