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
    }
}

function deleteAll() {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;

    $array = array("status" => "");

    try {
        history::deleteUserHistory($user_id);
        $array['status'] = "success";
        
    }catch(Exception $e) {
        $array['status'] = "failed";
        $array['message'] = $e->getMessage();
    }

    echo json_encode($array);
}

?>