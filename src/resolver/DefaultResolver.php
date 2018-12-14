<?php

namespace evelikto\di\resolver;

/** Resolves parameter to its default value if present */
trait DefaultResolver
{
    /**
     * Resolves parameter to its default value.
     *
     * @param   \ReflectionParameter  $param  Parameter to be resolved.
     * @return  mixed|null                    Parameter default value or null if no default.
     */
    protected function resolveByDefault(\ReflectionParameter $param) {
        return $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
    }
}