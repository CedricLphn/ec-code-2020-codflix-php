<?php

class serie extends CoreModel
{
    
    protected $id;
    protected $season;
    protected $episode;
    protected $title;
    protected $description;
    protected $duree;
    protected $media_url;
    
    public function __construct($media)
    {
        $serie = $this->getSerieByMediaId($media->getId());
        CoreModel::dd($serie);
        $this->hydrate($serie);
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
    public function setDuree($duree)
    {
        $this->duree = $duree;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function setMediaUrl($media_url)
    {
        $this->media_url = $media_url;
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


    public function getDescription()
    {
        return $this->description;
    }


    public function getDuree()
    {
        return $this->duree;
    }

    public function getMedia_url()
    {
        return $this->media_url;
    }

    
    public static function getSerieByMediaId($media_id) {
        $db = init_db();

        $req = $db->prepare("SELECT * FROM serie WHERE media_id = ?");
        $req->execute([$media_id]);

        return $req->fetchAll(PDO::FETCH_ASSOC);

    }


}
