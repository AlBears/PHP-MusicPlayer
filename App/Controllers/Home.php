<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Album;
use \App\Query;

class Home extends \Core\Controller
{
	
    protected function before()
    {
        //echo "(before) ";    
    }

    protected function after()
    {
        //echo " (after)";
    }

    public function indexAction()
    {
        $query = new Query();
        $albums = $query->getAll("albums");
        $ids = $query->getSongsIds();
        View::renderTemplate('Home/index.html', [
            'albums' => $albums,
            'ids' => $ids
        ]);
    }
}