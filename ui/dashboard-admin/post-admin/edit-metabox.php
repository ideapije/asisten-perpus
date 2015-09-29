<div id="txtout" >dsadsad</div>
<?php 
if ($get_metakey && is_array($get_metakey)) { ?>
<form method="post" action="#" id="form-edit" novalidate>
<?php //echo esc_url(admin_url('/admin-post.php')); ?>
    <table >
    <?php foreach ($get_metakey as $valmetkey) { ?>
        <tr> 
            <td>
				<span class="grouptxt" style="display:none;"><?php echo $valmetkey['id'].'|'.$permalink;?></span>
				<strong>Nama Label </strong>
            </td>
            <td><input type="text" name="meta_label" class="form-control" value="<?php echo $valmetkey['meta_label'];?>" /></td>
        </tr>    
        <tr>
            <td><strong>Type label</strong></td>
            <td>
            <?php $option=array('checkbox'=>'Checkbox','select'=>'Dropdown','number'=>'Number','radio'=>'Radio Button','text'=>'text','textarea'=>'textarea');?>
            <select name="meta_type" class="form-control" > 
                <?php foreach ($option as $key => $valopt) { ?>
                    <option value="<?php echo $key;?>" <?php echo ($key==$valmetkey['meta_type']) ? 'selected' : '';?>><?php echo $valopt;?></option>
                <?php }?>
            </select>
            </td>
         </tr>
         <tr>
            <td><strong>Max. isi label</strong></td>
            <td><input type="number" name="meta_max_val" class="form-control" value="<?php echo $valmetkey['meta_max_val'];?>"/></td>
         </tr>
          <tr>
            <td><strong>Tampilan sebagai Opsional pembeli?</strong></td>
            <td><input type="checkbox" name="meta_opsional" class="form-control" <?php echo ($valmetkey['meta_opsional']==1)? 'checked' : '';?>/></td>
        </tr>        
    <?php } ?>
		<tr>
			<td>               
				<button class="button button-primary btn-upd-metabox" type="button">perbaharui</button>
                <button type="reset" class="memberzone-button">reset</button>
                <a href="<?php echo $permalink;?>" class="button memberzone-button">kembali</a>
            </td>
        </tr>
    </table>
</form>
<?php }?>

    