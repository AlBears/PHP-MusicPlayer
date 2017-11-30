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

}
