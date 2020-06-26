<?php

/**
 * SEARCH API
 * THIS API DOES NOT REQUIRE ROUTING
 */

require('../model/media.php');

$query = ( isset($_GET['query'] ) ) ? htmlentities( $_GET['query'] ) : '';

$user_id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

/**
 * NECESSARY TO LOG IN
 */

try {
    if(!$user_id) {
        echo "Unauthorized access";
        throw new Exception('HTTP/1.0 401 Unauthorized');
    }
}catch(Exception $e) {
    header($e->getMessage());
}

/**
 * MAIN SEARCH API
 *
 * @return void
 */
function searchApi() {

    $search = isset( $_GET['query'] ) ? $_GET['query'] : '';

    $search_by_year = false;

    # Check if the user searches in a date
    if(preg_match("/^(?:annee:.+)*$/", $search) && $search != '') {
        $search_by_year = true;
        
        # Explode the string
        $filter     = explode(':' , $search);
        $operator   = "=";

        #Check character to avoid a sql injection
        $pattern    = "/^(\=|>|<|>=|<=)$/";
        $year       = 0;

        /**
         * REGEX
         */
        if( preg_match ( $pattern, substr ( $filter[1], 0, 2 ) ) ) { # For example: annee:<=2010
            $operator   = substr( $filter[1], 0, 2 ); 
            $year       = substr( $filter[1], 2, strlen ( $filter[1] ) );

        }else if( preg_match ( $pattern, substr( $filter[1], 0, 1 ) ) ) { # For : annee:>2017 { 
            $operator   = substr ( $filter[1], 0, 1 ); 
            $year       = substr ( $filter[1], 1, strlen( $filter[1] ) );
        }else { #For: annee:2010
            $year       = $filter[1];
        }

    }

    ## Media filter
    try {

        if($search_by_year):
            $medias = media::filterMediasByYear ( htmlentities($year), $operator );
        else:
            $medias = media::filterMedias( htmlentities ( $search ) );
        endif;

        if( count( $medias ) == 0) {
            throw new Exception("Not found");
        }
    }catch(Exception $e) {
        header ( 'HTTP/1.0 400 Not found ' );
        echo $e->getMessage();
    }

    require('../view/api/searchView.php');

}


?>