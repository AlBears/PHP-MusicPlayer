<?php

namespace App\Models;

use PDO;
use \App\Constants;
use Core\View;
use Core\DB;

class Album extends \Core\Model
{
    public $artist;

    public function getAll()
    {
    
       $this->db->query('SELECT * FROM albums');

       $results = $this->db->resultset();

       return $results;
    }

}