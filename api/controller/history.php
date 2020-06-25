<?php

require('../model/history.php');

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

function historyApi() {
    $query = isset($_GET['query']) ? htmlentities($_GET['query']) : false;
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
    }else {
        header('HTTP/1.0 400 Bad request');
        echo "Bad request";
    }
}

function deleteAll() {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;

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

    try {
        history::deleteHistory($id);
    }catch(Exception $e) {
        header('HTTP/1.0 400 Bad request');
        $array['status'] = "failed";
        $array['message'] = $e->getMessage();
    }

    echo json_encode($array);

}

?>