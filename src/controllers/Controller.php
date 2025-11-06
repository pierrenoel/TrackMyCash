<?php

namespace Pierre\TrackMyCash\controllers;

class Controller
{
    public function foundController(string $controller, string $action)
    {
        $controllerClass = "Pierre\\TrackMyCash\\controllers\\" . $controller;
        if (!class_exists($controllerClass) || !method_exists($controllerClass, $action)) {
            throw new \Exception();
        }
    }

    public function loadController(string $controller, string $action, $param = null)
    {
        $controllerClass = "Pierre\\TrackMyCash\\controllers\\" . $controller;
        $controller = new $controllerClass();
        $controller->$action($param);   
    }
}