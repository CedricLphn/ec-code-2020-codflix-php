<?php

class watchlist {

    public static function getMovie($user_id, $media_id) {
        $db = init_db();

        $req = $db->prepare("SELECT * FROM watchlist WHERE user_id = :user_id AND media_id = :media_id");
        $req->execute(array(
            "user_id"   =>  $user_id,
            "media_id"  =>  $media_id
        ));

        if($req->rowCount() < 1)
            return false;

        return $req->fetch(PDO::FETCH_ASSOC);

    }

    public static function addMovie($user_id, $media_id) {
        $db = init_db();

        $req = $db->prepare("INSERT INTO watchlist(user_id, media_id) VALUES(:user_id, :media_id)");
        $req->execute(array(
            "user_id"   =>  $user_id,
            "media_id"  =>  $media_id
        ));

        $db = null;

    }

    public static function deleteMovie($user_id, $media_id) {
        $db = init_db();

        $req = $db->prepare("DELETE FROM watchlist WHERE user_id = :user_id AND media_id = :media_id");
        $req->execute(array(
            "user_id"   =>  $user_id,
            "media_id"  =>  $media_id
        ));

        $req->closeCursor();

        $db = null;

    }
}

?>