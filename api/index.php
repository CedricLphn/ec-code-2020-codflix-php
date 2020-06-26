<?php
session_start();

require_once('../model/CoreModel.php');
require_once('../model/database.php');
require_once('controller/history.php');
require_once('controller/search.php');
require_once('controller/watchlist.php');

/**
 * API ROUTES
 */

if(!isset($_GET['action'])) {
    header('HTTP/1.0 403 Forbidden');
    echo "Forbiden access";
}else {
    switch(htmlentities($_GET['action'])) {
        case 'history':
            historyApi();
        break;
        case 'search':
            searchApi();
        break;
        case 'watchlist':
            watchlistPage();
        break;
        default:
            header('HTTP/1.0 400 Bad request');
            echo "Bad request";
        break;
    }
}

?>