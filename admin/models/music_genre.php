<?php

class Sltg_Genre_Music {

	private $table_name;

	private $id;
	public function GetID(){ return $this->id; }

	private $nama;
	public function GetNama() { return $this->nama; }
	public function SetNama( $nama ) { $this->nama = $nama; }

	// IN RELATIONSHIP
	public function GetMusics() { 
		$arrMusic = array();

		$obj_music = new Sltg_Music();
		$list_music = $obj_music->ListByGenre( $this->id );
		foreach( $list_music as $m) {
			$music = new Sltg_Music();
			$music->HasID( $m->id_music );
			$arrMusic[] = $music;
		}
		return $arrMusic; 
	}

	function __construct() {
		$this->table_name = "ext_genre_music";
	}

	public function HasID( $genre_id = 0){
		global $wpdb;
		$row =
			$wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name 
					WHERE id_genre = %d",
					$genre_id
					),
				ARRAY_A
				);
		$result = ! is_null( $row );
		if ( $result ){
			$this->id = $row[ 'id_genre' ];
			$this->nama = $row[ 'nama_genre' ];
		}
		return $result;
	}

	public function FindName() {
		global $wpdb;

		$query = "SELECT * FROM $this->table_name WHERE nama_genre = %s LIMIT %d";
		
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
			$this->id = $row[ 'id_genre' ];
			$this->nama = $row[ 'nama_genre' ];
		}
		return $result;
	}

	public function DataList( $limit = -1, $offset = -1, $searchForName = "", $kategori = 0) {
		global $wpdb;
		$query = "SELECT id_genre FROM $this->table_name " .
					"WHERE nama_genre LIKE %s";
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

	public function CountData( $searchForName = "", $arg1 = null ) {
		global $wpdb;

		//$query = "SELECT COUNT(id_ukm) AS jumlah FROM $this->table_name";
		$query = "SELECT COUNT(id_genre) AS jumlah FROM $this->table_name " .
					"WHERE nama_genre LIKE %s";
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

	function AddNew() {
		global $wpdb;

		$result = array( 'status' => false, 'message' => 'Error AddNew()-genre' );

		if( $this->validGenreName() ) {
			if( $wpdb->insert(
				$this->table_name,
				array(
					'nama_genre' => $this->nama
					),
				array(
					'%s'
					)
				) ){
				$result[ 'status' ] = true;
				$result[ 'message' ] = 'Berhasil menambah genre';
				$result[ 'new_id' ] = $wpdb->insert_id;
			}
		}
		return $result;
	}

	private function validGenreName() {
		global $wpdb;

		$query = "SELECT COUNT(id_genre) AS jumlah FROM $this->table_name " .
					"WHERE nama_genre = %s";
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
				"DELETE FROM $this->table_name WHERE id_genre = %d",
				$this->id
			)
		)) {
			$statusUpdateMusic = $this->updateMusics();
			$result ['status'] = $statusUpdateMusic;
		}

		return $result;
	}

	private function updateMusics() {
		$arrMusics = $this->GetMusics();
		//global $wpdb;
		$result[ 'status' ] = ( sizeof( $arrMusics ) == 0 );

		if( sizeof( $arrMusics ) > 0 ) {
			foreach( $arrMusics as $music ) {
				// $product = new Sltg_Music();
				// $product->HasID( $p->id_produk );
				$music->SetGenre(0);
				$result[ 'status' ] = $music->Update();
			}
		}

		return $result[ 'status' ];
	}

	public function Update() {
		global $wpdb;
		$result = array( "status" => false, "message" => "gagal update genre" );

		if( $this->validGenreName() ) {
			$arrUpdateData = array(
				'nama_genre' => $this->nama
				);
			$arrCondition = array( 'id_genre' => $this->id );
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
				$result[ 'message' ] = "berhasil update genre";
			}
		}
		return $result;
	}
}