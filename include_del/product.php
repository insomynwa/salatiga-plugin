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
		}
		return $result;
	}

	public function CountData( $searchForName = null ) {
		global $wpdb;

		$query = "SELECT COUNT(id_produk) AS jumlah FROM $this->table_name";
		$bindValues = array();

		if ( !is_null( $searchForName ) ){
			$str_search = "WHERE nama_produk LIKE %s";
			$query .= " ". $str_search;
			$bindValues[] = "%".$searchForName."%";
		}

		$jumlah =
			$wpdb->get_var(
				$wpdb->prepare(
					$query,
					$bindValues
					)
				);

		return is_null( $jumlah )? 0 : $jumlah;
	}

	public function DataList( $limit = -1, $offset = -1, $searchForName = null) {
		global $wpdb;

		$query = "SELECT id_produk FROM $this->table_name";
		$bindValues = array();

		if( !is_null( $searchForName )) {
			$str_search = "WHERE nama_produk LIKE %s";
			$query .= " ". $str_search;
			$bindValues[] = "%".$searchForName."%";
		}

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