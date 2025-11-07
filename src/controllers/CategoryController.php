<?php 

namespace Pierre\TrackMyCash\controllers;

use Pierre\TrackMyCash\core\Response;
use Pierre\TrackMyCash\core\Database;

class CategoryController 
{
    use Response;

    public function index()
    {
        $categories = Database::getInstance()->all("Categories",["id","name","user_id"]);

        return count($categories) != 0 
            ? $this->json(200,"categories",$categories) 
            : $this->json(404,"categories",$categories,"There is no category");
    }

    public function show($param)
    {
        $category = Database::getInstance()->find("Categories",$param);
        return $this->json(200,"category",$category);
    }

    public function store($param)
    {
        // il faut trim & sanitizer
        $user_id = $param["user_id"];
        $name = $param["name"];

        $data = [
            "name" => $name,
            "user_id" => $user_id, 
        ];

        Database::getInstance()->store("Categories",$data);

        return $this->json(
            202,
            "Category",
            $data,
            "Category added");
    }

    public function delete($param)
    {
        Database::getInstance()->delete("Categories",$param);
        return $this->success_202();
    }
}