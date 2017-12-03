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

    public function getSongsIds()
    {
        $this->db->query('SELECT id FROM songs ORDER BY RAND() LIMIT 10');

        $result = $this->db->resultset();

        return json_encode($result);
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
}
