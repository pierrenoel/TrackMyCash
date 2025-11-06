<?php 

require __DIR__."/vendor/autoload.php";

use Pierre\TrackMyCash\core\Router;

// Router API

$router = new Router();

// $router->get("/",HomeController::class,"index",["id","name"]);
// $router->get("/test",HomeController::class,"test");
// $router->post("/post",HomeController::class,"post",["name"]);

// Categories
$router->get("/category",CategoryController::class,"index");
$router->post("/category",CategoryController::class,"store",["name","user_id"]);

$router->run();
