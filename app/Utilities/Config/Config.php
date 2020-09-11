<?php
namespace App\Utilities\Config;
class Config{
    protected static $configPath = __DIR__.'/../../../config';

    public static function getConfig($config){
        $config = explode('.',$config);
        $values = include(self::$configPath."/$config[0].php");
        return $values[$config[1]];
    }
}



