<?php

require('model/history.php');

function historyPage() {
    $user_id = $_SESSION['user_id'];

    $history = history::getMediasHistoryByUserId($user_id);    

    require("view/historyView.php");

}

?>