<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Album;
use \App\Models\Artist;
use \App\Models\Song;

class Albums extends \Core\Controller
{

    public function showAction()
    {
        $albumInstance = new Album;
        $album = $albumInstance->findByField(['id' => $this->route_params['id']]);
        $artistInstance = new Artist;
        $artist = $artistInstance->findByField(['id' => $album->artist ]);
        $songInstance = new Song;
        $number = $songInstance->getNumberOfSongs($this->route_params['id']);
        
        View::renderTemplate('Albums/index.html', [
            'album' => $album,
            'artist' => $artist,
            'number' => $number
        ]);
    }

}