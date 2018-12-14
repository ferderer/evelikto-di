<?php

namespace evelikto\di\creator;
use evelikto\di\Bean;

/** Creates dependency if identifier is a classname */
trait ClassCreator
{
    /**
     * Resolves dependency from a given class name. Constructor injection will be used if needed.
     *
     * @param   string      $name   Name of the class to be created
     * @return  Bean|null           New $name instance or null if no such class
     */
    protected function fromClass(string $name) {
        if (class_exists($name, true) === false)
            return null;

        if (method_exists($name, '__construct') === false)
            return new Bean($name, new $name);

        $method = new \ReflectionMethod($name, '__construct');
        return new Bean($name, new $name(...$this->autowire($method)));
    }
}