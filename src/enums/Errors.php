<?php

namespace Pierre\TrackMyCash\enums;

enum Errors
{
    case ERROR404;
    case ERROR400;

    public function getErrors() : string 
    {
        return match($this){
            Errors::ERROR404 => "Route Not Found",
            Errors::ERROR400 => "Bad Request"
        };
    }
}
