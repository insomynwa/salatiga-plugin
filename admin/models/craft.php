<?php

class Sltg_Craft implements iListItem {

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

	private $other;
	public function GetOther() { return $this->other; }
	public function SetOther($other) { $this->other = $other; }

	// IN RELATIONSHIP

	private $kategori;
	public function GetKategori() { 
		$obj_kat = new Sltg_Kategori_Craft();
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

	private $producer;
	public function GetProducer() { 
		$obj_producer = new Sltg_Personal();
		$obj_producer->HasID( $this->producer );
		//$this->ukm = $obj_ukm;

		return $obj_producer;
	}
	public function SetProducer( $producer ) { $this->producer = $producer; }

	function __construct() {
		$this->table_name = "ext_craft";

		$this->iSet_Listfor( 'craft' );
		$this->iSet_LimitName( 'craft_list_limit' );
		//$this->gambars = array();
	}

	public function HasID( $craft_id = 0){
		global $wpdb;
		$row =
			$wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name 
					WHERE id_craft = %d",
					$craft_id
					),
				ARRAY_A
				);
		$result = ! is_null( $row );
		if ( $result ){
			$this->id = $row[ 'id_craft' ];
			$this->pict_code = 'CRF' . $row[ 'id_craft' ];
			$this->nama = $row[ 'nama_craft' ];
			$this->deskripsi = $row[ 'deskripsi_craft' ];
			$this->other = $row[ 'other_craft' ];
			$this->kategori = $row[ 'kategori' ];
			$this->producer = $row[ 'producer' ];

		}
		return $result;
	}

	public function CountData( $searchForName = "", $kategori = 0 ) {
		global $wpdb;

		$str_operator = ">=";
		if ( $kategori > 0 )
			$str_operator = "=";
		$query = "SELECT COUNT(id_craft) AS jumlah FROM $this->table_name " .
					"WHERE kategori $str_operator %d AND nama_craft LIKE %s";
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
		$query = "SELECT id_craft FROM $this->table_name " . 
					"WHERE kategori $str_operator %d AND nama_craft LIKE %s";
		$bindValues = array();
		$bindValues[] = $kategori;
		$bindValues[] = "%".$searchForName."%";
		$query .= " ORDER BY nama_craft";

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

		$result = array( 'status' => false, 'message' => 'Error AddNew()-craft' );

		if( $wpdb->insert(
			$this->table_name,
			array(
				'nama_craft' => $this->nama,
				'deskripsi_craft' => $this->deskripsi,
				'other_craft' => $this->other,
				'kategori' => $this->kategori,
				'producer' => $this->producer
				),
			array(
				'%s', '%s', '%s', '%d', '%d'
				)
			) ){
			$result[ 'status' ] = true;
			$result[ 'message' ] = 'Berhasil menambah craft';
			$result[ 'new_id' ] = $wpdb->insert_id;
		}
		return $result;
	}

	public function Delete(){
		global $wpdb;

		$result = array( "status" => false, "message" => "" );
		if( $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $this->table_name WHERE id_craft = %d",
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
		$result = array( "status" => false, "message" => "gagal update craft" );

		$arrUpdateData = array(
			'nama_craft' => $this->nama,
			'deskripsi_craft' => $this->deskripsi,
			'other_craft' => $this->other,
			'kategori' => $this->kategori,
			'producer' => $this->producer
			);
		$arrCondition = array( 'id_craft' => $this->id );
		$arrDataType = array( '%s', '%s', '%s', '%d', '%d');
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
			$result[ 'message' ] = "berhasil update craft";
		}
		return $result;
	}

	public function ListByOwner( $owner ) {
		global $wpdb;

		$rows =
			$wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name ".
					"WHERE producer = %d",
					$owner
					)
				);//var_dump($rows);
		return $rows;
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
				);//var_dump($rows);
		return $rows;
	}
}