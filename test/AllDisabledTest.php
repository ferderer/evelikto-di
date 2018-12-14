<?php

namespace evelikto\test;

require_once 'config/all-disabled.php';

use evelikto\di\UnresolvableDependency;

class AllDisabledTest extends DiTestCase {

	protected function setUp() {
		$this->appContext = new AllDisabledContext(new AllDisabledConfig);
	}

	public function testAlwaysFail() {
		$this->expectException(UnresolvableDependency::class);
		$this->get('does not matter what');
	}
}