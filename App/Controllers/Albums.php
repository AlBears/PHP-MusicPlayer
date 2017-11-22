<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Album;

class Albums extends \Core\Controller
{

    public function showAction()
    {
        $album = Album::findByField('albums', ['id' => $this->route_params['id']]);
        View::renderTemplate('Albums/index.html', [
            'album' => $album
        ]);
    }

}