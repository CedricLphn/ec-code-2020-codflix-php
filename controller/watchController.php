<?php

function watchPage() {
    if(is_numeric($_GET['media'])) {
        $media_id = htmlentities($_GET['media']);
        $episode = isset($_GET['id']) && is_numeric($_GET['id']) ? htmlentities($_GET['id']) : false;

        $media_std = new stdClass();
        
        if($episode){
            // Série
            $media_std->id = $episode;
            $data = serie::getSeriebyId($episode);
            $type = "serie";
        }else {
            // Film OU bande annonce de série
            $media_std->id = $media_id;
            $data = media::getMediaById($media_id);
            $type = "movie";
        }
        
        foreach($data as $key => $value) {
            $media_std->$key = $value;
        }
        
        $media = (!$episode) ? new media($media_std) : new serie($media_std);
        CoreModel::dd($media);
        require_once('view/watchView.php');

    }else {
        header('Location: index.php');
    }
}

?>