<?php
echo validation_errors(); 
echo form_open('asisten/reg');
echo form_label('email', 'email');
echo form_input($email).'<br>';
echo form_label('username', 'uname');
echo form_input($uname).'<br>';
echo form_label('password', 'pass');
echo form_password($pass).'<br>';
echo form_label('password Confirmation', 'passc');
echo form_password($passc).'<br>';
foreach ($gender as $gen) { ?>
	<input type="radio" name="id_gender" value="<?php echo $gen['id_gender'];?>" />
	<label>
		<?php echo $gen['desc_gender'];?>
	</label>
<?php }
echo '<br>';
foreach ($jbtn as $jb) {
	echo form_radio('idjbtn',$jb['idjbtn']).form_label($jb['desc_jabatan'],'idjbtn');

}
echo '<br>';
echo form_submit('','Sign Up');
echo form_close();
?>