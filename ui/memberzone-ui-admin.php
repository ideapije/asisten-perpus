<div class="wrap">
	<h2>Administrasi <?php echo ucwords($this->plugin_name); ?></h2>
	<form method="post" action="options.php">
		<?php 
		global $wpdb;
		$t4=$wpdb->prefix.'list_quo';
		settings_fields($this->plugin_name . '_options'); 
		$options = get_option($this->plugin_name . '_marketer'); 
		$cek=get_data_table($t4,array('id'),false,false);?>
		<table class="wp-list-table widefat fixed striped posts">
			<tbody>
				<tr>
					<td scope="row" >Email Petugas</td>
					<td >
						<input class="regular-text" name="<?php echo $this->plugin_name; ?>_marketer[email]" type="email" value="<?php echo sanitize_email($options['email']); ?>">
					</td>
				</tr>
				<tr>
					<td scope="row" >No. Handphone Petugas</td>
					<td >
						<input class="regular-text" id="txtboxToFilter" name="<?php echo $this->plugin_name; ?>_marketer[person_hp]" type="number" value="<?php echo $options['person_hp']; ?>">
					</td>
				</tr>
				<tr>
					<td scope="row">Nama Perpustakaan</td>
					<td>
						<input class="regular-text" name="<?php echo $this->plugin_name; ?>_marketer[Perpustakaan_nama]" type="text" value="<?php echo $options['Perpustakaan_nama']; ?>">
					</td>
				</tr>
				<tr>
					<td scope="row">No.Telp Perpustakaan</td>
					<td>
						<input class="regular-text maxval" id="txtboxToFilter" name="<?php echo $this->plugin_name; ?>_marketer[Perpustakaan_notelp]" type="number" value="<?php echo $options['Perpustakaan_notelp']; ?>" maxlength="12"/>
					</td>
				</tr>
				<tr>
					<td scope="row">No. Fax Perpustakaan</td>
					<td>
						<input class="regular-text maxval" id="txtboxToFilter" name="<?php echo $this->plugin_name; ?>_marketer[Perpustakaan_fax]" type="number" value="<?php echo $options['Perpustakaan_fax']; ?>" maxlength="12"/>
					</td>
				</tr>
				<tr>
					<td scope="row">Email Perpustakaan</td>
					<td>
						<input class="regular-text" name="<?php echo $this->plugin_name; ?>_marketer[Perpustakaan_email]" type="email" value="<?php echo $options['Perpustakaan_email']; ?>">
					</td>
				</tr>
				<tr>
					<td scope="row">Alamat Perpustakaan</td>
					<td>
						<textarea class="regular-text memberzone-width-100" name="<?php echo $this->plugin_name; ?>_marketer[Perpustakaan_alamat]"><?php echo $options['Perpustakaan_alamat']; ?></textarea>
					</td>
				</tr>
				<tr>
					<td scope="row">Maximal Kadaluarsa</td>
					<td>
						<input class="regular-text maxval" id="txtboxToFilter" name="<?php echo $this->plugin_name; ?>_marketer[exp_time]" type="number" value="<?php echo $options['exp_time']; ?>" maxlength="3"> Menit
					</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>

