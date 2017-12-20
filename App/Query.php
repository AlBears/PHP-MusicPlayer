<?php

namespace App;

use \Core\DB;

class Query
{
    protected $db;
    
    public function __construct()
    {
        $this->db = new DB;
    }

    public function getAll($table)
    {
        $this->db->query("SELECT * FROM {$table}");

        $results = $this->db->resultset();

        return $results;
    }

    public function getNumberOfSongs($id)
    {
        $this->db->query('SELECT id FROM songs WHERE album = :album');

        $this->db->bind(':album', $id);

        return  count($this->db->resultset());
    }

    public function getRandomSongsIds()
    {
        $this->db->query('SELECT id FROM songs ORDER BY RAND() LIMIT 10');

        return json_encode($this->db->resultset());
    }

    public function getSongById($id)
    {
        $this->db->query('SELECT * FROM songs WHERE id = :id');

        $this->db->bind(':id', $id);

        return $this->db->single();

    }

    public function getArtistById($id)
    {
        $this->db->query('SELECT * FROM artists WHERE id = :id');

        $this->db->bind(':id', $id);

        return $this->db->single();

    }

    public function getAlbumById($id)
    {
        $this->db->query('SELECT * FROM albums WHERE id = :id');

        $this->db->bind(':id', $id);

        return $this->db->single();

    }

    public function incrementPlays($id)
    {
        $this->db->query('UPDATE songs SET plays = plays + 1 WHERE id = :id');

        $this->db->bind(':id', $id);

        $this->db->execute();

    }

    public function getAlbumSongs($id) 
    {

        $this->db->query('SELECT id FROM songs WHERE album = :album ORDER BY albumOrder ASC');

        $this->db->bind(':album', $id);

        return $this->db->resultset();
    }

    public function getArtistSongs($id) 
    {

        $this->db->query('SELECT id FROM songs WHERE artist = :artist ORDER BY plays ASC');

        $this->db->bind(':artist', $id);

        return $this->db->resultset();
    }

    public function getArtistAlbums($id)
    {
        $this->db->query('SELECT * FROM albums WHERE artist = :artist');

        $this->db->bind(':artist', $id);

        return $this->db->resultSet();
    }


}
