<?php

declare(strict_types=1);

namespace Framework;

use Framework\Exceptions\ContainerException;
use ReflectionClass;
use ReflectionNamedType;

class Container {
    private array $definitions = [];

    public function addDefinitions(array $newDefinitions) {
        $this->definitions = [...$this->definitions, ...$newDefinitions];
    }

    public function resolve(string $classname) {
        $reflectionClass = new ReflectionClass($classname);

        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException("Class $classname is not instantiable");
        }

        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            return new $classname;
        }
        
        $parameters = $constructor->getParameters();
        
        if (count($parameters) === 0) {
            return new $classname;
        }

        $dependencies = [];

        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            if (!$type) {
                throw new ContainerException("Failed to resolve class $classname because param $name is missing a type hint");
            }

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new ContainerException("Failed to resolve class $classname bceause invalid param name.");
            }

            $dependencies[] = $this->get($type->getName());
        }

        return $reflectionClass->newInstanceArgs($dependencies);
    }

    public function get(string $id) {
        if (!array_key_exists($id, $this->definitions)) {
            throw new ContainerException("Class $id does not exist in container.");
        }

        $factory = $this->definitions[$id];

        return $factory();
    }
}
