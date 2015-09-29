<?php

class Memberzone_Deactivator {
	public static function deactivate() {
		global $wpdb;
		$tabel=array('custom_meta_key','queue_quotation','opsional_meta_key','list_quo','pesan','pay','bank_toko','gambar','member_saldo');
		foreach($tabel as $value) {
			$sql="DROP TABLE ".$wpdb->prefix.$value;
			$wpdb->query($sql);
		}
		if (get_page_by_title('Sistem Penawaran')) {
			$sisquo=get_page_by_title('Sistem Penawaran');
			wp_delete_post($sisquo->ID,true);
		}		
	}
	
}

/* Akhir dari berkas memberzone-activator.php */
