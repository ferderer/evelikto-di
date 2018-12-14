<?php

namespace evelikto\di\creator;
use evelikto\di\Bean;

/** Creates dependency if config class has factory method named $name */
trait MethodCreator
{
    /**
     * Resolves dependency from a factory method.
     * Method parameters will be autowired.
     *
     * @param   string  $name  Name of the factory method
     * @return  Bean|null      Wrapped factory method result or null if no such factory
     */
    protected function fromMethod(string $name) {
        if (method_exists($this->config, $name) === false)
            return null;

        $method = $this->configReflClass->getMethod($name);
        $value = $this->config->$name(...$this->autowire($method));
        return ($value instanceof Bean) ? $value : new Bean($name, $value);
    }
}