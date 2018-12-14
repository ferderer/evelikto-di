<?php

namespace evelikto\di\storage;
use evelikto\di\Bean;

/** Implements logic common to all offline storages */
class OfflineStorageAdapter
{
    const DI_VALUE_PREFIX = 'DI_VALUE:';
    const DI_ALIAS_PREFIX = 'DI_ALIAS:';

    /** @var OfflineStorage $storage  The real scope storage. */
    private $storage;

    /** @param   OfflineStorage  $storage  The real scope storage */
    public function __construct(OfflineStorage $storage) {
        $this->storage = $storage;
    }

    /**
     * Try to read the requested dependency from the storage by its name or by an alias.
     *
     * @param   string  $name  Dependency name.
     * @return  mixed|null     Retrieved value or null if not previously stored.
     */
    public function fetch($name) {
        $value = $this->storage->fetch(self::DI_VALUE_PREFIX.$name);
        if ($value !== null)
            return $value;

        $alias = $this->storage->fetch(self::DI_ALIAS_PREFIX.$name);
        if ($alias !== null)
            return $this->storage->fetch(self::DI_VALUE_PREFIX.$alias);

        return null;
    }

    /**
     * Unpacks the supplied bean, saves the value under the main name, as well as under its aliases.
     *
     * @param   Bean  $bean  Wrapped dependency.
     * @return  mixed        Unwrapped dependency value.
     */
    public function store(Bean $bean) {
        $this->storage->store(self::DI_VALUE_PREFIX.$bean->name, $bean->value);
        foreach($bean->aliases as $alias)
            $this->storage->store(self::DI_ALIAS_PREFIX.$alias, $bean->name);

        return $bean->value;
    }
}