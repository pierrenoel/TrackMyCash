<?php

namespace Pierre\TrackMyCash\core;

use Pierre\TrackMyCash\controllers\ErrorController;
use Pierre\TrackMyCash\controllers\Controller;

use Pierre\TrackMyCash\core\Response;

class Router
{
    use Response;

    private array $routes = [];
    private string $url;
    private string $method;

    public function __construct()
    {
        $this->url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $this->method = $_SERVER["REQUEST_METHOD"];
    }

    /**
     * Définir une route GET
     */
    public function get(string $url, string $controller, string $action, ?array $param = null)
    {
        $this->routes["GET"][$url] = [
            "controller" => $controller,
            "action" => $action,
            "param" => $param
        ];
    }

    /**
     * Définir une route POST
     */
    public function post(string $url, string $controller, string $action, ?array $param = null)
    {
        $this->routes["POST"][$url] = [
            "controller" => $controller,
            "action" => $action,
            "param" => $param
        ];
    }

    public function run()
    {
        $methodRoutes = $this->routes[$this->method] ?? [];
        $externalController = new Controller();

        foreach ($methodRoutes as $routeUrl => $route) {
            if ($routeUrl !== $this->url) continue;

            $controller = $route["controller"];
            $action = $route["action"];
            $paramNames = $route["param"]; // tableau ou null
            $paramValues = [];

            // Vérifier et nettoyer les paramètres
            if ($paramNames) {
                foreach ($paramNames as $name) {
                    $source = $this->method === "GET" ? $_GET : $_POST;

                    if (!isset($source[$name]) || $source[$name] === "") {
                        echo $this->error400();
                        return;
                    }

                    $value = $source[$name];

                    if (is_string($value)) {
                        $value = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
                    }

                    $paramValues[$name] = $value;
                }
            }

            // Appel du controller
            try {
                $externalController->foundController($controller, $action);

                if ($paramValues) {
                    $externalController->loadController($controller, $action, $paramValues);
                } else {
                    $externalController->loadController($controller, $action);
                }

            } catch (\Exception $e) {
                echo $this->error400();
            }

            return; // stop après avoir trouvé la route
        }

        echo $this->error404();
    }
}
