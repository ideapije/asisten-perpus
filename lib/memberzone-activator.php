<?php

class Memberzone_Activator {
	public static function activate() {
		global $wpdb;
		$t1=$wpdb->prefix.'custom_meta_key';
		$t3=$wpdb->prefix.'opsional_meta_key';
		$t4=$wpdb->prefix.'perpus_booking';
		$t5=$wpdb->prefix.'uid_book';
		$t6=$wpdb->prefix.'log_peminjaman';
		$t7=$wpdb->prefix.'log_kembalian';
		$buattabel=array(
			"CREATE TABLE IF NOT EXISTS `$t1` (
				`id` bigint(20) NOT NULL AUTO_INCREMENT,
				`meta_key` varchar(50) NOT NULL,
				`meta_label` varchar(125) NOT NULL,
				`meta_type` varchar(15) NOT NULL,
				`meta_max_val` int(9) NOT NULL,
				`meta_opsional` int(2) NOT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;"
          ,
          "CREATE TABLE IF NOT EXISTS `$t3` (
          	`id` bigint(20) NOT NULL AUTO_INCREMENT,
          	`meta_key` varchar(50) NOT NULL,
          	`opsional` varchar(125) NOT NULL,
          	`class` varchar(50) NOT NULL,
          	PRIMARY KEY (`id`)
          	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;"
          ,
          "CREATE TABLE IF NOT EXISTS `$t4` (
			`id` bigint(20) NOT NULL,
  			`user_id` bigint(20) unsigned NOT NULL,
  			`post_id` bigint(20) NOT NULL,
  			`booking_inquired` varchar(30) DEFAULT NULL,
  			`booking_expired` varchar(30) DEFAULT NULL,
  			`booking_status` int(10) NOT NULL
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;"
			,
			"CREATE TABLE IF NOT EXISTS `$t5` (
				`id` bigint(20) NOT NULL,
				`uid` varchar(25) NOT NULL,
				`type_uid` varchar(1) NOT NULL,
  				`id_link_uid` bigint(20) unsigned NOT NULL
			) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;"
			,
			"CREATE TABLE IF NOT EXISTS `$t7` (
				`id` bigint(20) NOT NULL,
				`id_peminjaman` bigint(20) NOT NULL,
				`waktu_kembali` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPvarchar(30) CURRENT_TIMESTAMP(6),
				`status_telat` tinyint(1) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
			,
			"CREATE TABLE IF NOT EXISTS `$t6` (
				`id` bigint(20) NOT NULL,
				`id_booking` bigint(20) NOT NULL,
				`waktu_masuk` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPvarchar(30) CURRENT_TIMESTAMP,
				`waktu_harus_kembali` varchar(50) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
		);
		foreach($buattabel as $sql) {
			$wpdb->query($sql);
		}
		$data_custommeta=array(
			array(
				'meta_key'=>'bukutersedia'
				,'meta_label'=>'Buku ini masih Tersedia?'
				,'meta_type'=>'radio'
				,'meta_max_val'=>'5'
				,'meta_opsional'=>0
			)
			,array(
				'meta_key'=>'kat_buku'
				,'meta_label'=>'kategori buku'
				,'meta_type'=>'select'
				,'meta_max_val'=>'25'
				,'meta_opsional'=>0
			)
			,array(
				'meta_key'=>'pengarang'
				,'meta_label'=>'Nama pengarang'
				,'meta_type'=>'text'
				,'meta_max_val'=>'50'
				,'meta_opsional'=>0
			)
			,array(
				'meta_key'=>'penerbit'
				,'meta_label'=>'Nama Penerbit'
				,'meta_type'=>'text'
				,'meta_max_val'=>'50'
				,'meta_opsional'=>0
			)
			,array(
				'meta_key'=>'kotaterbit'
				,'meta_label'=>'Kota Penerbit'
				,'meta_type'=>'text'
				,'meta_max_val'=>'125'
				,'meta_opsional'=>0
			)
			,array(
				'meta_key'=>'thterbit'
				,'meta_label'=>'Tahun terbit'
				,'meta_type'=>'number'
				,'meta_max_val'=>'4'
				,'meta_opsional'=>0
			)
		);
		foreach($data_custommeta as $key => $value) {
			insert_data('custom_meta_key',$value);
		}
		$data_valmeta=array(
			array(
				'meta_key'=>'bukutersedia'
				,'opsional'=>'ya'
				,'class'=>''
			)
			,array(
				'meta_key'=>'bukutersedia'
				,'opsional'=>'tidak'
				,'class'=>''
			)
		);
		foreach($data_valmeta as $k => $v){
			insert_data('opsional_meta_key',$v);		
		}

	}
}

/* Akhir dari berkas memberzone-activator.php */
//`time` TIMESTAMP NOT NULL,
