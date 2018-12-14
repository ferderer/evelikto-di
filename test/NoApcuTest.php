<?php

namespace evelikto\test;

require_once 'config/no-apcu.php';

use evelikto\di\storage\impl\ApcuNotInstalled;

class NoApcuTest extends DiTestCase {

	protected function setUp() {
		\GlobalFlags::$APCU = false;
	}

	public function testNoApcu() {
		$this->expectException(ApcuNotInstalled::class);
		$appContext = new NoApcuContext(new NoApcuConfig);
	}
}