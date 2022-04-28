<?php

namespace Core;

class Loader
{
    public static function loadClass($class)
    {
        if (!class_exists($class)) {
            return null;
        }
        $instance = self::getInstance($class);
        if (!$instance) {
            throw new \Exception("Can't create class instance");
        }
        return array_shift($instance);
    }

    public static function getInstance(string $class): array
    {
        $args = [];
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        if ($constructor) {
            $params = $constructor->getParameters();
            $subParams = [];
            foreach ($params as $param) {
                $argClass = $param->getType()->getName();
                if (class_exists($argClass)) {
                    $subParams = self::getInstance($argClass);
                }
            }
            $args[] = new $class(...$subParams);
        } else {
            $args[] = new $class();
        }
        return $args;
    }
}