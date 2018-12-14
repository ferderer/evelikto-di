<?php

namespace evelikto\di\storage\impl;
use evelikto\di\storage\OfflineStorage;

/** Global storage implementation */
class ApcuCache implements OfflineStorage
{
    /** Just check the precondition - APCu must be installed */
    public function __construct() {
        if (function_exists('apcu_fetch') === false)
            throw new ApcuNotInstalled();
    }

    /** {@inheritdoc} */
    public function fetch(string $key) {
        return apcu_exists($key) ? apcu_fetch($key) : null;
    }

    /** {@inheritdoc} */
    public function store(string $key, $value) {
        apcu_store($key, $value);
    }
}