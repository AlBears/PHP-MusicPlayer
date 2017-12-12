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
        $query = new Query;

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $url = 'Albums/mainContentAlbums.html';
        } else {
            $url = '/Albums/index.html';
        }
        
        View::renderTemplate($url, [
            'albumTitle' => $album->getTitle(),
            'artist' => $album->getArtist()->getName(),
            'number' => $query->getNumberOfSongs($this->route_params['id']),
            'artwork' => $album->getArtworkPath(),
            'songs' => $album->getSongsId(),
            'ids' => $album->getAlbumSongsIds()
        ]);
    }

}