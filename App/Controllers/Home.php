<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Album;
use \App\Query;

class Home extends \Core\Controller
{
    public function indexAction()
    {
        $query = new Query();
       
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $url = '/Home/mainContent.html';
        } else {
            $url = '/Home/index.html';
        }
        View::renderTemplate($url, [
                'albums' => $query->getAll("albums"),
                'ids' => $query->getSongsIds()
            ]);
    }
}
