<div class="row">
<div class="col-xs-12">
	<div class="container" style="background-color:#fff;padding:10px;max-height:450px;height:450px;overflow:scroll;">
<?php
if (isset($mng)) {
	switch ($mng) {
		case '18':
			if (is_admin()) {
				include APPPATH.'views/inc/buku.php';
			}else{
				include APPPATH.'views/inc/katalog.php';
			}
			break;
		case '23':
			if (is_admin()) {
				include APPPATH.'views/inc/member.php';
			}else{
				include APPPATH.'views/inc/profile.php';
			}
			break;
		case '30':
			include APPPATH.'views/inc/actvmem.php';
			break;
		case '40':
			include APPPATH.'views/inc/notif.php';
			break;
		case '49':
			include APPPATH.'views/pages/rak.php';
			break;
		default:
			echo '<h1>Hello</h1>';
			break;
	}
}
?>
</div>
</div>
</div>