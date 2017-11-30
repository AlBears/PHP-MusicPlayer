<?php

namespace App\Models;

use PDO;
use Core\View;

class Artist extends \Core\Model
{
    private $id;
    private $name;
    
    public function __construct($id)
    {
        parent::__construct();
    
        $this->id = $id;
    
        $this->db->query('SELECT * FROM artists WHERE id = :id');
        $this->db->bind(':id', $this->id);
        $artist = $this->db->single();
    
        $this->name = $artist->name;
    }

    public function getName()
    {
        return $this->name;
    }
}
