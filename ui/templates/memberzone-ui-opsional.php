<?php 
wp_nonce_field('detailbrg_box_nonce','detailbrg_nonce');
	add_thickbox();
	$toshow='add_metabox';
	ob_start();				
	include MEMBERZONE_UI.'templates/memberzone-ui-thickbox.php';
	$addmetabox=ob_get_clean();
	echo $addmetabox;
?>
<p style="display:none;" class="grouptxt">edit.php?page=opsional-page</p>
<table class="wp-list-table widefat fixed striped posts">
<?php $thead=array('Jadikan Opsional?','ID label','Label','Jenis Opsional','Panjang Karakter','Aksi');?>
<thead>
<tr>
	<?php foreach ($thead as $head) { ?>
	
		<th><?php echo $head;?></th>
	<?php }?>
</tr>
</thead>
<tbody>
<tr >
	<td></td>
</tr>
<?php $tbody=get_alldata('custom_meta_key');

foreach ($tbody as $key => $value) { ?>
<tr>
		<td>
			<p class="p-mo-<?php echo $value['id'];?> "><?php echo ($value['meta_opsional']==0)? 'Tidak' : 'Ya';?></p>			
			<input type="checkbox" <?php echo ($value['meta_opsional']==0)? '' : 'checked';?> class="mo-<?php echo $value['id'];?>" style="display:none;"/>
		</td>
		<td><?php echo $value['meta_key'];?>
		</td>
		<td>
		<p class="p-ml-<?php echo $value['id'];?> "><?php echo $value['meta_label'];?></p>
		<input type="text" style="display:none;" class="ml-<?php echo $value['id'];?>"/>
		</td>
		<td>
		<p class="p-mt-<?php echo $value['id'];?> "><?php echo $value['meta_type'];?></p>
			<?php $select=array('checkbox'=>'Checkbox','select'=>'Dropdown','number'=>'Number','radio'=>'Radio Button','text'=>'text','textarea'=>'textarea');?>
            <select style="display:none;" class="mt-<?php echo $value['id'];?>"> 
				<?php 
				foreach($select as $ksel => $valsel) { ?>
					<option value="<?php echo $ksel;?>" <?php echo ($value['meta_type']===$ksel)? 'selected': '';?>><?php echo $valsel;?></option>
				<?php } ?>
            </select>
		</td>
		<td>
		<p class="p-mmx-<?php echo $value['id'];?> "><?php echo $value['meta_max_val'];?></p>
		<input type="number" style="display:none;" class="mmx-<?php echo $value['id'];?>" id="txtboxToFilter"/>
		</td>
		<td>
				
				<button type="button" class="btn-edit-metabox" id="<?php echo $value['id'];?>" <?php echo ($value['meta_key']=='bukutersedia')? 'style="display:none;"' : '';?>>
						<span class="dashicons dashicons-edit"></span >
				</button>
				<button type="button" class="btn-<?php echo $value['id'];?> btn-upd-metabox" id="<?php echo $value['id'];?>" style="display:none;">
						<span class="dashicons dashicons-yes"></span >
				</button>
				<button type="button" class="btn-del-opt" id="<?php echo $value['id'];?>" <?php echo ($value['meta_key']=='bukutersedia')? 'style="display:none;"' : '';?>>
						<span class="dashicons dashicons-trash"></span >
				</button>
		</td>
</tr>
<?php } ?>
</tbody>
</table>
