<?php

class Sltg_Jenis_Kamar implements iListItem {

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
	
	private $deskripsi;
	public function GetDeskripsi() { return $this->deskripsi; }
	public function SetDeskripsi($deskripsi) { $this->deskripsi = $deskripsi; }

	// IN RELATIONSHIP

	public function GetGambarUtama() { 
		$obj_gbr = new Sltg_Gambar();

		$obj_gbr->UtamaByOwner( $this->pict_code );

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

	private $hotel;
	public function GetHotel() { 
		$obj_hotel = new Sltg_Hotel();
		$obj_hotel->HasID( $this->hotel );

		return $obj_hotel;
	}
	public function SetHotel( $hotel ) { $this->hotel = $hotel; }

	function __construct() {
		$this->table_name = "ext_jeniskamar";

		$this->iSet_Listfor( 'jeniskamar' );
		$this->iSet_LimitName( 'jeniskamar_list_limit' );
	}

	public function HasID( $jeniskamar_id = 0){
		global $wpdb;
		$row =
			$wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name 
					WHERE id_jeniskamar = %d",
					$jeniskamar_id
					),
				ARRAY_A
				);
		$result = ! is_null( $row );
		if ( $result ){
			$this->id = $row[ 'id_jeniskamar' ];
			$this->pict_code = 'JKH' . $row[ 'id_jeniskamar' ];
			$this->nama = $row[ 'nama_jeniskamar' ];
			$this->deskripsi = $row[ 'deskripsi_jeniskamar' ];
			$this->hotel = $row[ 'hotel' ];

		}
		return $result;
	}

	public function CountData( $searchForName = "", $hotel = 0 ) {
		global $wpdb;

		$str_operator = ">=";
		if ( $hotel > 0 )
			$str_operator = "=";
		$query = "SELECT COUNT(id_jeniskamar) AS jumlah FROM $this->table_name " .
					"WHERE hotel $str_operator %d AND nama_jeniskamar LIKE %s";
		$bindValues = array();
		$bindValues[] = $hotel;
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

	public function DataList( $limit = -1, $offset = -1, $searchForName = "", $hotel = 0) {
		global $wpdb;

		$str_operator = ">=";
		if ( $hotel > 0 )
			$str_operator = "=";
		$query = "SELECT id_jeniskamar FROM $this->table_name " . 
					"WHERE hotel $str_operator %d AND nama_jeniskamar LIKE %s";
		$bindValues = array();
		$bindValues[] = $hotel;
		$bindValues[] = "%".$searchForName."%";
		$query .= " ORDER BY nama_jeniskamar";

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

		$result = array( 'status' => false, 'message' => 'Error AddNew()-jeniskamar' );

		if( $wpdb->insert(
			$this->table_name,
			array(
				'nama_jeniskamar' => $this->nama,
				'deskripsi_jeniskamar' => $this->deskripsi,
				'hotel' => $this->hotel
				),
			array(
				'%s', '%s', '%d'
				)
			) ){
			$result[ 'status' ] = true;
			$result[ 'message' ] = 'Berhasil menambah jeniskamar';
			$result[ 'new_id' ] = $wpdb->insert_id;
		}
		return $result;
	}

	public function Delete(){
		global $wpdb;

		$result = array( "status" => false, "message" => "" );
		if( $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $this->table_name WHERE id_jeniskamar = %d",
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
		$result = array( "status" => false, "message" => "gagal update jeniskamar" );

		$arrUpdateData = array(
			'nama_jeniskamar' => $this->nama,
			'deskripsi_jeniskamar' => $this->deskripsi,
			'hotel' => $this->hotel
			);
		$arrCondition = array( 'id_jeniskamar' => $this->id );
		$arrDataType = array( '%s', '%s', '%d');
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
			$result[ 'message' ] = "berhasil update jeniskamar";
		}
		return $result;
	}

	public function ListByOwner( $owner ) {
		global $wpdb;

		$rows =
			$wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name ".
					"WHERE hotel = %d",
					$owner
					)
				);//var_dump($rows);
		return $rows;
	}
}