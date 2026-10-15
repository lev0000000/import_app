<?php
namespace Server\Config;

use Exception;

class Config
{
    public static function get(string $key):string{
        return match ($key) {
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_NAME'),
            'user' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
            default =>   throw new Exception("Unknow key:" . $key) 
        };
    }

}
