<?php

namespace evelikto\test;

use PHPUnit\Framework\TestCase;

class DiTestCase extends TestCase {

	protected $appContext;

	protected function get(string $what) {
		return $this->appContext->get($what);
	}

	protected function setUp() {
		apcu_clear_cache();
		session_unset();

		\GlobalFlags::$SESSION_STATUS = null;
		\GlobalFlags::$APCU = true;
		\GlobalFlags::$MUST_START_SESSION = false;
		\GlobalFlags::$START_SESSION_CALLED = false;
	}
}