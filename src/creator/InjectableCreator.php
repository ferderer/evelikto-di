<?php

namespace evelikto\di\creator;
use evelikto\di\{Bean, Injectable};

/** Creates dependency if identifier is a classname implementing the Injectable interface */
trait InjectableCreator
{
    /**
     * Resolves dependency from a given class name. Constructor injection will be used if needed.
     *
     * @param   string      $name   Name of the class to be created
     * @return  Bean|null           Wrapped new $name instance or null if no such class
     * @throws  ClassNotInjectable  If $name is not an Injectable
     */
    protected function fromClass(string $name) {
        if (class_exists($name, true) === false)
            return null;

        if (method_exists($name, '__construct') === false)
            $value = new $name;
        else {
            $method = new \ReflectionMethod($name, '__construct');
            $value = new $name(...$this->autowire($method));
        }

        if ($value instanceof Injectable)
            return new Bean($name, $value);

        throw new ClassNotInjectable($name);
    }
}