<?php

require('../model/media.php');

$query = (isset($_GET['query'])) ? htmlentities($_GET['query']) : false;

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;

if(!$user_id) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Unauthorized access";
    die();
}

if(!$query) {
    header('HTTP/1.0 400 Bad request');
    echo "Bad request";
    die();
}

function searchApi() {
    $search = isset($_GET['query']) ? htmlentities($_GET['query']) : false;
    if($search) {
        $medias = media::filterMedias($search);

        if(count($medias) == 0) {
            header('HTTP/1.0 400 Not found');
            echo "Not found";
            die(); 
        }

        require('../view/api/searchView.php');

    }else {
        header('HTTP/1.0 400 Bad request');
        echo "Bad request";
    }
}


?>