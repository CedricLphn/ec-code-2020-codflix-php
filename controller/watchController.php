<?php

function watchPage() {
    if(is_numeric($_GET['media'])) {
        $media_id   = htmlentities($_GET['media']);
        $episode    = isset($_GET['id']) && is_numeric($_GET['id']) ? htmlentities($_GET['id']) : false;

        $media_std  = new stdClass();

        $history_user               = new stdClass();
        $history_user->user_id      = $_SESSION['user_id'];
        $history_user->media_id     = $media_id;
        $history_user->start_date   = time();
        
        
        if($episode){
            // Série
            $media_std->id  = $episode;

            $data = serie::getSeriebyId($episode);
            $type = "serie";

            $history_user->serie_id = $data["id"];

            $history_data = history::getMediaHistory($history_user->user_id, $history_user->media_id, $history_user->serie_id);


        }else {
            // Film OR trailer serie
            $media_std->id = $media_id;
            $data = media::getMediaById($media_id);
            $type = "movie";
            $history_data = history::getMediaHistory($history_user->user_id, $history_user->media_id);
        }
        
        /**
         * HYDRATATION
         */
        foreach($data as $key => $value) {
            $media_std->$key = $value;
        }

        /**
         * Has the user seen this before ? 
         */
        if(!$history_data) {
            // No, let's go to create a row
            history::createHistory($history_user);
        }else {
            // Yes, we fill in the detail
            if($history_data["finish_date"])
                $history_user->finish_date = strtotime($history_data["finish_date"]);
                
            $history_user->watch_duration = $history_data["watch_duration"];
        }
                
        $history = new history($history_user);
        
        
        $media = (!$episode) ? new media($media_std) : new serie($media_std);
        
        require_once('view/watchView.php');

    }else {
        header('Location: index.php');
    }
}
