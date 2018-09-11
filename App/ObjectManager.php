<?php

namespace App;

class ObjectManager
{
    private static $instances = [];
    public static function getObject($className)
    {
        if (array_key_exists($className, self::$instances))
            return self::$instances[$className];
        $classReader = new \Helper\ClassReader();
        $params = $classReader->getConstructor($className);
        $args = [];
        if ($params) {
            foreach ($params as $param) {
                if ($param[1] != null) {
                    $instance = null;
                    if (!array_key_exists($param[1], self::$instances)) {
                        $instance = self::getObject($param[1]);
                        self::$instances[$param[1]] = $instance;
                    } else {
                        $instance = self::$instances[$param[1]];
                    }
                    array_push($args, $instance);
                } else array_push($args, null);
            }
        }
        $instance = new $className(...$args);
        self::$instances[$className] = $instance;
        return $instance;
    }

    public static function initObject($className, $instance) {
        self::$instances[$className] = $instance;
    }
}