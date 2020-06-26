<?php

require('../model/history.php');

function requireUser() {
    $user_id = isset( $_SESSION['user_id']) ? $_SESSION['user_id'] : false;

    if( !$user_id ) {
        header( 'HTTP/1.0 401 Unauthorized' );
        echo "Unauthorized access";
        throw new Exception( "Bad request" );
    }
}

/**
 * ROUTE HISTORY QUERY API
 */

function historyApi() {
    $query = ( isset( $_GET['query'] ) ) ? htmlentities( $_GET['query'] ) : false;
    
    
    requireUser();

    try {
        if( !$query )
            throw new Exception( "Bad request" );

        switch( $query ) :

            case 'deleteAll':
                deleteAll();
            break;

            case 'delete':
                $id = ( isset( $_GET['id'] ) && is_numeric( $_GET['id']) ) ? $_GET['id'] : false;
                if(!$id) throw new Exception( "Bad request" );
                delete( $id );
            break;

            case 'update_timestamp':
                if( !$_POST ) throw new Exception("Bad Request");
                updateTimestamp($_POST);
            break;

            default:
                throw new Exception("Bad request");

        endswitch;

    }catch( Exception $e ) {

        header( 'HTTP/1.0 400 Bad request' );
        echo $e->getMessage();

    }
}

/**
 * DELETE ALL USER HISTORY
 */

function deleteAll() {
    requireUser();

    $user_id = isset( $_SESSION['user_id']) ? $_SESSION['user_id'] : false;

    $array   = array( "status" => "" );

    try {
        history::deleteUserHistory( $user_id );
        $array['status']    = "success";
        
    }catch(Exception $e) {
        header('HTTP/1.0 400 Bad request');
        $array['status']    = "failed";
        $array['message']   = $e->getMessage();
    }

    echo json_encode($array);
}

/**
 * DELETE SPECIFIC ITEM IN HISTORY TABLE
 */

function delete( $id ) {
    requireUser();

    $array = array("status" => "");

    try {

        history::deleteHistory( $id );
        $array["status"] = "done";

    }catch(Exception $e) {

        header( 'HTTP/1.0 400 Bad request' );
        $array[ 'status' ] = "failed";
        $array[ 'message' ] = $e->getMessage();
    
    }

    echo json_encode($array);

}

/**
 * UPDATE TIMESTAMP
 */

function updateTimestamp($post) {
    
    requireUser();

    $user_id = htmlentities($_SESSION["user_id"]);

    $query = ( isset( $_GET['query'] ) ) ? htmlentities( $_GET['query'] ) : false;

    try {
        if( !$query )
            throw new Exception( "Bad request" );
        
        $watcher = new stdClass();
    
        $watcher->user_id        = $user_id;
        $watcher->media_id       = htmlentities($post["mediaId"]);
        $watcher->serie_id       = $post["serieId"] == "false" ? false : $post["serieId"];
        $watcher->watch_duration = htmlentities($post["currentTime"]);
        $watcher->action         = htmlentities($post["action"]);
    }catch(Exception $e) {
        header( 'HTTP/1.0 400 Bad request' );
        echo $e->getMessage();
    }


    /**
     * SET CURRENT TIME IN DB
     */
    if( $watcher->action == "setTime" ) {

        try {
            history::updateCurrentTime($watcher);
        }catch(Exception $e) {
            echo $e->getMessage();
        }

    }else if( $watcher->action == "done" ) {
        /**
         * SET FINISH DATE 
         */ 
        $date = new DateTime();

        $watcher->finish_date = $date->format("Y-m-d H:i:s");

        try {
            history::updateCurrentTime($watcher);
        }catch(Exception $e) {
            echo $e->getMessage();
        }

    }

}