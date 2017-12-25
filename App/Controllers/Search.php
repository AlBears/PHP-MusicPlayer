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
        if (isset($_POST['search'])) {
            $searchSongs = $query->searchSongsId($_POST['search']);
            $searchArtists = $query->searchArtistsId($_POST['search']);

            $artists = array();
            foreach ($searchArtists as $x => $obj) {
                $artist = new Artist($obj->id);
                $obj->name = $artist->getName();
                array_push($artists, $obj);
            }
            $songs = array();
            foreach ($searchSongs as $x => $obj) {
                $song = new Song($obj->id);
                $obj->title = $song->getTitle();
                $obj->artist = $song->getArtist()->getName();
                $obj->duration = $song->getDuration();
                $obj->number = $x + 1;
                array_push($songs, $obj);
            }
            View::renderTemplate('Search/artistsSearch.html', [
            'artists' => $artists,
            'songs' => $songs,
            'idsAlbum' => json_encode($query->searchSongsId($_POST['search']))
        ]);
        }
        
       
    }

}