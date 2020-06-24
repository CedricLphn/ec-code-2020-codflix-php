<?php


class history extends CoreModel
{

    protected $id;
    protected $media_id;
    protected $serie_id;
    protected $start_date;
    protected $finish_date;
    protected $watch_duration;


    public function __construct($media)
    {
        if (!$media->media_id && $media->serie_id)
            throw new Exception("media_id is required");


        $this->hydrate($media);
    }


    /***************************
     * -------- SETTERS ---------
     ***************************/

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setMediaId($media_id)
    {
        $this->media_id = $media_id;
    }

    public function setSerieId($serie_id)
    {
        $this->serie_id = $serie_id;
    }

    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    public function setFinishDate($finish_date)
    {
        $this->finish_date = $finish_date;
    }

    public function setWatchDuration($watch_duration)
    {
        $this->watch_duration = $watch_duration;
    }
    /***************************
     * -------- GETTERS ---------
     ***************************/

    public function getId()
    {
        return $this->getId;
    }

    public function getMediaId()
    {
        return $this->media_id;
    }

    public function getSerieId()
    {
        return $this->serie_id;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function getFinishDate()
    {
        return $this->finish_date;
    }

    public function getWatchDuration()
    {
        return $this->watch_duration;
    }


    public static function getHistoryByUserId($user_id)
    {
        $db = init_db();

        $req = $db->prepare("SELECT 
        history.id,
        history.start_date, 
        history.finish_date,
        history.watch_duration,
        media.title AS media_title, 
        serie.title AS serie_title, serie.season, serie.episode 
        FROM history
        INNER JOIN media
        ON history.media_id = media.id
        LEFT JOIN serie
        ON history.serie_id = serie.id
        WHERE user_id = ?
        ORDER BY history.finish_date DESC, history.start_date DESC");
        $req->execute(array($user_id));


        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteUserHistory($user_id) {
        $db = init_db();

        try {
            $req = $db->prepare("DELETE FROM history WHERE user_id = ?");
            $req->execute(array($user_id));
        }catch(Exception $e) {
            return $e->getMessage();
        }


        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

}
