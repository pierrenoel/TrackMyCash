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

    public function json(int $status, string $title, array $data, ?string $message = null)
    {
        header('Content-Type: application/json');
        
        http_response_code($status);

        $response = ["status" => $status];

        if (!empty($message)) $response["msg"] = $message;

        $response[$title] = $data;

        echo json_encode($response,JSON_UNESCAPED_UNICODE);

        return;
    }

    public function success_202()
    {
        header('Content-Type: application/json');
        http_response_code(202);
    }

    public function error_404_Not_Found()
    {
        return $this->error(404,enums\Errors::ERROR404_NOTFOUND);
    }

    public function error_404_Resource_Not_Found()
    {
        return $this->error(404,enums\Errors::ERROR404_RESOURCENOTFOUND);
    }

      public function error_400()
    {
        return $this->error(400,enums\Errors::ERROR400);
    }

}