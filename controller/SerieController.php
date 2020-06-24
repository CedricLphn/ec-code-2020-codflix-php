<?php

require_once( 'model/serie.php' );


function getSerieBySeason($media) {
    $md = serie::getSeriesByMediaId($media->getId());
    $serie = [];

    foreach($md as $element => $key) {
            $serie[$key["season"]][$element] = $key;
    }

    return $serie;

}