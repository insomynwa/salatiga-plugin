<?php

class Sltg_Kategori_Craft {

	private $table_name;

	private $id;
	public function GetID(){ return $this->id; }

	private $nama;
	public function GetNama() { return $this->nama; }
	public function SetNama( $nama ) { $this->nama = $nama; }

	// IN RELATIONSHIP
	// public function GetProducts() { 
	// 	$arrProduct = array();

	// 	$obj_product = new Sltg_Product();
	// 	$list_product = $obj_product->ListByCategory( $this->id );
	// 	foreach( $list_product as $p ) {
	// 		$product = new Sltg_Product();
	// 		$product->HasID( $p->id_produk );
	// 		$arrProduct[] = $product;
	// 	}
	// 	return $arrProduct; 
	// }

	function __construct() {
		$this->table_name = "ext_kategori_craft";
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

	public function DataList( $limit = -1, $offset = -1, $searchForName = "", $kategori = 0) {
		global $wpdb;
		$query = "SELECT id_kategori FROM $this->table_name " .
					"WHERE nama_kategori LIKE %s";
		$bindValues = array();
		$bindValues[] = "%".$searchForName."%";

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

	public function CountData( $searchForName = "", $arg1 = null ) {
		global $wpdb;

		$query = "SELECT COUNT(id_kategori) AS jumlah FROM $this->table_name " .
					"WHERE nama_kategori LIKE %s";
		$bindValues = array();
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

	function AddNew() {
		global $wpdb;

		$result = array( 'status' => false, 'message' => 'Error AddNew()-kategori' );

		if( $this->validCategoryName() ) {
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
		}
		return $result;
	}

	private function validCategoryName() {
		global $wpdb;

		$query = "SELECT COUNT(id_kategori) AS jumlah FROM $this->table_name " .
					"WHERE nama_kategori = %s";
		$bindValues = array();
		$bindValues[] = $this->nama;

		$jumlah =
			$wpdb->get_var(
				$wpdb->prepare(
					$query,
					$bindValues
					)
				);
		if( $jumlah == 0 ) return true;
		return false;
	}

	public function Delete(){
		global $wpdb;

		$result = array( "status" => false, "message" => "" );
		if( $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $this->table_name WHERE id_kategori = %d",
				$this->id
			)
		)) {
			$statusUpdateProducts = $this->updateProducts();
			$result ['status'] = $statusUpdateProducts;
		}

		return $result;
	}

	private function updateProducts() {
		$arrProducts = $this->GetProducts();

		$result[ 'status' ] = ( sizeof( $arrProducts ) == 0 );

		if( sizeof( $arrProducts ) > 0 ) {
			foreach( $arrProducts as $product ) {
				$product->SetKategori(0);
				$result[ 'status' ] = $product->Update();
			}
		}

		return $result[ 'status' ];
	}

	public function Update() {
		global $wpdb;
		$result = array( "status" => false, "message" => "gagal update kategori" );

		if( $this->validCategoryName() ) {
			$arrUpdateData = array(
				'nama_kategori' => $this->nama
				);
			$arrCondition = array( 'id_kategori' => $this->id );
			$arrDataType = array( '%s' );
			$arrConditionType = array( '%d' );

			if( $wpdb->update(
				$this->table_name,
				$arrUpdateData,
				$arrCondition,
				$arrDataType,
				$arrConditionType
				) )
			{
				$result[ 'status' ] = true;
				$result[ 'message' ] = "berhasil update kategori";
			}
		}
		return $result;
	}
}