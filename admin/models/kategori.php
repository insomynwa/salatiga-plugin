<?php

class Sltg_Kategori_Product {

	private $table_name;

	private $id;
	public function GetID(){ return $this->id; }

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

	public function FindName() {
		global $wpdb;

		$query = "SELECT * FROM $this->table_name WHERE nama_kategori = %s LIMIT %d";
		
		$row =
			$wpdb->get_row(
				$wpdb->prepare(
					$query,
					$this->nama, 1
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

	public function DataList( $arg1 = "", $arg2 = 0, $arg3 = null, $arg4 = null) {
		global $wpdb;

		$query = "SELECT id_kategori FROM $this->table_name";
		$rows =
			$wpdb->get_results(
				$wpdb->prepare(
					$query,
					null
					)
				);

		return $rows;
	}

	function AddNew() {
		global $wpdb;

		$result = array( 'status' => false, 'message' => 'Error AddNew()-kategori' );

		if( $wpdb->insert(
			$this->table_name,
			array(
				'nama_kategori' => $this->nama
				),
			array(
				'%s'
				)
			) ){
			$result[ 'status' ] = true;
			$result[ 'message' ] = 'Berhasil menambah kategori';
			$result[ 'new_id' ] = $wpdb->insert_id;
		}
		return $result;
	}
}