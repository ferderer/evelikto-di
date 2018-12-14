<?php

session_id(bin2hex(random_bytes(10)));
session_start();

class GlobalFlags {
	// PHP_SESSION_ACTIVE or PHP_SESSION_DISABLED or PHP_SESSION_NONE
	// set to null to delegate to the built-in function
	public static $SESSION_STATUS = null;

	// set to false to emulate not installed APCu
	public static $APCU = true;

	public static $MUST_START_SESSION = false;
	public static $START_SESSION_CALLED = false;
}

require_once 'config/functions.php';
require_once 'vendor/autoload.php';
