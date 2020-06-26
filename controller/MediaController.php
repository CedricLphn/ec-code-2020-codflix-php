<?php

require_once( 'model/media.php' );
require_once( 'model/watchlist.php' );

/***************************
* ----- LOAD HOME PAGE -----
***************************/

function mediaPage() {

  $search = isset( $_GET['title'] ) ? htmlentities($_GET['title']) : null;

  $test = explode(":", $search);

  $medias = Media::filterMedias('');

  require('view/mediaListView.php');

}

/***************************
* ----- LOAD MEDIA PAGE ----
***************************/

function showMedia() {

  $id = isset($_GET['media']) ? $_GET['media'] : false;
  $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : false;

  if($id && is_numeric($id)) {
    
    try {
      $data = Media::getMediaById($id);

      ## WATCH LIST
      $watchlist = watchlist::getMovie($user_id, $id);
      if($watchlist):
        $is_favorite = true;
      else:
        $is_favorite = false;
      endif;
    }catch(Exception $e) {
      header('Location: index.php');
    }
    
    $md = new stdClass();
    foreach($data as $key => $value) {
      $md->$key = $value;
    }
    

    $media = new Media($md);

    $time_total = $media->getDuration();

    if($media->getType() == "Serie") {
      $data = serie::getSeriesByMediaId($media->getId());
      $serie = getEpisodesBySeason($data);
      $time_total = getTotalDuration($data);
    }

    $time_total = ($time_total / 60 < 60) ? strftime("%M min", $time_total) :strftime("%Hh%M", $time_total);


    require('view/mediaView.php');

  }

}