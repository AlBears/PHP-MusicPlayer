<?php

namespace App\Models;

use PDO;
use \App\Constants;
use Core\View;
use Core\DB;
use \App\Models\Artist;

class Album extends \Core\Model
{
    private $id;
    private $title;
    private $artistId;
    private $genre;
    private $artworkPath;

    public function __construct($id)
    {
        parent::__construct();

        $this->id = $id;

        $this->db->query('SELECT * FROM albums WHERE id = :id');
        $this->db->bind(':id', $this->id);
        $album = $this->db->single();

        $this->title = $album->title;
        $this->artistId = $album->artist;
        $this->genre = $album->genre;
        $this->artworkPath = $album->artworkPath;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getArtworkPath() 
    {
        return $this->artworkPath;
    }

    public function getArtist() 
    { 
        return new Artist($this->artistId);
    }
}
