<?php

namespace Pierre\TrackMyCash\core;

class Database 
{
    use Response;

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

    private function values(array $inputs)
    {
        $values = implode(',',array_keys($inputs));
        $fields = implode(',', array_map(fn($k) => ':' . $k, array_keys($inputs)));

        return [$values,$fields];
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

    public function find(string $table, array $fields)
    {
        $conditions = implode(' AND ', array_map(fn($k) => "$k = :$k", array_keys($fields)));

        $sql = "SELECT * FROM {$table} WHERE {$conditions}";
        $stmt = $this->PDOInstance->prepare($sql);

        $stmt->execute($fields);

        // récupérer toutes les lignes
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $results; // tableau vide [] si rien trouvé
    }


    public function store(string $table, array $inputs)
    {
        $values = $this->values($inputs);

        $sql = "INSERT INTO {$table} ({$values[0]}) VALUES ({$values[1]})";

        $stmt = $this->PDOInstance->prepare($sql);

        return $stmt->execute($inputs);
    }

    public function delete(string $table, array $inputs)
    {
        $data = $this->find("Categories",$inputs);

        if(!$data) echo $this->error_404_Resource_Not_Found();
        
        $conditions = implode(' AND ', array_map(fn($k) => "$k = :$k", array_keys($inputs)));
        $sql = "DELETE FROM {$table} WHERE {$conditions}";
        $stmt = $this->PDOInstance->prepare($sql);

        return $stmt->execute($inputs);
       

    }

}