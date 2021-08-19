<?php

namespace Needletail\Helpers;

class ConfigHelper
{

    /**
     * @var array
     */
    private static array $config = [];

    /**
     * @param  string  $key
     * @return mixed|null
     */
    public static function get(string $key)
    {
        self::initConfig();
        return (self::$config[$key]) ?? null;
    }

    /**
     *
     */
    private static function initConfig()
    {
        if (empty(self::$config)) {
            self::$config = require_once __DIR__.'/../config.php';
        }
    }
}
