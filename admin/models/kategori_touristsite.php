<?php

class Sltg_Kategori_TouristSite implements IListItem{

	private $table_name;

	private $listfor;
	public function iSet_Listfor( $listfor ) { $this->listfor = $listfor; }
	public function iGet_Listfor() { return $this->listfor; }

	private $limit_name;
	public function iSet_LimitName( $limit_name ) { $this->limit_name = $limit_name; }
	public function iGet_LimitName() { return $this->limit_name; }

	private $id;
	public function GetID(){ return $this->id; }

	private $nama;
	public function GetNama() { return $this->nama; }
	public function SetNama( $nama ) { $this->nama = $nama; }

	// IN RELATIONSHIP
	public function GetTouristSites() { 
		$arrTouristSite = array();

		$obj_touristsite = new Sltg_TouristSite();
		$list_touristsite = $obj_touristsite->ListByCategory( $this->id );
		foreach( $list_touristsite as $tr ) {
			$touristsite = new Sltg_TouristSite();
			$touristsite->HasID( $tr->id_touristsite );
			$arrTouristSite[] = $touristsite;
		}
		return $arrTouristSite; 
	}

	function __construct() {
		$this->table_name = "ext_kategori_touristsite";

		$this->iSet_Listfor( 'kattouristsite' );
		$this->iSet_LimitName( 'kattouristsite_list_limit' );
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
			$statusTouristSites = $this->updateTouristSites();
			$result ['status'] = $statusTouristSites;
		}

		return $result;
	}

	private function updateTouristSites() {
		$arrTouristSites = $this->GetTouristSites();

		$result[ 'status' ] = ( sizeof( $arrTouristSites ) == 0 );

		if( sizeof( $arrTouristSites ) > 0 ) {
			foreach( $arrTouristSites as $touristsite ) {
				$touristsite->SetKategori(0);
				$result[ 'status' ] = $touristsite->Update();
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