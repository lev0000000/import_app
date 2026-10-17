<?php

namespace Server\Helpers;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

final class Log
{
    private static ?Logger $logger = null;

    private static function instance(): Logger
    {
        if (self::$logger === null) {
            self::$logger = new Logger('app');

            self::$logger->pushHandler(
                new StreamHandler(
                    dirname(__DIR__, 2) . '/logs/app.log',
                    Logger::DEBUG
                )
            );
        }

        return self::$logger;
    }

    public static function info(string $message, array $context = []): void
    {
        self::instance()->info($message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::instance()->error($message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::instance()->warning($message, $context);
    }

    public static function debug(string $message, array $context = []): void
    {
        self::instance()->debug($message, $context);
    }
}
