<?php

require_once( 'database.php' );

class Media extends CoreModel {

  protected $id;
  protected $genre_id;
  protected $title;
  protected $type;
  protected $status;
  protected $release_date;
  protected $summary;
  protected $trailer_url;
  protected $duration;

  public function __construct( $media ) {
    $this->hydrate($media);
  }

  /***************************
  * -------- SETTERS ---------
  ***************************/

  public function setId( $id ) {
    $this->id = $id;
  }

  public function setGenreId( $genre_id ) {
    $this->genre_id = $genre_id;
  }

  public function setTitle( $title ) {
    $this->title = $title;
  }

  public function setType( $type ) {
    $this->type = $type;
  }

  public function setStatus( $status ) {
    $this->status = $status;
  }

  public function setReleaseDate( $release_date ) {
    $this->release_date = $release_date;
  }

  public function setSummary( $summary ) {
    $this->summary = $summary;
  }

  public function setTrailerUrl( $trailer ) {
    $this->trailer_url = $trailer;
  }

  public function setDuration($duration)
  {
      $this->duration = $duration;
  }

  /***************************
  * -------- GETTERS ---------
  ***************************/

  public function getId() {
    return $this->id;
  }

  public function getGenreId() {
    return $this->genre_id;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getType() {
    return $this->type;
  }

  public function getStatus() {
    return $this->status;
  }

  public function getReleaseDate() {
    return $this->release_date;
  }

  public function getSummary() {
    return $this->summary;
  }

  public function getTrailerUrl() {
    return $this->trailer_url;
  }

  public function getDuration()
  {
      return $this->duration;
  }

  /***************************
  * -------- GET LIST --------
  ***************************/

  public static function filterMedias( $title ) {

    // Open database connection
    $db   = init_db();


    $req  = $db->prepare( "SELECT media.*
    FROM media 
    INNER JOIN genre
    ON media.genre_id = genre.id
    WHERE media.title LIKE :query
    OR media.type LIKE :query
    OR genre.name LIKE :query
    ORDER BY release_date DESC" );
    $req->execute( array( 'query' => '%' . $title . '%' ));

    // Close databse connection
    $db   = null;

    return $req->fetchAll();

  }

  public static function getMediaById($id) {
    if(!is_numeric($id))
      throw new Exception("getMediaById : the id must be numeric");

    $db = init_db();

    $req = $db->prepare("SELECT media.*, genre.name AS genre FROM media  
    INNER JOIN genre
    ON genre_id = genre.id
    WHERE media.id = ?");
    $req->execute([$id]);

    $db = null;
    $fetch = $req->fetch(PDO::FETCH_ASSOC);

    return $fetch;
    
  }


}
