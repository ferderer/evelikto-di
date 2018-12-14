<?php

namespace evelikto\di;

/** Dependency DTO, which wraps all informations needed to store it. */
class Bean
{
    const SCOPE_PROTOTYPE = 'SCOPE_PROTOTYPE';
    const SCOPE_SESSION = 'SCOPE_SESSION';
    const SCOPE_GLOBAL = 'SCOPE_GLOBAL';

    public $name, $aliases = [], $value, $scope;

    public function __construct(string $name, $value, string $scope = null) {
        $this->name = $name;
        $this->value = $value;
        $this->scope = $scope;
    }

    public function addAlias(string $alias) {
        $this->aliases[] = $alias;
    }
}