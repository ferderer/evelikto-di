<?php

namespace evelikto\test;

require_once 'config/autowire-disabled.php';

use evelikto\di\UnresolvableParameter;

class AutowireDisabledTest extends DiTestCase {

	protected function setUp() {
		$this->appContext = new AutowireDisabledContext(new AutowireDisabledConfig);
	}

	public function testAutowireFailureByInterfaceAlias() {
		$this->expectException(UnresolvableParameter::class);
		$obj = $this->get(C102::class);
	}

	public function testAutowireFailureByInterfaceFactory() {
		$this->expectException(UnresolvableParameter::class);
		$obj = $this->get(C104::class);
	}
}