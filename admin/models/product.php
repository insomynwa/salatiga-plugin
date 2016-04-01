<?php

class Sltg_Product {

	private $table_name;

	private $id;
	public function GetId(){ return $this->id; }

	private $nama;
	public function GetNama() { return $this->nama; }
	public function SetNama( $nama ) { $this->nama = $nama; }
	
	private $deskripsi;
	public function GetDeskripsi() { return $this->deskripsi; }
	public function SetDeskripsi($deskripsi) { $this->deskripsi = $deskripsi; }

	private $other;
	public function GetOther() { return $this->other; }
	public function SetOther($other) { $this->other = $other; }

	private $kategori;
	public function GetKategori() { return $this->kategori; }
	public function SetKategori( $kategori ) { $this->kategori = $kategori; }

	private $ukm;
	public function GetUKM() { return $this->ukm; }
	public function SetUKM($ukm) { $this->ukm = $ukm; }

	// IN RELATIONSHIP
	private $gambar_utama;
	public function GetGambarUtama() { return $this->gambar_utama; }
	//public function SetGambarUtama( $gambar_utama ) { $this->gambar_utama = $gambar_utama; }

	private $gambars;
	public function GetGambars() { return $this->gambars; }
	public function SetGambars( $gambars ) { $this->gambars = $gambars; }

	function __construct() {
		$this->table_name = "ext_produk";
		$this->gambars = array();
	}

	public function HasID( $produk_id = 0){
		global $wpdb;
		$row =
			$wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name 
					WHERE id_produk = %d",
					$produk_id
					),
				ARRAY_A
				);
		$result = ! is_null( $row );
		if ( $result ){
			$this->id = $row[ 'id_produk' ];
			$this->nama = $row[ 'nama_produk' ];
			$this->deskripsi = $row[ 'deskripsi_produk' ];
			$this->other = $row[ 'other_produk' ];

			$obj_kat = new Sltg_Kategori_Product();
			$obj_kat->HasID( $row[ 'kategori' ] );
			$this->kategori = $obj_kat;

			$obj_ukm = new Sltg_UKM();
			$obj_ukm->HasID( $row[ 'ukm' ] );
			$this->ukm = $obj_ukm;

			$obj_gbr = new Sltg_Gambar( "ext_gambar_produk" );
			$list_gambar = $obj_gbr->SetProduk( $this->id );
			foreach( $list_gambar as $g) {
				$gambar = new Sltg_Gambar( "ext_gambar_produk" );
				$gambar->HasID( $g->id_gambar_produk );
				if( $gambar->GetGambarUtama() == 1) {
					$this->gambar_utama = $gambar;
					/*break;*/
				}
				$this->gambars[] = $gambar;
			}
			//var_dump($this->gambars);
		}
		return $result;
	}

	public function CountData( $searchForName = "", $kategori = 0 ) {
		global $wpdb;

		$str_operator = "<>";
		if ( $kategori > 0 )
			$str_operator = "=";
		$query = "SELECT COUNT(id_produk) AS jumlah FROM $this->table_name " .
					"WHERE kategori $str_operator %d AND nama_produk LIKE %s";
		$bindValues = array();
		$bindValues[] = $kategori;
		$bindValues[] = "%".$searchForName."%";

		$jumlah =
			$wpdb->get_var(
				$wpdb->prepare(
					$query,
					$bindValues
					)
				);

		return is_null( $jumlah )? 0 : $jumlah;
	}

	public function DataList( $limit = -1, $offset = -1, $searchForName = "", $kategori = 0) {
		global $wpdb;

		$str_operator = "<>";
		if ( $kategori > 0 )
			$str_operator = "=";
		$query = "SELECT id_produk FROM $this->table_name " . 
					"WHERE kategori $str_operator %d AND nama_produk LIKE %s";
		$bindValues = array();
		$bindValues[] = $kategori;
		$bindValues[] = "%".$searchForName."%";
		$query .= " ORDER BY nama_produk";

		if( $limit > 0 && $offset >= 0){
			$str_limit = "LIMIT %d, %d";
			$query .= " ". $str_limit;
			$bindValues[] = $offset;
			$bindValues[] = $limit;
		}
		$rows =
			$wpdb->get_results(
				$wpdb->prepare(
					$query,
					$bindValues
					)
				);
		return $rows;
	}

	public function AddNew() {
		global $wpdb;

		$result = array( 'status' => false, 'message' => 'Error AddNew()-product' );

		if( $wpdb->insert(
			$this->table_name,
			array(
				'nama_produk' => $this->nama,
				'deskripsi_produk' => $this->deskripsi,
				'other_produk' => $this->other,
				'kategori' => $this->kategori,
				'ukm' => $this->ukm
				),
			array(
				'%s', '%s', '%s', '%d', '%d'
				)
			) ){
			$result[ 'status' ] = true;
			$result[ 'message' ] = 'Berhasil menambah produk';
			$result[ 'new_id' ] = $wpdb->insert_id;
		}
		return $result;
	}

	public function Delete(){
		global $wpdb;

		$result = array( "status" => false, "message" => "" );
		if( $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $this->table_name WHERE id_produk = %d",
				$this->id
			)
		)) {
			$result ['status'] = $this->deleteGambars();
		}

		return $result;

	}

	private function deleteGambars() {
		global $wpdb;

		$obj_gbr = new Sltg_Gambar( "ext_gambar_produk" );
		$obj_gbr->SetProduk( $this->id );
		$result = $obj_gbr->DeleteMultiple();

		foreach( $this->gambars as $gbr ) {
			$result = $result && $gbr->DeletePost();
		}

		/*$query = 
			"DELETE gbr, p, pm
			FROM ext_gambar_produk gbr
			LEFT JOIN sltg_posts p ON gbr.post_id = p.ID
			LEFT JOIN sltg_postmeta pm ON p.ID = pm.post_id
			WHERE gbr.produk = %d";

		if( $wpdb->query(
			$wpdb->prepare(
				$query,
				$this->id
			)
		) ) {
			return true;
		}*/
		return $result;
	}
}