<?php

namespace App\Models;

use PDO;
use \App\Constants;
use Core\View;
use Core\DB;

class Song extends \Core\Model
{

    public function getNumberOfSongs($id)
    {
    
       $this->db->query('SELECT id FROM songs WHERE album = :album');

       $this->db->bind(':album', $id);

       return  count($this->db->resultset());

    }

}