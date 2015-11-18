<div class="container" style="background-color:#fff;">
<div class="row">
		<div class="col-md-4">
			<img src="<?php echo GAMBAR_SRC.'user.png';?>" alt="photo profile" class="img-thumbnail col-xs-12">	
		</div>
		<div class="col-md-8">
			<table><?php if (is_array($userlabel)) {
				foreach ($userlabel as $key => $value) {?>
				<tr>
				<th><?php echo $value;?> </th>
					<td><?php echo $userdata[0][$key];?> </td>
				</tr>
			<?php } }?></table>	
		</div>
</div>
<hr>

<div class="row">
	<div class="col-xs-12">
		<?php echo $content_member;?>	
	</div>
</div>
</div>

	
	
