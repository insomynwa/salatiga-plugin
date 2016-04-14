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
	public function GetPemilik() { 
		$obj_person = new Sltg_Personal();
		$obj_person->HasID( $this->pemilik );
		return $obj_person; 
	}
	public function SetPemilik($pemilik) { $this->pemilik = $pemilik; }
	
	//private $gambar_utama;
	public function GetGambarUtama() { 
		$obj_gbr = new Sltg_Gambar();

		$obj_gbr->UtamaByOwner( $this->pict_code );
		//var_dump($obj_gbr->UtamaByOwner( $this->pict_code )->GetLinkGambar());
		return $obj_gbr; 
	}
	// public function SetGambarUtama( $gambar_utama ) { $this->gambar_utama = $gambar_utama; }

	//private $gambars;
	public function GetGambars() { 
		$arrGambar = array();
		$obj_gbr = new Sltg_Gambar();

		$list_gambar = $obj_gbr->ListByOwner( $this->pict_code );
		foreach( $list_gambar as $g) {
			$gambar = new Sltg_Gambar();
			$gambar->HasID( $g->id_gambar );

			$arrGambar[] = $gambar;
		}

		return $arrGambar; 
	}

	private $products;
	public function GetProducts() { 
		$obj_product = new Sltg_Product();
		$list_product = $obj_product->ListByOwner( $this->id );
		foreach( $list_product as $p ) {
			$product = new Sltg_Product();
			$product->HasID( $p->id_produk );
			$this->products[] = $product;
		}
		return $this->products; 
	}
	// public function SetProducts( $products ) { $this->products = $products; }


	function __construct() {
		$this->table_name = "ext_ukm";
		$this->products = array();
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
			$this->pemilik = $row[ 'pemilik' ];
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

	public function AddNew() {
		global $wpdb;

		$result = array( 'status' => false, 'message' => 'Error AddNew()-ukm' );

		if( $wpdb->insert(
			$this->table_name,
			array(
				'nama_ukm' => $this->nama,
				'deskripsi_ukm' => $this->deskripsi,
				'other_ukm' => $this->other,
				'alamat_ukm' => $this->alamat,
				'telp_ukm' => $this->telp,
				'pemilik' => $this->pemilik
				),
			array(
				'%s', '%s', '%s', '%s', '%s', '%d'
				)
			) ){
			$result[ 'status' ] = true;
			$result[ 'message' ] = 'Berhasil menambah ukm';
			$result[ 'new_id' ] = $wpdb->insert_id;
		}
		return $result;
	}

	public function Delete(){
		global $wpdb;

		$result = array( "status" => false, "message" => "" );
		if( $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $this->table_name WHERE id_ukm = %d",
				$this->id
			)
		)) {
			$statusDelGambars = $this->deleteGambars();
			$statusDelProducts = $this->deleteProducts();
			$result ['status'] = $statusDelGambars && $statusDelProducts;
		}

		return $result;

	}

	public function deleteGambars() {
		$arrGambar = $this->GetGambars();
		//global $wpdb;
		$result = ( sizeof( $arrGambar ) == 0 );

		if( sizeof( $arrGambar ) > 0 ) {
			$obj_gbr = new Sltg_Gambar();
			$obj_gbr->SetOwner( $this->pict_code );

			$result = $obj_gbr->DeleteMultiple();

			foreach( $arrGambar as $gbr ) {
				$result = $result && $gbr->DeletePost();
			}
			
		}
		return $result;
	}

	private function deleteProducts() {
		$arrProducts = $this->GetProducts();
		//global $wpdb;
		$result[ 'status' ] = ( sizeof( $arrProducts ) == 0 );

		if( sizeof( $arrProducts ) > 0 ) {
			foreach( $arrProducts as $product ) {
				// $product = new Sltg_Product();
				// $product->HasID( $p->id_produk );
				$result[ 'status' ] = $product->Delete();
			}
		}

		return $result[ 'status' ];
	}

	public function Update() {
		global $wpdb;
		$result = array( "status" => false, "message" => "gagal update ukm" );

		$arrUpdateData = array(
			'nama_ukm' => $this->nama,
			'deskripsi_ukm' => $this->deskripsi,
			'other_ukm' => $this->other,
			'telp_ukm' => $this->telp,
			'alamat_ukm' => $this->alamat,
			'pemilik' => $this->pemilik
			);
		$arrCondition = array( 'id_ukm' => $this->id );
		$arrDataType = array( '%s', '%s', '%s', '%s', '%s', '%d' );
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
			$result[ 'message' ] = "berhasil update ukm";
		}
		return $result;
	}
}