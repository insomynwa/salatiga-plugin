<?php

class Sltg_Kategori_Product {

	private $table_name;

	private $id;
	public function GetId(){ return $this->id; }

	private $nama;
	public function GetNama() { return $this->nama; }
	public function SetNama( $nama ) { $this->nama = $nama; }

	function __construct() {
		$this->table_name = "ext_kategori";
	}

	public function HasID( $kategori_id = 0){
		global $wpdb;
		$row =
			$wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name 
					WHERE id_kategori = %d",
					$kategori_id
					),
				ARRAY_A
				);
		$result = ! is_null( $row );
		if ( $result ){
			$this->id = $row[ 'id_kategori' ];
			$this->nama = $row[ 'nama_kategori' ];
		}
		return $result;
	}

	/*public function CountData( $searchForName = null ) {
		global $wpdb;

		$query = "SELECT COUNT(id_kategori) AS jumlah FROM $this->table_name";
		$bindValues = array();

		if ( !is_null( $searchForName ) ){
			$str_search = "WHERE nama_kategori LIKE %s";
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
	}*/

	public function DataList( /*$limit = -1, $offset = -1, $searchForName = null*/) {
		global $wpdb;

		$query = "SELECT id_kategori FROM $this->table_name";
		/*$bindValues = array();

		if( !is_null( $searchForName )) {
			$str_search = "WHERE nama_kategori LIKE %s";
			$query .= " ". $str_search;
			$bindValues[] = "%".$searchForName."%";
		}

		if( $limit > 0 && $offset >= 0){
			$str_limit = "LIMIT %d, %d";
			$query .= " ". $str_limit;
			$bindValues[] = $offset;
			$bindValues[] = $limit;
		}*/
		//var_dump($query, $searchForName);
		$rows =
			$wpdb->get_results(
				$wpdb->prepare(
					$query,
					/*$bindValues*/null
					)
				);
		//var_dump( $rows ); 
		return $rows;
	}
}