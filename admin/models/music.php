<?php

class Sltg_Music {

	private $table_name;
	/*private $creator_pict_name;*/

	private $id;
	public function GetId(){ return $this->id; }

	private $source;
	public function GetSource() { return $this->source; }
	public function SetSource( $source ) { $this->source = $source; }
	
	private $title;
	public function GetTitle() { return $this->title; }
	public function SetTitle($title) { $this->title = $title; }
	
	private $info;
	public function GetInfo() { return $this->info; }
	public function SetInfo($info) { $this->info = $info; }

	// IN RELATIONSHIO
	private $creator;
	public function GetCreator() {
		$obj_creator = new Sltg_Personal();
		$obj_creator->HasID( $this->creator );
		//$this->ukm = $obj_ukm;

		return $obj_creator;
	}
	public function SetCreator($creator) { $this->creator = $creator; }

	private $genre;
	public function GetGenre() {
		$obj_genre = new Sltg_Genre_Music();
		$obj_genre->HasID( $this->genre );
		//$this->kategori = $obj_kat;
		return $obj_genre; 
	}
	public function SetGenre($genre) { $this->genre = $genre; }

	function __construct() {
		$this->table_name = 'ext_music';

		/*if( $table_name == 'ext_music_creator')
			$this->creator_pict_name = 'creator';*/
	}

	function HasID( $music_id = 0 ) {
		global $wpdb;

		$row =
			$wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name 
					WHERE id_music = %d",
					$music_id
					),
				ARRAY_A
				);
		$result = ! is_null( $row );
		if ( $result ){
			$this->id = $row[ 'id_music' ];
			$this->source = $row[ 'source_music' ];
			$this->title = $row[ 'title_music' ];
			$this->info = $row[ 'info_music' ];
			$this->creator = $row[ 'creator' ];
			$this->genre = $row[ 'genre' ];

		}
		return $result;
	}

	public function CountData( $searchForTitle = "", $genre = 0 ) {
		global $wpdb;

		$str_operator = ">=";
		if ( $genre > 0 )
			$str_operator = "=";
		$query = "SELECT COUNT(id_music) AS jumlah FROM $this->table_name " .
					"WHERE genre $str_operator %d AND title_music LIKE %s";
		$bindValues = array();
		$bindValues[] = $genre;
		$bindValues[] = "%".$searchForTitle."%";

		$jumlah =
			$wpdb->get_var(
				$wpdb->prepare(
					$query,
					$bindValues
					)
				);

		return is_null( $jumlah )? 0 : $jumlah;
	}

	public function DataList( $limit = -1, $offset = -1, $searchForTitle = "", $genre = 0) {
		global $wpdb;

		$str_operator = ">=";
		if ( $genre > 0 )
			$str_operator = "=";
		$query = "SELECT id_music FROM $this->table_name " . 
					"WHERE genre $str_operator %d AND title_music LIKE %s";
		$bindValues = array();
		$bindValues[] = $genre;
		$bindValues[] = "%".$searchForTitle."%";
		$query .= " ORDER BY title_music";

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

	function AddNew() {
		global $wpdb;

		$result = array( 'status' => false, 'message' => 'Error AddNew()-music' );

		if( $wpdb->insert(
			$this->table_name,
			array(
				'title_music' => $this->title,
				'source_music' => $this->source,
				'creator' => $this->creator,
				'genre' => $this->genre,
				'info_music' => $this->info
				),
			array(
				'%s', '%s', '%d', '%d', '%s'
				)
			) ){
			$result[ 'status' ] = true;
			$result[ 'message' ] = 'Berhasil menambah music';
		}
		return $result;
	}

	public function Delete(){
		global $wpdb;

		$result = array( "status" => false, "message" => "" );
		if( $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $this->table_name WHERE id_music = %d",
				$this->id
			)
		)) {
			$result ['status'] = true;
			$result ['message'] = "berhasil delete music";
		}

		return $result;

	}

	public function ListByOwner( $creator ) {
		global $wpdb;

		$rows =
			$wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name ".
					"WHERE creator = %s",
					$creator
					)
				);//var_dump($rows);
		return $rows;
	}

	public function Update() {
		global $wpdb;
		$result = array( "status" => false, "message" => "gagal update music" );

		$arrUpdateData = array(
			'title_music' => $this->title,
			'source_music' => $this->source,
			'info_music' => $this->info,
			'creator' => $this->creator,
			'genre' => $this->genre
			);
		$arrCondition = array( 'id_music' => $this->id );
		$arrDataType = array( '%s', '%s', '%s', '%d', '%d' );
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
			$result[ 'message' ] = "berhasil update music";
		}
		
		return $result;
	}

}