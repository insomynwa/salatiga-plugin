<?php

class Sltg_Personal {

	private $table_name;

	private $id;
	public function GetID(){ return $this->id; }

	private $pict_code;
	public function GetPictCode() { return $this->pict_code; }
	public function SetPictCode( $pict_code ) { $this->pict_code = $pict_code; }

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

	//private $products;
	public function GetUKMs() { 
		$arrUKM = array();
		$obj_ukm = new Sltg_UKM();
		$list_ukm = $obj_ukm->ListByOwner( $this->id );
		foreach( $list_ukm as $u ) {
			$ukm = new Sltg_UKM();
			$ukm->HasID( $u->id_ukm );
			$arrUKM[] = $ukm;
		}
		return $arrUKM; 
	}
	// public function SetProducts( $products ) { $this->products = $products; }

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
			$this->pict_code = 'FC' . $row[ 'id_personal' ];
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

		$result = array( 'status' => false, 'message' => 'Error AddNew()-ukm' );

		if( $wpdb->insert(
			$this->table_name,
			array(
				'nama_personal' => $this->nama,
				'alamat_personal' => $this->alamat,
				'deskripsi_personal' => $this->deskripsi,
				'telp_personal' => $this->telp,
				'other_personal' => $this->other
				),
			array(
				'%s', '%s', '%s', '%s', '%s'
				)
			) ){
			$result[ 'status' ] = true;
			$result[ 'message' ] = 'Berhasil menambah personal';
			$result[ 'new_id' ] = $wpdb->insert_id;
		}
		return $result;
	}

	public function Update() {
		global $wpdb;
		$result = array( "status" => false, "message" => "gagal update person" );

		$arrUpdateData = array(
			'nama_personal' => $this->nama,
			'alamat_personal' => $this->alamat,
			'deskripsi_personal' => $this->deskripsi,
			'telp_personal' => $this->telp,
			'other_personal' => $this->other
			);
		$arrCondition = array( 'id_personal' => $this->id );
		$arrDataType = array( '%s', '%s', '%s', '%s', '%s' );
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
			$result[ 'message' ] = "berhasil update person";
		}
		return $result;
	}

	public function Delete(){
		global $wpdb;

		$result = array( "status" => false, "message" => "" );
		if( $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $this->table_name WHERE id_personal = %d",
				$this->id
			)
		)) {
			$statusDelGambars = $this->deleteGambars();
			$statusUpdateProducts = $this->updateUKMs();
			$result ['status'] = $statusDelGambars && $statusUpdateProducts;
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

	private function updateUKMs() {
		$arrUKM = $this->GetUKMs();
		//global $wpdb;
		$result[ 'status' ] = ( sizeof( $arrUKM ) == 0 );

		if( sizeof( $arrUKM ) > 0 ) {
			foreach( $arrUKM as $ukm ) {
				// $product = new Sltg_Product();
				// $product->HasID( $p->id_produk );
				$ukm->SetPemilik(0);
				$result[ 'status' ] = $ukm->Update();
			}
		}

		return $result[ 'status' ];
	}
}