<?php

class Sltg_TouristSite implements iListItem {

	private $table_name;

	private $listfor;
	public function iSet_Listfor( $listfor ) { $this->listfor = $listfor; }
	public function iGet_Listfor() { return $this->listfor; }

	private $limit_name;
	public function iSet_LimitName( $limit_name ) { $this->limit_name = $limit_name; }
	public function iGet_LimitName() { return $this->limit_name; }

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

	private $other;
	public function GetOther() { return $this->other; }
	public function SetOther($other) { $this->other = $other; }

	private $latitude;
	public function GetLatitude() { return $this->latitude; }
	public function SetLatitude($latitude) { $this->latitude = $latitude; }

	private $longitude;
	public function GetLongitude() { return $this->longitude; }
	public function SetLongitude($longitude) { $this->longitude = $longitude; }

	private $telp;
	public function GetTelp() { return $this->telp; }
	public function SetTelp($telp) { $this->telp = $telp; }

	// IN RELATIONSHIP

	private $kategori;
	public function GetKategori() { 
		$obj_kat = new Sltg_Kategori_TouristSite();
		$obj_kat->HasID( $this->kategori );
		//$this->kategori = $obj_kat;
		return $obj_kat; 
	}
	public function SetKategori( $kategori ) { $this->kategori = $kategori; }

	/*private $ukm;
	public function GetUKM() { 
		$obj_ukm = new Sltg_Personal();
		$obj_ukm->HasID( $this->ukm );
		//$this->ukm = $obj_ukm;

		return $obj_ukm; 
	}
	public function SetUKM( $ukm ) { $this->ukm = $ukm; }*/

	//private $gambar_utama;
	public function GetGambarUtama() { 
		$obj_gbr = new Sltg_Gambar();

		$obj_gbr->UtamaByOwner( $this->pict_code );
		//var_dump($obj_gbr->UtamaByOwner( $this->pict_code )->GetLinkGambar());
		return $obj_gbr; 
	}
	//public function SetGambarUtama( $gambar_utama ) { $this->gambar_utama = $gambar_utama; }

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
	//public function SetGambars( $gambars ) { $this->gambars = $gambars; }

	function __construct() {
		$this->table_name = "ext_touristsite";

		$this->iSet_Listfor( 'touristsite' );
		$this->iSet_LimitName( 'touristsite_list_limit' );
	}

	public function HasID( $touristsite_id = 0){
		global $wpdb;
		$row =
			$wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name 
					WHERE id_touristsite = %d",
					$touristsite_id
					),
				ARRAY_A
				);
		$result = ! is_null( $row );
		if ( $result ){
			$this->id = $row[ 'id_touristsite' ];
			$this->pict_code = 'TOUR' . $row[ 'id_touristsite' ];
			$this->nama = $row[ 'nama_touristsite' ];
			$this->alamat = $row[ 'alamat_touristsite' ];
			$this->deskripsi = $row[ 'deskripsi_touristsite' ];
			$this->other = $row[ 'infolain_touristsite' ];
			$this->latitude = $row[ 'latitude_touristsite' ];
			$this->longitude = $row[ 'longitude_touristsite' ];
			$this->telp = $row[ 'telp_touristsite' ];
			$this->kategori = $row[ 'kategori' ];

		}
		return $result;
	}

	public function CountData( $searchForName = "", $kategori = 0 ) {
		global $wpdb;

		$str_operator = ">=";
		if ( $kategori > 0 )
			$str_operator = "=";
		$query = "SELECT COUNT(id_touristsite) AS jumlah FROM $this->table_name " .
					"WHERE kategori $str_operator %d AND nama_touristsite LIKE %s";
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

		$str_operator = ">=";
		if ( $kategori > 0 )
			$str_operator = "=";
		$query = "SELECT id_touristsite FROM $this->table_name " . 
					"WHERE kategori $str_operator %d AND nama_touristsite LIKE %s";
		$bindValues = array();
		$bindValues[] = $kategori;
		$bindValues[] = "%".$searchForName."%";
		$query .= " ORDER BY nama_touristsite";

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

		$result = array( 'status' => false, 'message' => 'Error AddNew()-Tourist Site' );

		if( $wpdb->insert(
			$this->table_name,
			array(
				'nama_touristsite' => $this->nama,
				'alamat_touristsite' => $this->alamat,
				'deskripsi_touristsite' => $this->deskripsi,
				'infolain_touristsite' => $this->other,
				'latitude_touristsite' => $this->latitude,
				'longitude_touristsite' => $this->longitude,
				'telp_touristsite' => $this->telp,
				'kategori' => $this->kategori
				),
			array(
				'%s', '%s', '%s', '%s', '%f', '%f', '%s', '%d'
				)
			) ){
			$result[ 'status' ] = true;
			$result[ 'message' ] = 'Berhasil menambah Tourist Site';
			$result[ 'new_id' ] = $wpdb->insert_id;
		}
		return $result;
	}

	public function Delete(){
		global $wpdb;

		$result = array( "status" => false, "message" => "" );
		if( $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $this->table_name WHERE id_touristsite = %d",
				$this->id
			)
		)) {
			$result ['status'] = $this->deleteGambars();
		}

		return $result;

	}

	public function deleteGambars() {

		$arrGambar = $this->GetGambars();
		global $wpdb;

		$obj_gbr = new Sltg_Gambar();
		$obj_gbr->SetOwner( $this->pict_code );

		$result = $obj_gbr->DeleteMultiple();

		foreach( $arrGambar as $gbr ) {
			$result = $result && $gbr->DeletePost();
		}
		return $result;
	}

	public function Update() {
		global $wpdb;
		$result = array( "status" => false, "message" => "gagal update Tourist Site" );

		$arrUpdateData = array(
			'nama_touristsite' => $this->nama,
			'alamat_touristsite' => $this->alamat,
			'deskripsi_touristsite' => $this->deskripsi,
			'infolain_touristsite' => $this->other,
			'telp_touristsite' => $this->telp,
			'latitude_touristsite' => $this->latitude,
			'longitude_touristsite' => $this->longitude,
			'kategori' => $this->kategori
			);
		$arrCondition = array( 'id_touristsite' => $this->id );
		$arrDataType = array( '%s', '%s', '%s', '%s', '%s', '%f', '%f', '%d');
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
			$result[ 'message' ] = "berhasil update Tourist Site";
		}
		return $result;
	}

	public function ListByCategory( $cat ) {
		global $wpdb;

		$rows =
			$wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name ".
					"WHERE kategori = %d",
					$cat
					)
				);
		return $rows;
	}
}