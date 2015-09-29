<?php

class Memberzone_Admin {
	private
		$plugin_name,
		$plugin_version;
	
	public function __construct($plugin_name, $plugin_version) {
		$this->plugin_name    = $plugin_name;
		$this->plugin_version = $plugin_version;
	}
	
	public function create_option_menu() {
		add_options_page(
			'Administrasi ' . ucwords($this->plugin_name),
			ucwords($this->plugin_name),
			'manage_options',
			$this->plugin_name,array($this, 'create_option_page')
		);
	}
	
	public function create_option_page() {
		ob_start();
		include MEMBERZONE_UI . $this->plugin_name . '-ui-admin.php';
		$page = ob_get_clean();
		
		print $page;
	}
	
	public function register_settings() {
		register_setting(
			$this->plugin_name . '_options',
			$this->plugin_name . '_marketer'
		);
	}
}

/* Akhir dari berkas memberzone-admin.php */
