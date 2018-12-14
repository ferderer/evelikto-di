<?php

namespace evelikto\di\storage\impl;
use evelikto\di\storage\OfflineStorage;

/** Session storage implementation */
class Session implements OfflineStorage
{
    /** Just ensure the preconditions - session is active and started */
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        else if (session_status() === PHP_SESSION_DISABLED)
            throw new SessionsNotEnabled();
    }

    /** {@inheritdoc} */
    public function fetch(string $key) {
        return isset($_SESSION[$key]) ? unserialize($_SESSION[$key]) : null;
    }

    /** {@inheritdoc} */
    public function store(string $key, $value) {
        $_SESSION[$key] = serialize($value);
    }
}