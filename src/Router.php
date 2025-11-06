<?php

namespace Pierre\TrackMyCash;

use Pierre\TrackMyCash\controllers\ErrorController;
use Pierre\TrackMyCash\controllers\Controller;

class Router
{
    private array $routes = [];
    private string $url;
    private string $method;

    public function __construct()
    {
        $this->url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $this->method = $_SERVER["REQUEST_METHOD"];
    }

    public function get(string $url, string $controller, string $action, ?string $param = null)
    {
        $this->routes["GET"][$url] = [
            "controller" => $controller,
            "action" => $action,
            "param" => $param
        ];
    }

    public function run()
    {

        $methodRoutes = $this->routes[$this->method] ?? [];
        $ErrorController = new ErrorController();
        $externalController = new Controller();

        foreach ($methodRoutes as $routeUrl => $route) {

            if ($routeUrl !== $this->url) continue;

            $controller = $route["controller"];
            $action = $route["action"];
            $paramName = $route["param"];

            // Vérifie paramètre requis
            if ($paramName && (!isset($_GET[$paramName]) || empty($_GET[$paramName]))) {
                echo $ErrorController->error400();
                return;
            }

            try {
                $externalController->foundController($controller, $action);
                $externalController->loadController($controller, $action, \htmlspecialchars($_GET[$paramName]));
            } catch (\Exception $e) {
                echo $ErrorController->error400();
            }

            return;
        }

        echo $ErrorController->error404();
    }
}
