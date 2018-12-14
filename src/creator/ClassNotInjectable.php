<?php

namespace evelikto\di\creator;

/** Is thrown when the created dependency is not marked with the Injectable interface */
class ClassNotInjectable extends \evelikto\di\DiException
{
    /** @param  string  $name   Classname of the dependency. */
    public function __construct(string $name) {
        parent::__construct(['name' => $name]);
    }
}