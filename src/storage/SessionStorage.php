<?php

namespace evelikto\di\storage;
use evelikto\di\Bean;
use evelikto\di\scope\SessionScope;

/** Activates the session scope. */
trait SessionStorage
{
    /** @var OfflineStorageAdapter $sessionStorage Scope storage implementation */
    private $sessionStorage;

    /** Init the scope storage. Get the underlying storage implementation from factory method */
    protected function initSession() {
        $impl = $this->fromMethod(self::DI_SESSION_STORAGE_KEY);
        if ($impl === null)
            throw new StorageFactoryNotDefined(self::DI_SESSION_STORAGE_KEY);

        $this->sessionStorage = new OfflineStorageAdapter($impl->value);
    }

    /**
     * Try to read the requested dependency from the storage
     *
     * @param   string  $name  Dependency name.
     * @return  mixed          Retrieved value or null if not previously stored.
     */
    protected function fromSession(string $name) {
        return $this->sessionStorage->fetch($name);
    }

    /**
     * Save the dependency to the storage.
     *
     * @param   Bean    $bean  Dependency to be stored.
     * @return  mixed          Stored value from the supplied bean.
     */
    protected function toSession(Bean $bean) {
        if ($bean->scope === Bean::SCOPE_SESSION || $bean->value instanceof SessionScope)
            return $this->sessionStorage->store($bean);

        return null;
    }
}