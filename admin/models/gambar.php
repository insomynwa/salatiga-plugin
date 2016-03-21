<?php

class Sltg_Gambar {

	private $table_name;

	function __construct( $table_name ) {
		$this->table_name = $table_name; 
	}

	function GetAPicture( $produk_id ) {
		global $wpdb;

		$link =
			$wpdb->get_var(
				$wpdb->prepare(
					"SELECT link_gambar_produk FROM $this->table_name " .
					"WHERE produk = %d LIMIT 1",
					$produk_id
					)
				);
		return $link;
	}
}