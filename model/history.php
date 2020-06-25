<?php


class history extends CoreModel
{

    protected $id;
    protected $user_id;
    protected $media_id;
    protected $serie_id;
    protected $start_date;
    protected $finish_date;
    protected $watch_duration;


    public function __construct($media)
    {

        if (!isset($media->media_id))
            throw new Exception("media_id is required");

        if(!isset($media->user_id))
            throw new Exception("user_id is required");

        if(!isset($media->start_date))
            throw new Exception("start_date is required");


        $this->hydrate($media);

    }


    /***************************
     * -------- SETTERS ---------
     ***************************/

    public function setId($id)
    {
        if(!is_numeric($id))
            throw new Exception("id must be numeric");

        if(!user::getUserById($id))
            throw new Exception("user not found");

        $this->id = $id;
    }

    public function setMediaId($media_id)
    {
        if(!is_numeric($media_id))
            throw new Exception("media_id must be numeric");

        if(!media::getMediaById($media_id))
            throw new Exception("Media not found");

        $this->media_id = $media_id;
    }

    public function setSerieId($serie_id)
    {
        if(!is_numeric($serie_id))
            throw new Exception("serie_id must be numeric");

        if(!serie::getSeriebyId($serie_id))
            throw new Exception("Serie not found");

        $this->serie_id = $serie_id;
    }

    public function setStartDate($start_date)
    {
        if(!is_numeric($start_date))
            throw new Exception("start_date must be numeric");

        $this->start_date = $start_date;
    }

    public function setFinishDate($finish_date)
    {
        if(!is_numeric($finish_date))
            throw new Exception("finish_date must be numeric");

        $this->finish_date = $finish_date;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setWatchDuration($watch_duration)
    {
        if(!is_numeric($watch_duration))
            throw new Exception("watch_duration must be numeric");

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

    public function getUserId() {
        return $this->user_id;
    }

    private function toDateString($timestamp) {
        if(!is_numeric($timestamp))
            throw new Exception("Timestamp must be numeric");

        $date = new DateTime();
        $date->setTimestamp($timestamp);

        return $date->format("Y-m-d H:i:s");

    }

    public function createHistory() {


        $start_date = $this->toDateString($this->getStartDate());
        # $finish_date = (!is_null($this->getFinishDate())) ? $this->toDateString($this->getFinishDate) : NULL;

        $db = init_db();

        $req = $db->prepare("INSERT INTO history(user_id, media_id, serie_id, start_date)
        VALUES(:user_id, :media_id, :serie_id, :start_date)");

        $req->execute(array(
            "user_id" => $this->getUserId(),
            "media_id" => $this->getMediaId(),
            "serie_id" => $this->getSerieId(),
            "start_date" => $start_date,
        ));

    }


    public static function getMediasHistoryByUserId($user_id)
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

    public static function getMediaHistory($user_id, $media_id, $serie_id = NULL) {
        $db = init_db();

        $query = "SELECT * FROM history WHERE user_id = ? AND media_id = ? AND serie_id" . (is_null($serie_id) ? " IS NULL" : " = ?");
        $statement = array($user_id, $media_id);
        
        if(!is_null($serie_id))
            $statement[count($statement)] = $serie_id;

        CoreModel::dd($statement);
        $req = $db->prepare($query);
        $req->execute($statement);

        CoreModel::dd($req);

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


        return true;
    }

    public static function deleteHistory($history_id) {
        $db = init_db();

        try {
            $req = $db->prepare("DELETE FROM history WHERE id = ?");
            $req->execute(array($history_id));
        }catch(Exception $e) {
            return $e->getMessage();
        }


        return true;
    }

}
