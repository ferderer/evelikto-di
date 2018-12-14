<?php

namespace evelikto\test;

use PHPUnit\Framework\TestCase;
use evelikto\di\creator\NotTheRequestedInterface;

class DiExceptionTest extends TestCase {

	public function testGetters() {
		$e = new NotTheRequestedInterface('ClassA', 'InterfaceA');

		$this->assertEquals('evelikto.di.creator.NotTheRequestedInterface', $e->getId());
		$this->assertCount(2, $e->getData());

		$this->assertEquals('evelikto.di.creator.NotTheRequestedInterface: classname = ClassA; interface = InterfaceA;', $e->getMessage());
	}
}