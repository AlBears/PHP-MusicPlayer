<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Album;
use \App\Models\Artist;
use \App\Models\Song;
Use \App\Query;

class Search extends \Core\Controller
{

    public function indexAction()
    {
        $query = new Query;

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $url = 'Search/mainContentSearch.html';
        } else {
            $url = '/Search/index.html';
        }
        
        View::renderTemplate($url, [
            'ids' => $query->getRandomSongsIds()
        ]);
    }

    public function executeAction()
    {
        $query = new Query;
        $data = $query->searchArtistsId($_POST['search']);
        $array = array();
        foreach($data as $x => $obj) {
            $artist = new Artist($obj->id);
            $obj->name = $artist->getName();
            array_push($array, $obj);
        }
        View::renderTemplate('Search/artistsSearch.html', [
            'artists' => $array
        ]);
       
    }

}