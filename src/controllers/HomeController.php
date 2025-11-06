<?php 

namespace Pierre\TrackMyCash\controllers;
use Pierre\TrackMyCash\core\Response;

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
        echo $this->json([
            "msg" => "test"
        ]);
    }

    public function post($param)
    {
       echo $param["name"];
    }
}