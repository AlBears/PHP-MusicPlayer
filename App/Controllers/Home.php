<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Album;

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
        $album = new Album();
        $albums = $album->getAll();
        View::renderTemplate('Home/index.html', [
            'albums' => $albums
        ]);
    }
}