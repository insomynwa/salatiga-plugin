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

	private $gambar_utama;
	public function GetGambarUtama() { return $this->gambar_utama; }
	public function SetGambarUtama( $gambar_utama ) { $this->gambar_utama = $gambar_utama; }

	function __construct() {
		$this->table_name = "ext_produk";
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
			$this->kategori = $row[ 'kategori' ];
			$this->ukm = $row[ 'ukm' ];

			$gu = new Sltg_Gambar( "ext_gambar_produk" );
			$this->gambar_utama = $gu->GetAPicture( $this->id );
		}
		return $result;
	}

	public function CountData( $searchForName = "", $kategori = 0 ) {
		global $wpdb;

		//$query = "SELECT COUNT(id_produk) AS jumlah FROM $this->table_name";
		$str_operator = "<>";
		if ( $kategori > 0 )
			$str_operator = "=";
		$query = "SELECT COUNT(id_produk) AS jumlah FROM $this->table_name " .
					"WHERE kategori $str_operator %d AND nama_produk LIKE %s";
		$bindValues = array();
		$bindValues[] = $kategori;
		$bindValues[] = "%".$searchForName."%";

		/*if ( !is_null( $searchForName ) ){
			$str_search = "WHERE nama_produk LIKE %s";
			$query .= " ". $str_search;
			$bindValues[] = "%".$searchForName."%";
		}*/
		//var_dump( $query, $kategori );

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

		//$query = "SELECT id_produk FROM $this->table_name";
		$str_operator = "<>";
		if ( $kategori > 0 )
			$str_operator = "=";
		$query = "SELECT id_produk FROM $this->table_name " . 
					"WHERE kategori $str_operator %d AND nama_produk LIKE %s";
		$bindValues = array();
		$bindValues[] = $kategori;
		$bindValues[] = "%".$searchForName."%";

		/*if( !is_null( $searchForName )) {
			$str_search = "WHERE nama_produk LIKE %s";
			$query .= " ". $str_search;
			$bindValues[] = "%".$searchForName."%";
		}*/

		if( $limit > 0 && $offset >= 0){
			$str_limit = "LIMIT %d, %d";
			$query .= " ". $str_limit;
			$bindValues[] = $offset;
			$bindValues[] = $limit;
		}
		//var_dump($query, $searchForName);
		$rows =
			$wpdb->get_results(
				$wpdb->prepare(
					$query,
					$bindValues
					)
				);
		//var_dump( $rows ); 
		return $rows;
	}
}