<?php

namespace evelikto\di\storage;
use evelikto\di\Bean;
use evelikto\di\scope\Scope;

/** Activates the local (singleton or request) scope. */
trait LocalStorage
{
    /** @var array $storage Holds previously resolved dependencies with singleton scope */
    protected $storage = [];

    /**
     * Try to read the requested dependency from the storage
     *
     * @param   string  $name  Dependency name.
     * @return  mixed          Retrieved value or null if not previously stored.
     */
    protected function fromLocal($name) {
        return array_key_exists($name, $this->storage) ? $this->storage[$name] : null;
    }

    /**
     * Save the dependency to the storage.
     *
     * @param   Bean    $bean  Dependency to be stored.
     * @return  mixed          Stored value from the supplied bean.
     */
    protected function toLocal(Bean $bean) {
        if ($bean->scope !== null || ($bean->value instanceof Scope))
            return null;

        $this->storage[$bean->name] = $bean->value;
        foreach ($bean->aliases as $alias)
            $this->storage[$alias] = $bean->value;

        return $bean->value;
    }
}