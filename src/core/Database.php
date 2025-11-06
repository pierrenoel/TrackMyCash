<?php

namespace Pierre\TrackMyCash\core;

class Database 
{
    private static $instance = null;
    private $PDOInstance = null;

    public function __construct(){
        try{
            $this->PDOInstance = new \PDO('sqlite:database.sqlite');
            $this->PDOInstance->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $this->PDOInstance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); 
        } catch(Exception $e) {
            echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
            die();
        }
    }

    public static function getInstance(){
        if(\is_null(self::$instance)) self::$instance = new Database();
        return self::$instance;
    }

    public function all(string $table, array $fields)
    {
        $fieldsImplode = implode(",",$fields);

        $stmt = $this->PDOInstance->prepare("SELECT {$fieldsImplode} FROM {$table}");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function store(string $table, array $inputs)
    {
        $fields = implode(',', array_map(fn($k) => ':' . $k, array_keys($inputs)));
        $values = implode(',',array_keys($inputs));

        $stmt = $this->PDOInstance->prepare("INSERT INTO {$table} ({$values}) VALUES ({$fields})");
        return $stmt->execute($inputs);
    }

}