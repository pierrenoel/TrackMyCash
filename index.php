<?php 

require __DIR__."/vendor/autoload.php";

use Pierre\TrackMyCash\Router;

// Router API

$router = new Router();

$router->get("/","HomeController","index","id");
$router->get("/test","HomeController","treest");

$router->run();
