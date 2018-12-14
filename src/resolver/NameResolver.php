<?php

namespace evelikto\di\resolver;

/** Resolves parameter using its name */
trait NameResolver
{
    /**
     * Tries to resolve parameter by its name from previously resolved dependencies.
     *
     * @param   \ReflectionParameter  $param  Parameter to be resolved.
     * @return  mixed|null                    Resolved value or null.
     */
    protected function resolveStoredByName(\ReflectionParameter $param) {
        return $this->read($param->getName());
    }

    /**
     * Tries to resolve parameter by its name from factory method with the same name.
     *
     * @param   \ReflectionParameter  $param  Parameter to be resolved.
     * @return  mixed|null                    Resolved value or null.
     */
    protected function resolveMethodByName(\ReflectionParameter $param) {
        return $this->fromMethod($param->getName());
    }
}