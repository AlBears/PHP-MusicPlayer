<?php

namespace Core;


use PDO;
use App\Config;

abstract class Model
{

    
    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
	            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . 
	                   Config::DB_NAME . ';charset=utf8';
	            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);
                //Exception when error occurs
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            
            } 

        return $db;
    }

    public static function findByField($data = array()) 
    {
        $field = array_keys($data)[0];

        $table = static::getTable();
        
        $sql = "SELECT * FROM {$table} WHERE {$field} = :data";

        $db = static::getDb();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':data', $data[$field], PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();

    }

    public static function itemExists($data = array()) 
    {
        if (static::findByField($data)){
            return true;
        }
        return false;
    }

    public static function getTable()
    {
        $className = get_called_class();

        $table = strtolower(substr($className, strrpos($className, '\\') + 1))."s";
        
        return $table;
    }

}
