<?php

class Sltg_UKM {

	private $table_name;

	private $id;
	public function GetId(){ return $this->id; }

	private $pict_code;
	public function GetPictCode() { return $this->pict_code; }
	public function SetPictCode( $pict_code ) { $this->pict_code = $pict_code; }

	private $nama;
	public function GetNama() { return $this->nama; }
	public function SetNama( $nama ) { $this->nama = $nama; }
	
	private $deskripsi;
	public function GetDeskripsi() { return $this->deskripsi; }
	public function SetDeskripsi($deskripsi) { $this->deskripsi = $deskripsi; }

	private $alamat;
	public function GetAlamat() { return $this->alamat; }
	public function SetAlamat( $alamat ) { $this->alamat = $alamat; }

	private $telp;
	public function GetTelp() { return $this->telp; }
	public function SetTelp($telp) { $this->telp = $telp; }

	private $other;
	public function GetOther() { return $this->other; }
	public function SetOther($other) { $this->other = $other; }

	// IN RELATIONSHIP

	private $pemilik;
	public function GetPemilik() { return $this->pemilik; }
	public function SetPemilik($pemilik) { $this->pemilik = $pemilik; }
	
	private $gambar_utama;
	public function GetGambarUtama() { return $this->gambar_utama; }
	public function SetGambarUtama( $gambar_utama ) { $this->gambar_utama = $gambar_utama; }

	private $gambars;
	public function GetGambars() { return $this->gambars; }
	public function SetGambars( $gambars ) { $this->gambars = $gambars; }


	function __construct() {
		$this->table_name = "ext_ukm";
	}

	public function HasID( $ukm_id = 0){
		global $wpdb;
		$row =
			$wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name 
					WHERE id_ukm = %d",
					$ukm_id
					),
				ARRAY_A
				);
		$result = ! is_null( $row );
		if ( $result ){
			$this->id = $row[ 'id_ukm' ];
			$this->pict_code = 'U' . $row[ 'id_ukm' ];
			$this->nama = $row[ 'nama_ukm' ];
			$this->deskripsi = $row[ 'deskripsi_ukm' ];
			$this->alamat = $row[ 'alamat_ukm' ];
			$this->telp = $row[ 'telp_ukm' ];
			$this->other = $row[ 'other_ukm' ];

			$obj_person = new Sltg_Personal();
			$obj_person->HasID( $row[ 'pemilik' ] );
			$this->pemilik = $obj_person;
		}
		return $result;
	}

	public function CountData( $searchForName = "", $arg1 = null ) {
		global $wpdb;

		//$query = "SELECT COUNT(id_ukm) AS jumlah FROM $this->table_name";
		$query = "SELECT COUNT(id_ukm) AS jumlah FROM $this->table_name " .
					"WHERE nama_ukm LIKE %s";
		$bindValues = array();
		$bindValues[] = "%".$searchForName."%";

		/*if ( !is_null( $searchForName ) ){
			$str_search = "WHERE nama_ukm LIKE %s";
			$query .= " ". $str_search;
			$bindValues[] = "%".$searchForName."%";
		}*/

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

		/*$query = "SELECT id_ukm FROM $this->table_name";
		$bindValues = array();


		if( !is_null( $searchForName )) {
			$str_search = "WHERE nama_ukm LIKE %s";
			$query .= " ". $str_search;
			$bindValues[] = "%".$searchForName."%";
		}*/
		$query = "SELECT id_ukm FROM $this->table_name " .
					"WHERE nama_ukm LIKE %s";
		$bindValues = array();
		$bindValues[] = "%".$searchForName."%";

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