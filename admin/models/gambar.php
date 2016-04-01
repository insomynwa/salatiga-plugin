<?php

class Sltg_Gambar {

	private $table_name;

	private $id;
	public function GetId(){ return $this->id; }

	private $link_gambar;
	public function GetLinkGambar() { return $this->link_gambar; }
	public function SetLinkGambar( $link_gambar ) { $this->link_gambar = $link_gambar; }
	
	private $deskripsi;
	public function GetDeskripsi() { return $this->deskripsi; }
	public function SetDeskripsi($deskripsi) { $this->deskripsi = $deskripsi; }

	private $produk;
	public function GetProduk() { return $this->produk; }
	public function SetProduk($produk) { 
		global $wpdb;

		$this->produk = $produk;

		$rows =
			$wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name ".
					"WHERE produk = %d",
					$this->produk
					)
				);
		return $rows;
	}

	private $gambar_utama;
	public function GetGambarUtama() { return $this->gambar_utama; }
	public function SetGambarUtama($gambar_utama) { $this->gambar_utama = $gambar_utama; }

	private $post_id;
	public function GetPostId() { return $this->post_id; }
	public function SetPostId($post_id) { $this->post_id = $post_id; }

	function __construct( $table_name ) {
		$this->table_name = $table_name; 
	}

	function HasID( $gambar_id = 0 ) {
		global $wpdb;

		$row =
			$wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name 
					WHERE id_gambar_produk = %d",
					$gambar_id
					),
				ARRAY_A
				);
		$result = ! is_null( $row );
		if ( $result ){
			$this->id = $row[ 'id_gambar_produk' ];
			$this->link_gambar = $row[ 'link_gambar_produk' ];
			$this->deskripsi = $row[ 'deskripsi_gambar_produk' ];
			$this->produk = $row[ 'produk' ];
			$this->gambar_utama = $row[ 'gambar_utama_produk' ];
			$this->post_id = $row[ 'post_id' ];
		}
		return $result;
	}

	function AddNew() {
		global $wpdb;

		$result = array( 'status' => false, 'message' => 'Error AddNew()-gambar' );

		if( $wpdb->insert(
			$this->table_name,
			array(
				'link_gambar_produk' => $this->link_gambar,
				'deskripsi_gambar_produk' => $this->deskripsi,
				'produk' => $this->produk,
				'gambar_utama_produk' => $this->gambar_utama,
				'post_id' => $this->post_id
				),
			array(
				'%s', '%s', '%d', '%d'
				)
			) ){
			$result[ 'status' ] = true;
			$result[ 'message' ] = 'Berhasil menambah gambar';
		}
		return $result;
	}
}