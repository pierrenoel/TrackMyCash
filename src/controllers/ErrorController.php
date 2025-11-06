<?php

namespace Pierre\TrackMyCash\controllers;
use Pierre\TrackMyCash\enums;

class ErrorController
{
    private function init(int $error, mixed $status) {
        header('Content-Type: application/json');

        http_response_code($error);

        $msg = [
           "msg" => $status->getErrors()
        ];

        return json_encode($msg,JSON_UNESCAPED_UNICODE);
    }

    public function error404()
    {
        return $this->init(404,enums\Errors::ERROR404);
    }

      public function error400()
    {
        return $this->init(400,enums\Errors::ERROR400);
    }
}