<?php

namespace App\Models;

use PDO;
use \App\Constants;
use Core\View;

class Album extends \Core\Model
{
    public $artist;

    public static function getAll()
    {
       $db = static::getDB();

       $stmt = $db->query('SELECT * FROM albums');

       $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

       return $results;
    }

}