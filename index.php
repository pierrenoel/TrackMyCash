<?php 

require __DIR__."/vendor/autoload.php";

use Pierre\TrackMyCash\core\Router;

// Router API

$router = new Router();

// Categories
$router->get("/categories",CategoryController::class,"index");
$router->get("/category",CategoryController::class,"show",["id"]);
$router->post("/categories",CategoryController::class,"store",["name","user_id"]);
$router->delete("/categories",CategoryController::class,"delete",["id"]);

// Transaction
$router->get("/transactions",TransactionController::class,"index");
$router->post("/transactions",TransactionController::class,"store",[
    "type","amount","description","user_id","category_id"
]);
$router->delete("/transactions",TransactionController::class,"delete",["id"]);

$router->run();