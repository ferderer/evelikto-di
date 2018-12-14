<?php

namespace evelikto\di\storage;

/** Minimal contract for offline (spanning multiple requests) scope storages */
interface OfflineStorage
{
    /**
     * Save value to the storage.
     *
     * @param   string  $name   Name of the stored value.
     * @return  mixed           Value retrieved from storage or null if not present.
     */
    public function fetch(string $key);

    /**
     * Fetch value from the storage. Return null is $name is not a valid key.
     *
     * @param   string  $name   Unique value identifier.
     * @param   mixed   $value  Value to be stored.
     */
    public function store(string $key, $value);
}