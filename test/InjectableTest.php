<?php

namespace evelikto\test;

require_once 'config/injectable.php';

use evelikto\di\UnresolvableDependency;
use evelikto\di\creator\ClassNotInjectable;

class InjectableTest extends DiTestCase {

	protected function setUp() {
		$this->appContext = new InjectableContext(new InjectableConfig);
	}

	public function testNonExistentClass() {
		$this->expectException(UnresolvableDependency::class);
		$c = $this->get('evelikto\test\NonExistent');
	}

	public function testNonInjectableExistentClass() {
		$this->expectException(ClassNotInjectable::class);
		$c = $this->get(C11::class);
	}

	public function testDefaultCtorInjectable() {
		$c = $this->get(C12::class);
		$this->assertInstanceOf(C12::class, $c);

		$c1 = $this->get(C12::class);
		$this->assertSame($c, $c1);
	}

	public function testClassCreatorWithAutowiring() {
		$c = $this->get(C13::class);
		$this->assertInstanceOf(C13::class, $c);
		$this->assertInstanceOf(C12::class, $c->c12);
	}
}