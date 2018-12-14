<?php

namespace evelikto\test;

require_once 'config/session-not-started.php';

use evelikto\di\storage\impl\Session;

class SessionNotStartedTest extends DiTestCase {

	protected function setUp() {
		\GlobalFlags::$SESSION_STATUS = PHP_SESSION_NONE;
		\GlobalFlags::$MUST_START_SESSION = true;

		$this->appContext = new SessionNotStartedContext(new SessionNotStartedConfig);
	}

	public function testSessionNotStarted() {
		$s = $this->get('diSessionStorage');
		$this->assertInstanceOf(Session::class, $s);
		$this->assertTrue(\GlobalFlags::$START_SESSION_CALLED);
	}
}