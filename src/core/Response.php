<?php

namespace Pierre\TrackMyCash\core;
use Pierre\TrackMyCash\enums;

trait Response
{
    private function error(int $error, mixed $status) {
        header('Content-Type: application/json');

        http_response_code($error);

        $msg = [
           "msg" => $status->getErrors()
        ];

        return json_encode($msg,JSON_UNESCAPED_UNICODE);
    }

    public function json(array $response)
    {
        header('Content-Type: application/json');
        http_response_code(200);
        return json_encode($response,JSON_UNESCAPED_UNICODE);
    }

    public function error404()
    {
        return $this->error(404,enums\Errors::ERROR404);
    }

      public function error400()
    {
        return $this->error(400,enums\Errors::ERROR400);
    }

}