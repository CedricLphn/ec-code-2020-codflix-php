<?php

require('model/history.php');

function historyPage() {
    $user_id = $_SESSION['user_id'];

    $history = history::getHistoryByUserId($user_id);
    CoreModel::dd($history);

    require("view/historyView.php");

}

?>