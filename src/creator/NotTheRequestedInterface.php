<?php

namespace evelikto\di\creator;

/**
 * Is thrown when the created dependency does not implement the originally requested interface.
 */
class NotTheRequestedInterface extends \evelikto\di\DiException
{
    /**
     * @param  string  $name  Classname of the created dependency
     * @param  string  $name  Originally requested interface name
     */
    public function __construct(string $classname, string $interface) {
        parent::__construct(['classname' => $classname, 'interface' => $interface]);
    }
}