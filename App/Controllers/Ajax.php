<?php

namespace App\Controllers;
use \Core\View;
Use \App\Query;

class Ajax extends \Core\Controller
{
    protected $query;

    public function __construct()
    {
        $this->query = new Query;
    }

    public function findSongAction()
    {
        $song = $this->query->getSongById($_POST['songId']);
        echo json_encode($song);
    }

    public function findArtistAction()
    {
        $artist = $this->query->getArtistById($_POST['artistId']);
        echo json_encode($artist);
    }

    public function findAlbumAction()
    {
        $album = $this->query->getAlbumById($_POST['albumId']);
        echo json_encode($album);
    }

    public function updateCountAction()
    {
        $this->query->incrementPlays($_POST['songId']);
    }


}