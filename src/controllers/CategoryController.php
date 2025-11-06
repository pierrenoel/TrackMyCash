<?php 

namespace Pierre\TrackMyCash\controllers;

use Pierre\TrackMyCash\core\Response;
use Pierre\TrackMyCash\core\Database;

class CategoryController 
{
    use Response;

    public function index()
    {
        $categories = Database::getInstance()->all("Categories",["name","user_id"]);

        echo $this->json([
            "categories" => $categories
        ]);
    }

    public function store($param)
    {
        // il faut trim & sanitizer
        $user_id = $param["user_id"];
        $name = $param["name"];

        Database::getInstance()->store("Categories",[
            "name" => $name,
            "user_id" => $user_id,
        ]);

        echo $this->json([
            "msg" => "Category added",
            "status" => 200, 
            "category" => [
                "name" => $name,
                "user_id" => $user_id
            ]
        ]);
    }
}