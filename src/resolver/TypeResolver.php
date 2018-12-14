<?php

namespace evelikto\di\resolver;

/** Resolves parameter using its type hint */
trait TypeResolver
{
    /**
     * Tries to resolve parameter by its type hint.
     *
     * @param   \ReflectionParameter  $param  Parameter to be resolved.
     * @return  mixed|null                    Resolved value or null.
     */
    protected function resolveByType(\ReflectionParameter $param) {
        if ($param->hasType() === false || $param->getType()->isBuiltin())
            return null;

        $name = $param->getClass()->getName();
        return $this->fromClass($name)
            ?? $this->fromInterfaceMethod($name)
            ?? $this->fromInterfaceAlias($name)
            ?? null;
    }
}