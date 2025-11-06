<?php 

require __DIR__."/vendor/autoload.php";

use Pierre\TrackMyCash\core\Router;

// Router API

$router = new Router();

$router->get("/",HomeController::class,"index",["id","name"]);
$router->get("/test",HomeController::class,"test");

$router->post("/post",HomeController::class,"post",["name"]);


$router->run();
