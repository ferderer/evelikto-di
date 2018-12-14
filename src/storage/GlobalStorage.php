<?php

namespace evelikto\di\storage;
use evelikto\di\Bean;
use evelikto\di\scope\GlobalScope;

/** Activates the global scope. Factory 'diGlobalStorage' must be defined in the config class */
trait GlobalStorage
{
    /** @var OfflineStorageAdapter $globalStorage Scope storage implementation */
    private $globalStorage;

    /** Init the scope storage. Get the underlying storage implementation from factory method */
    protected function initGlobal() {
        $impl = $this->fromMethod(self::DI_GLOBAL_STORAGE_KEY);
        if ($impl === null)
            throw new StorageFactoryNotDefined(self::DI_SESSION_STORAGE_KEY);

        $this->globalStorage = new OfflineStorageAdapter($impl->value);
    }

    /**
     * Try to read the requested dependency from the storage
     *
     * @param   string  $name  Dependency name.
     * @return  mixed          Retrieved value or null if not previously stored.
     */
    protected function fromGlobal(string $name) {
        return $this->globalStorage->fetch($name);
    }

    /**
     * Save the dependency to the storage.
     *
     * @param   Bean    $bean  Dependency to be stored.
     * @return  mixed          Stored value from the supplied bean.
     */
    protected function toGlobal(Bean $bean) {
        if ($bean->scope === Bean::SCOPE_GLOBAL || $bean->value instanceof GlobalScope)
            return $this->globalStorage->store($bean);

        return null;
    }
}