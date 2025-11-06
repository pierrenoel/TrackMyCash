<?php 

namespace Pierre\TrackMyCash\controllers;

use Pierre\TrackMyCash\core\Response;
use Pierre\TrackMyCash\core\Database;

class HomeController 
{
    use Response;

    public function index($param){
        echo $this->json([
            "msg" => "index"
        ]);
    }

    public function test()
    {
        $users = Database::getInstance()->all("Users",["name","email"]);

        echo $this->json([
            "users" => $users
        ]);
    }

    public function post($param)
    {
       echo $param["name"];
    }
}