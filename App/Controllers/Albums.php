<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Album;
use \App\Models\Artist;

class Albums extends \Core\Controller
{

    public function showAction()
    {
        $album = Album::findByField(Album::getTable(), ['id' => $this->route_params['id']]);
        $artist = Artist::findByField(Artist::getTable(), ['id' => $album->artist ]);
        View::renderTemplate('Albums/index.html', [
            'album' => $album,
            'artist' => $artist
        ]);
    }

}