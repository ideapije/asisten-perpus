<p id="kemburl" style="display:none;"><?php echo (isset($_GET['action']) && isset($_GET['post']) && $_GET['action']=='edit' )? 'post.php?post='.$_GET['post'].'&action='.$_GET['action'] : 'post-new.php';?></p>
<p id="post_id" style="display:none;"><?php echo $post->ID;?></p>
<table>
<?php   
		foreach($get_metakey as $value) {
		$get_opsional = get_opsional_custom_metakey($value['meta_key'],intval($post->ID));
		 ?>
		<tr>
		<td>
			<span class="<?php echo ($value['meta_opsional']==1) ? 'dashicons dashicons-yes' : 'dashicons dashicons-no-alt';?>" data-toggle="tooltip" data-placement="left" title="<?php echo ($value['meta_opsional']==1) ? 'opsional' : 'bukan opsional';?>"></span>
		</td>
		<td><strong><?php echo $value['meta_label'];?> </strong></td>
		<td>
<?php 
switch ($value['meta_type']) {
case 'select': ?>
		<select name="<?php echo $value['meta_key'];?>" >
		<?php
		if ($get_opsional) {
			foreach ($get_opsional as $kop => $valopsi) {?>
			<option value="<?php echo $valopsi['id'];?>"><?php echo $valopsi['opsional'];?></option>
			<?php }
		} ?>
		</select>
		<?php break;
case 'radio': 
		if ($get_opsional) {	
			foreach ($get_opsional as $key => $valopsi) { ?>				
		<input type="<?php echo $value['meta_type'];?>" name="<?php echo ($value['meta_key']=='bukutersedia')? $value['meta_key'] : $value['meta_key'].'[]';?>" value="<?php echo $valopsi['id'];?>"  <?php echo (get_post_meta($post->ID,$value['meta_key'],true)==$valopsi['id'])? 'checked': '';?>  maxlength="<?php echo $value['meta_max_val']; ?>" >
				<?php echo $valopsi['opsional'];
			}
		} 
		break; 
case 'checkbox':
		if ($get_opsional) {	
			foreach ($get_opsional as $key => $valopsi) { ?>
		<input type="<?php echo $value['meta_type'];?>" name="<?php echo $value['meta_key'].'[]';?>" value="<?php echo $valopsi['id'];?>"  <?php echo (get_post_meta($post->ID,$value['meta_key'],true)==$valopsi['id'])? 'checked': '';?>  maxlength="<?php echo $value['meta_max_val']; ?>" >
				<?php echo $valopsi['opsional'];
			}
		}
		 break;
case 'number': ?>
		<input type="<?php echo $value['meta_type'];?>" class="maxval" name="<?php echo $value['meta_key'];?>" value="<?php echo get_post_meta($post->ID,$value['meta_key'],true);?>"  maxlength="<?php echo $value['meta_max_val']; ?>" />
		<?php break;
case 'text': ?>
		<input type="<?php echo $value['meta_type'];?>" class="maxval" name="<?php echo $value['meta_key'];?>" value="<?php echo get_post_meta($post->ID,$value['meta_key'],true);?>"  maxlength="<?php echo $value['meta_max_val']; ?>" />
		<?php 	break;
case 'textarea': ?>
			<textarea name="<?php echo $value['meta_key'];?>" class="maxval" maxlength="<?php echo $value['meta_max_val']; ?>"><?php echo get_post_meta($post->ID,$value['meta_key'],true);?></textarea>
<?php break; 
} ?>
<?php $list_meta_type=array('select','radio','checkbox');
if (in_array($value['meta_type'], $list_meta_type) && $value['meta_key']!=='bukutersedia'): ?>
		<input type="text" id="<?php echo 'txt-'.$value['meta_key'];?>" style="display:none;" />
		<button type="button"  name="<?php echo $value['meta_key'];?>" id="<?php echo 'ad-'.$value['meta_key'];?>" data-toggle="tooltip" data-placement="left" title="tambah pilihan baru" class="addval" >
		<span class="dashicons dashicons-plus"></span>
		</button>
		<button type="button" class="btn-save-opt" id="<?php echo 'btn-'.$value['meta_key'];?>" style="display:none;" >simpan</button>
<?php endif; ?>
		</td>
		</tr>
		<?php }?>
</table >
