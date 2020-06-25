<?php

require('../model/history.php');

function requireUser() {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;

    if(!$user_id) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Unauthorized access";
        throw new Exception("Bad request");
    }
}


function historyApi() {
    $query = (isset($_GET['query'])) ? htmlentities($_GET['query']) : false;
    
    requireUser();
    if(!$query) {
        header('HTTP/1.0 400 Bad request');
        echo "Bad request";
        throw new Exception("Bad request");
    }

    if($query == 'deleteAll') {
        deleteAll();
    }elseif($query == 'delete') {
        
        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : false;
        if(!$id):
            header('HTTP/1.0 400 Bad request');
            echo "Bad request";
        else:
            delete($id);
        endif;
    }elseif($query == "update_timestamp"){

        if($_POST) : updateTimestamp($_POST);
        else : 
            header('HTTP/1.0 400 Bad request');
            echo "Bad request";
        endif;

    }else{
        header('HTTP/1.0 400 Bad request');
        echo "Bad request";
    }
}

function deleteAll() {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;
    
    requireUser();

    $array = array("status" => "");

    try {
        history::deleteUserHistory($user_id);
        $array['status'] = "success";
        
    }catch(Exception $e) {
        header('HTTP/1.0 400 Bad request');
        $array['status'] = "failed";
        $array['message'] = $e->getMessage();
    }

    echo json_encode($array);
}

function delete($id) {
    $array = array("status" => "");

    requireUser();


    try {
        history::deleteHistory($id);
    }catch(Exception $e) {
        header('HTTP/1.0 400 Bad request');
        $array['status'] = "failed";
        $array['message'] = $e->getMessage();
    }

    echo json_encode($array);

}

function updateTimestamp($post) {
    requireUser();

    $user_id = htmlentities($_SESSION["user_id"]);

    $query = (isset($_GET['query'])) ? htmlentities($_GET['query']) : false;

    if(!$query) {
        header('HTTP/1.0 400 Bad request');
        echo "Bad request";
        throw new Exception("Bad request");
    }
    
    $watcher = new stdClass();

    $watcher->user_id        = $user_id;
    $watcher->media_id       = htmlentities($post["mediaId"]);
    $watcher->serie_id       = $post["serieId"] == "false" ? false : $post["serieId"];
    $watcher->watch_duration = htmlentities($post["currentTime"]);
    $watcher->action         = htmlentities($post["action"]);


    /**
     * SET CURRENT TIME IN DB
     */
    if($watcher->action == "setTime") {
        try {
            history::updateCurrentTime($watcher);
        }catch(Exception $e) {
            echo $e->getMessage();
        }
    }


}