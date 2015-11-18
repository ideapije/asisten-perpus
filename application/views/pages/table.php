<div class="row">
<div class="col-xs-12">
	<div class="container" style="background-color:#fff;padding:10px;">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
			$('#big_table').dataTable();
		});
</script>
<?php 
$desctbl=desctbl($mng);
		if ((isset($isi)) && (is_array($isi)) && (isset($idm)) && (isset($mng))) {
			$idp='2';
			if ((!is_admin()) && ($mng=='29')) {
				$idp='4';$mng='18';
			}
			$lm=array('38','18');
			if ((is_admin()) || (in_array($mng,$lm)) || (is_admin() && $mng=='23')) {
				echo "<a href='".site_url('member/slug/'.$idm.'/2')."'>tambah data ".$desctbl['tabel']."</a><br>";
			}
			echo $this->table->generate($isi);
		}
?>
</div>
</div>
</div>