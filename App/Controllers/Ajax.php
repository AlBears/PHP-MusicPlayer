<?php

namespace App\Controllers;
use \Core\View;
Use \App\Query;

class Ajax extends \Core\Controller
{
    public function findSongAction()
    {
        $query = new Query;
        $song = $query->getSongById($_POST['songId']);
        echo json_encode($song);
    }

    public function findArtistAction()
    {
        $query = new Query;
        $artist = $query->getArtistById($_POST['artistId']);
        echo json_encode($artist);
    }

    public function findAlbumAction()
    {
        $query = new Query;
        $album = $query->getAlbumById($_POST['albumId']);
        echo json_encode($album);
    }

}