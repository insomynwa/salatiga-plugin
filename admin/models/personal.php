<?php

class Sltg_Personal {

	private $table_name;

	private $id;
	public function GetId(){ return $this->id; }

	private $nama;
	public function GetNama() { return $this->nama; }
	public function SetNama( $nama ) { $this->nama = $nama; }

	private $alamat;
	public function GetAlamat() { return $this->alamat; }
	public function SetAlamat( $alamat ) { $this->alamat = $alamat; }
	
	private $deskripsi;
	public function GetDeskripsi() { return $this->deskripsi; }
	public function SetDeskripsi($deskripsi) { $this->deskripsi = $deskripsi; }

	private $telp;
	public function GetTelp() { return $this->telp; }
	public function SetTelp($telp) { $this->telp = $telp; }

	private $other;
	public function GetOther() { return $this->other; }
	public function SetOther($other) { $this->other = $other; }

	// IN RELATIONSHIP
	
	private $foto;
	public function GetFotos() { return $this->foto; }

	function __construct() {
		$this->table_name = "ext_personal";
	}

	public function HasID( $personal_id = 0){
		global $wpdb;
		$row =
			$wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name 
					WHERE id_personal = %d",
					$personal_id
					),
				ARRAY_A
				);
		$result = ! is_null( $row );
		if ( $result ){
			$this->id = $row[ 'id_personal' ];
			$this->nama = $row[ 'nama_personal' ];
			$this->alamat = $row[ 'alamat_personal' ];
			$this->deskripsi = $row[ 'deskripsi_personal' ];
			$this->telp = $row[ 'telp_personal' ];
			$this->other = $row[ 'other_personal' ];
		}
		return $result;
	}

	public function CountData( $searchForName = null, $arg1 = null ) {
		global $wpdb;

		//$query = "SELECT COUNT(id_personal) AS jumlah FROM $this->table_name";
		$query = "SELECT COUNT(id_personal) AS jumlah FROM $this->table_name " . 
					"WHERE nama_personal LIKE %s";
		$bindValues = array();
		$bindValues[] = "%".$searchForName."%";

		/*if ( !is_null( $searchForName ) ){
			$str_search = "WHERE nama_personal LIKE %s";
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

	public function DataList( $limit = -1, $offset = -1, $searchForName = "", $arg1 = 0) {
		global $wpdb;

		/*$query = "SELECT id_personal FROM $this->table_name";
		$bindValues = array();

		if( !is_null( $searchForName )) {
			$str_search = "WHERE nama_personal LIKE %s";
			$query .= " ". $str_search;
			$bindValues[] = "%".$searchForName."%";
		}*/
		$query = "SELECT id_personal FROM $this->table_name " . 
					"WHERE nama_personal LIKE %s";
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