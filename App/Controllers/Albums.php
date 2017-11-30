<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Album;
use \App\Models\Artist;
use \App\Models\Song;
Use \App\Query;

class Albums extends \Core\Controller
{

    public function showAction()
    {
        $album = new Album($this->route_params['id']);
        var_dump($album->getSongsId());
        $query = new Query;
        
        View::renderTemplate('Albums/index.html', [
            'albumTitle' => $album->getTitle(),
            'artist' => $album->getArtist()->getName(),
            'number' => $query->getNumberOfSongs($this->route_params['id']),
            'artwork' => $album->getArtworkPath(),
            'songs' => $album->getSongsId()
        ]);
    }

}