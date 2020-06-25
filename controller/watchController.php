<?php

function watchPage() {
    if(is_numeric($_GET['media'])) {
        $media_id = htmlentities($_GET['media']);
        $episode = isset($_GET['id']) && is_numeric($_GET['id']) ? htmlentities($_GET['id']) : false;

        $media_std = new stdClass();

        $history_std = new stdClass();
        $history_std->user_id = $_SESSION['user_id'];
        $history_std->media_id = $media_id;
        $history_std->start_date = time();
        
        
        if($episode){
            // Série
            $media_std->id = $episode;
            $data = serie::getSeriebyId($episode);
            $type = "serie";
            $history_std->serie_id = $data["id"];

        }else {
            // Film OU bande annonce de série
            $media_std->id = $media_id;
            $data = media::getMediaById($media_id);
            $type = "movie";
        }
        
        foreach($data as $key => $value) {
            $media_std->$key = $value;
        }
        
        
        $history = new history($history_std);
        
        if(!history::getMediaHistory($history->getUserId(), $history->getMediaId(), $history->getSerieId())) {
            $history->createHistory();
        }
        
        $media = (!$episode) ? new media($media_std) : new serie($media_std);
        
        require_once('view/watchView.php');

    }else {
        header('Location: index.php');
    }
}

?>