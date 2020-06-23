<?php

require_once( 'model/media.php' );

/***************************
* ----- LOAD HOME PAGE -----
***************************/

function mediaPage() {

  $search = isset( $_GET['title'] ) ? $_GET['title'] : null;
  $medias = Media::filterMedias( $search );

  require('view/mediaListView.php');

}

/***************************
* ----- LOAD MEDIA PAGE ----
***************************/

function showMedia() {

  $id = isset($_GET['media']) ? $_GET['media'] : false;

  if($id && is_numeric($id)) {
    
    $data = Media::getMediaById($id);

    $md = new stdClass();
    foreach($data as $key => $value) {
      $md->$key = $value;
    }
    

    $media = new Media($md);


    require('view/mediaView.php');

  }

}