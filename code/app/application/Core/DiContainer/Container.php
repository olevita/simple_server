<?php

namespace Core\DiContainer;

use Closure;
use Exception;
use ReflectionClass;

class Container
{
//    protected array $instances = [];
//
//    public function set($abstract, $concrete = NULL)
//    {
//        if ($concrete === NULL) {
//            $concrete = $abstract;
//        }
//        $this->instances[$abstract] = $concrete;
//    }

    public function get($abstract, $parameters = [])
    {
//        if (!isset($this->instances[$abstract])) {
//            $this->set($abstract);
//        }

//        return $this->resolve($this->instances[$abstract], $parameters);
        return $this->resolve($abstract, $parameters);
    }

    public function resolve($concrete, $parameters)
    {
        if ($concrete instanceof Closure) {
            return $concrete($this, $parameters);
        }

        $reflector = new ReflectionClass($concrete);
        if (!$reflector->isInstantiable()) {
            throw new Exception("Class {$concrete} is not instantiable");
        }

        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return $reflector->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);
        return $reflector->newInstanceArgs($dependencies);
    }

    public function getDependencies($parameters): array
    {
        $dependencies = [];
        /** @var \ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType();
            if ($dependency->isBuiltin()) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new Exception("Can not resolve class dependency {$parameter->name}");
                }
            } else {
                $dependencies[] = $this->get($dependency->getName());
            }
        }

        return $dependencies;
    }
}