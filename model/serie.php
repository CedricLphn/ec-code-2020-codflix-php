<?php

class serie extends CoreModel
{
    
    protected $id;
    protected $season;
    protected $episode;
    protected $title;
    protected $summary;
    protected $duration;
    protected $media_url;
    protected $media_title;
    protected $type;
    
    public function __construct($media)
    {
        $this->hydrate($media);
    }
    
    /**
     * SETTER
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setSeason($season)
    {
        $this->season = $season;
    }
    
    public function setEpisode($episode)
    {
        $this->episode = $episode;
    }
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
    
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }
    
    public function setMediaUrl($media_url)
    {
        $this->media_url = $media_url;
    }

    public function setMediaTitle($media_title)
    {
        $this->media_title = $media_title;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * GETTER
     */

    public function getId()
    {
        return $this->id;
    }


    public function getSeason()
    {
        return $this->season;
    }


    public function getEpisode()
    {
        return $this->episode;
    }


    public function getTitle()
    {
        return $this->title;
    }

    public function getMediaTitle() {
        return $this->media_title;
    }


    public function getSummary()
    {
        return $this->summary;
    }


    public function getDuration()
    {
        return $this->duration;
    }

    public function getMediaUrl()
    {
        return $this->media_url;
    }

    public function getType()
    {
        return $this->type;
    }

    
    public static function getSeriesByMediaId($media_id) {

        if(!is_numeric($media_id))
            throw new Exception("id must be numeric");

        $db = init_db();

        $req = $db->prepare("SELECT serie.*
        FROM serie
        WHERE media_id = ?");
        $req->execute([$media_id]);

        if($req->rowCount() <= 0)
            throw new Exception("Serie not found");

        return $req->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function getSeriebyId($id) {
        if(!is_numeric($id))
            throw new Exception("id must be numeric");

        $db = init_db();

        $req = $db->prepare("SELECT serie.*, media.title AS media_title, media.type FROM serie
        INNER JOIN media
        ON serie.media_id = media.id
        WHERE serie.id = ?");
        $req->execute([$id]);

        if($req->rowCount() <= 0)
            throw new Exception("Serie not found");

        return $req->fetch(PDO::FETCH_ASSOC);

    }


}
