<?php

namespace Pierre\TrackMyCash\enums;

enum Errors
{
    case ERROR404_NOTFOUND;
    case ERROR404_RESOURCENOTFOUND;
    case ERROR400;

    public function getErrors() : string 
    {
        return match($this){
            Errors::ERROR404_NOTFOUND => "Route Not Found",
            Errors::ERROR404_RESOURCENOTFOUND => "Resource Not Found",
            Errors::ERROR400 => "Bad Request"
        };
    }
}
