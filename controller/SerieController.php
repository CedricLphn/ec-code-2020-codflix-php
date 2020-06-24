<?php

require_once( 'model/serie.php' );


function getEpisodesBySeason($media) {
    $serie = [];

    foreach($media as $element => $key) {
            $serie[$key["season"]][$element] = $key;
    }

    return $serie;

}

function getTotalDuration($data) {
    $total = 0;
    foreach($data as $key => $element) {
        $total += $element["duration"];
    }

    return $total;
}