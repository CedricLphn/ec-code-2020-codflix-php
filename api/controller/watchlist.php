<?php

require('../model/watchlist.php');

function watchlistPage() {
    $query = (isset($_GET['query'])) ? htmlentities($_GET['query']) : false;

    try {
        if(!isset($_GET['action']) || !isset($_SESSION["user_id"])):
            header('HTTP/1.0 403 Forbidden');
            throw new Exception("Forbiden access");
        endif;

        $action = htmlentities($_GET['query']);
    
        switch($action):
            case 'toggle':
                toggle();
            break;
            case 'check':
                check();
            break;
            default:
                header('HTTP/1.0 400 Bad request');
                echo "Bad request";
        endswitch;
    }catch(Exception $e) {
        echo $e->getMessage();
    }
}

function check() {
    try {
        $json = array();

        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) :
            throw new Exception("Bad Request");
        endif;

        $user_id = $_SESSION["user_id"];
        $media_id = $_GET['id'];

        $movie = watchlist::getMovie($user_id, $media_id);

        if($movie):
            $json["present"] = true;
        else:
            $json["present"] = false;
            
        endif;


        header('Content-Type: application/json');

        echo json_encode($json);

    }catch(Exception $e) {
        header('HTTP/1.0 400 Bad request');
        echo $e->getMessage();

    }
        
}

function toggle() {
    try {
        $json = array();

        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) :
            throw new Exception("Bad Request");
        endif;

        $user_id = $_SESSION["user_id"];
        $media_id = $_GET['id'];

        $movie = watchlist::getMovie($user_id, $media_id);

        if($movie):
            watchlist::deleteMovie($user_id, $media_id);
            $json["etat"] = "delete";
        else:
            watchlist::addMovie($user_id, $media_id);
            $json["etat"] = "add";
        endif;


        header('Content-Type: application/json');

        echo json_encode($json);

    }catch(Exception $e) {
        header('HTTP/1.0 400 Bad request');
        echo $e->getMessage();

    }
        
}


?>