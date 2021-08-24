<?php

namespace Rockads\Suite;


class Config
{
    private static $_instance = null;

    public function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new Self;
        }

        return self::$_instance;
    }

    public function get($path)
    {
        if (isset($path)) {
            $config = require_once(__DIR__.'/../config/suite.php');

            $path   = explode('.', $path);
            foreach ($path as $key) {
                if (isset($config[$key])) {
                    $config = $config[$key];
                }
            }

            return $config;
        }
    }

    private function __clone() {}
    private function __wakeup() {}
    private function __construct() {}

    public function __destruct()
    {
        self::$_instance = null;
    }
}