<?php $this->db = $this->load->database('default', true);?>
<?php 
if (isset($_POST['inbox'])) {
	$datalok = array('id_lokasi' =>decrypt_url($_POST['idlok']) ,'id_kat'=>decrypt_url($_POST['idkat']),'kode_rak'=>decrypt_url($_POST['kdrak']));
	
	$qcek=$this->db->where('id_lokasi',decrypt_url($_POST['idlok']))->where('kode_rak',decrypt_url($_POST['kdrak']))->get('lokasi_buku')->result_array();
	if (count($qcek)==0) {
		$this->db->insert('lokasi_buku',$datalok);
	}else{
		echo "<script>alert('hello');</script>";
		$datalok=array('id_kat'=>decrypt_url($_POST['idkat']));
		$this->db->where('kode_rak',decrypt_url($_POST['kdrak']))->update('lokasi_buku',$datalok);
	}
	header("location:?il=".$_POST['idlok']);
}
if (isset($_POST['add'])) {
	$idloke=decrypt_url($_POST['idloke']);
	$dtup=array('baris'=>$_POST['row'],'kolom'=>$_POST['col']);
	$this->db->where('id_lokasi',$idloke)->update('base-lokasi',$dtup);
	redirect('member/view/24');
}
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<div class="page-header">
	<h2>INSERT BOOKCASE</h2>
</div>
<?php 
if (isset($_GET['il'])) {
	$lok=getlok(decrypt_url($_GET['il']));
	?>
	<div class="jumbotron">
		<h1>			<?php echo 'Bookcase <small>'.strtoupper($lok['nama'].'</small>');?>
			<a href="<?php echo site_url('member/view/24');?>" class="btn btn-primary">back</a></h1>
		</h1>
	</div>
	<table class="table-bordered col-xs-12">
	<thead>
	<tr>
		<?php for ($x=0; $x < $lok['col']; $x++) {  ?>
			<td><?php echo(toNum($x));?></td>
		<?php }?>
	</tr>
	</thead>
	<tbody>
		<?php for ($i=0; $i < $lok['row']; $i++) {  ?>
		<tr>
			<?php for ($j=0; $j < $lok['col']; $j++) {
				if (isset($_GET['k']) && $_GET['k']==$i.$j) { ?>
				<td>
				<select class="form-control" name="idkat">
					<?php $opt=spesifickol(27,'desc_kat');
					$opt_id=spesifickol(27,'id_kat');

					if (count($opt) > 0) {
						$x=0;
						foreach ($opt as $valopt) { ?>
							<option value="<?php echo encrypt_url($opt_id[$x]);?>"><?php echo $valopt;?></option>
						<?php 
						$x++;
					}
					} ?>
				</select>
				<input type="hidden" name="idlok" value="<?php echo $_GET['il'];?>" />
				<input type="hidden" name="kdrak" value="<?php echo(encrypt_url($i.toNum($j)));?>" />
				<button type="submit" name="inbox">set</button>
				<a href="<?php echo site_url('member/view/24?il='.$_GET['il']);?>" />batal</a>
				</td>
				<?php }else{
					$params = array_merge($_GET, array('il' =>$_GET['il'],'k'=>$i.$j));
					$n_query_str=http_build_query($params);
				 ?>
				<td>
				<?php $idkat=spesifickolbyid($i.toNum($j),42,'id_kat','kode_rak');?>
				<a href="<?php echo(current_url().'?'.$n_query_str);?>" >
				<?php 
				
				if ($idkat) {
					$desckat=spesifickolbyid($idkat,27,'desc_kat');
					echo $desckat;
				}else{
					echo($i.toNum($j));
				}
				?></a></td>
				<?php } ?>
			<?php }?>
		</tr>
		<?php }?>
	</tbody>
</table>
<hr>
<?php }else{ ?>
	<table class="table">
	<thead>
		<tr>
		<?php if (count($likol) > 0 && is_array($likol)) {  ?>
			<?php foreach ($likol as $kol) { ?>
				<td>
					<?php echo($kol);?>
				</td>
			<?php }
		}?>
		</tr>
	</thead>
	<tbody>
	<?php
	if (is_array($larik) && count($larik) > 0) { ?>
		<?php foreach ($larik as $val) { ?>
		<tr>
		<td>
			<?php echo(get_buttons(49,$val['id_lokasi']));?>
		</td>
		<?php	foreach ($likol as $k) {
			if ($k!='aksi') { ?>
				<td><?php echo($val[$k]);?></td>
			<?php } ?>				
			<?php } ?>
		</tr>
		<?php } ?>
		
	<?php } ?>
	</tbody>
	</table>
	<hr>
<?php }?>
<h3>Tambahkan nama rak buku disini</h3>
  <div class="form-group">
 <div class="input-group">
 		<?php 
 		if (isset($_POST['set'])) { 
 			$q1=$this->m_perpus->settable('base-lokasi',array('namalok'=>$_POST['namalok']));

 			if ($q1) { ?>
 				<input type="hidden" name="idloke" value="<?php echo encrypt_url($q1);?>">
				<div class="col-xs-6">
      			<input type="text" class="form-control" placeholder="ketikan angka baris rak" name="row" onkeypress="return isNumber(value)">
      			</div>
      			<div class="col-xs-6">
      			<input type="text" class="form-control" placeholder="ketikan angka kolom rak" name="col" onkeypress="return isNumber(value)">
      			</div>
      			<span class="input-group-btn">
					<button class="btn btn-success" type="submit" name="add"><i class="glyphicon glyphicon-plus"></i>&nbsp Add</button>
				</span>
 			<?php }else{?>
 				<span class="alert alert-warning">terjadi kesalahan pada sistem</span>
 			<?php }?>
 		<?php }else{ ?>
			<input type="text" class="form-control" placeholder="ketikan nama rak buku misalkan rak1 " name="namalok">
			<span class="input-group-btn">
			<button class="btn btn-default" type="submit" name="set"><i class="glyphicon glyphicon-plus"></i>&nbsp Set</button>
			</span>
 		<?php }?>
    </div>
  </div>
</form>