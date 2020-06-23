<?php

function watchPage() {
    if(is_numeric($_GET['media'])) {
        $media = htmlentities($_GET['media']);
        $episode = isset($_GET['id']) && is_numeric($_GET['id']) ? htmlentities($_GET['id']) : false;
        if($episode){
            // Série
        }else {
            // Film
        }

        require_once('view/watchView.php');

    }else {
        header('Location: index.php');
    }
}

?>