<?php
session_start();

require_once('../model/CoreModel.php');
require_once('../model/database.php');
require_once('controller/history.php');
require_once('controller/search.php');

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
    }
}