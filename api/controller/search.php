<?php

require('../model/media.php');

$query = (isset($_GET['query'])) ? htmlentities($_GET['query']) : false;

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;

try {
    if(!$user_id) {
        echo "Unauthorized access";
        throw new Exception('HTTP/1.0 401 Unauthorized');
    }
    
    if(!$query) {
        echo "Bad request";      
        throw new Exception("HTTP/1.0 400 Bad request");
    }
}catch(Exception $e) {
    header($e->getMessage());
}

function searchApi() {
    $search = isset($_GET['query']) ? htmlentities($_GET['query']) : false;
    if($search) {
        try {
            $medias = media::filterMedias($search);
    
            if(count($medias) == 0) {
                throw new Exception("Not found");
            }
        }catch(Exception $e) {
            header('HTTP/1.0 400 Not found');
            echo $e->getMessage();
        }

        require('../view/api/searchView.php');

    }else {
        header('HTTP/1.0 400 Bad request');
        echo "Bad request";
    }
}


?>