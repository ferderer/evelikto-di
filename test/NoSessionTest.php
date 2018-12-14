<?php

namespace evelikto\test;

require_once 'config/no-session.php';

use evelikto\di\storage\impl\SessionsNotEnabled;

class NoSessionTest extends DiTestCase {

	protected function setUp() {
		\GlobalFlags::$SESSION_STATUS = PHP_SESSION_DISABLED;
	}

	public function testNoSession() {
		$this->expectException(SessionsNotEnabled::class);
		$appContext = new NoSessionContext(new NoSessionConfig);
	}
}