<?php

namespace evelikto\di\reader;

/** Reads config constant $name which can also be handled as a dependency */
trait ConstReader
{
    /**
     * Resolves dependency from a const config value, returns null if no such const exists.
     *
     * @param   string      $name  Name of the constant
     * @return  mixed|null         Constant value or null if no such const
     */
    protected function fromConst(string $name) {
        $cname = $this->configClassName.'::'.$name;
        return defined($cname) ? constant($cname) : null;
    }
}