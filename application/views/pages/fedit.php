<div class="row">
<div class="col-xs-12">
	<div class="container" style="background-color:#fff;padding:10px;">
<?php
$session_data = $this->session->userdata('logged_in');
if (isset($_GET['m'])) {
	switch ($_GET['m']) {
		case '4':
			echo 'gagal upload';
			break;
		case '2':
			echo 'berhasil upload';
			break;
		default:
			echo '';
			break;
	}
	
}
$idne=$this->uri->segment(5);
$mng=$this->uri->segment(3);
echo (!is_null($mng) && !is_null($idne))? form_open_multipart('member/update/'.$mng.'/'.$idne) : form_open_multipart('member');
foreach ($larik as $key => $value) {

	foreach ($sikol as $k => $val) { ?>
	<div class="form-group">
	<label><?php echo($val['label'])?></label>
		<?php switch ($val['type']) {
			case 'textarea': ?>
				<textarea class="<?php echo($val['class'])?>" name="<?php echo($val['name'])?>" ><?php echo (is_null($value[$val['name']]))? '' : $value[$val['name']];?></textarea>
				<?php break;
			case 'select': 
			$qopt=$this->m_perpus->listselect($val['size']);
			?>
			<select class="<?php echo(is_null($val['class']))? 'form-control ': $val['class'];?>" name="<?php echo($val['name'])?>">
				<?php if (count($qopt) >0 && is_array($qopt)) {
					foreach ($qopt as $opt) { ?>

						<option value="<?php echo $opt;?>"><?php echo spesifickolbyid($opt,$val['size'],$val['lain'],$val['name']);?></option>
					<?php }
				 ?>
				<?php }?>
			</select>	
				<?php break;
			default:?>
				<input type="<?php echo($val['type']);?>" class="<?php echo(is_null($val['class']))? 'form-control ': $val['class'];?>" name="<?php echo($val['name'])?>" value="<?php echo (is_null($value[$val['name']]))? '0': $value[$val['name']];?>"/>
			<?php break;
		} ?>
		</div>

	<?php }
} ?>
		<button type="reset" class="btn btn-default">reset</button>
		<button type="submit" class="btn btn-primary">submit </button>
<?php echo form_close();?>

</div>
</div>
</div>