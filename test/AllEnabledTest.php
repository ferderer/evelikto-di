<?php

namespace evelikto\test;

require_once 'config/all-enabled.php';

use evelikto\di\{AppContext, UnresolvableDependency};
use evelikto\di\creator\NotTheRequestedInterface;
use evelikto\di\scope\{SessionScope, GlobalScope, PrototypeScope};
use evelikto\di\storage\{OfflineStorage};

class AllEnabledTest extends DiTestCase {

	protected function setUp() {
		$this->appContext = new AppContext(new AllEnabledConfig);
	}

	public function testReadConfigConst() {
		$this->assertEquals('something stupid', $this->get('STRING_CONST'));
		$this->assertEquals(1.42, $this->get('FLOAT_CONST'));
		$this->assertEquals(42, $this->get('INT_CONST'));

		$arr = $this->get('ARRAY_CONST');
		$this->assertCount(2, $arr);
		$this->assertEquals('/index.php', $arr['GET /']);
	}

	public function testFailUndefinedConst() {
		$this->expectException(UnresolvableDependency::class);
		$this->get('IS_NOT_THERE');
	}

	public function testFactoryMethod() {
		$obj = $this->get('diSessionStorage');
		$this->assertInstanceOf(OfflineStorage::class, $obj);
	}

	public function testClassCreator() {
		$c = $this->get('evelikto\test\C1');
		$this->assertInstanceOf(C1::class, $c);

		$c1 = $this->get(C1::class);
		$this->assertSame($c, $c1);
	}

	public function testClassCreatorWithAutowiring() {
		$c = $this->get(C2::class);
		$this->assertInstanceOf(C2::class, $c);
		$this->assertInstanceOf(C1::class, $c->c1);
	}

	public function testInterfaceAliasCreator() {
		$obj = $this->get(I1::class);
		$this->assertInstanceOf(C3::class, $obj);
	}

	public function testInterfaceAliasToNonExistentClass() {
		$this->expectException(UnresolvableDependency::class);
		$obj = $this->get(I2::class);
	}

	public function testInterfaceAliasToWrongClass() {
		$this->expectException(NotTheRequestedInterface::class);
		$obj = $this->get(I3::class);
	}

	public function testInterfaceFactory() {
		$obj = $this->get(I4::class);
		$this->assertInstanceOf(C5::class, $obj);
	}

	public function testInterfaceFactoryToWrongClass() {
		$this->expectException(NotTheRequestedInterface::class);
		$obj = $this->get(I5::class);
	}

	public function testAutowireByDefault() {
		$obj = $this->get(C7::class);
		$this->assertInstanceOf(C7::class, $obj);
		$this->assertSame(42, $obj->param);
	}

	public function testAutowireByInterfaceAlias() {
		$c = $this->get(C8::class);
		$this->assertInstanceOf(I6::class, $c->param);
		$this->assertSame(42, $c->param->m6());
	}

	public function testAutowireByInterfaceFactory() {
		$c = $this->get(C9::class);
		$this->assertInstanceOf(I7::class, $c->param);
		$this->assertSame(42, $c->param->m7());
	}

	public function testSessionScope() {
		$c = $this->get(CS::class);
		$this->assertInstanceOf(CS::class, $c);

		$c1 = $this->get(CS::class);
		$this->assertEquals($c, $c1);
		$this->assertInstanceOf(SessionScope::class, $c1);
	}

	public function testGlobalScope() {
		$c = $this->get(CG::class);
		$this->assertInstanceOf(CG::class, $c);

		$c1 = $this->get(CG::class);
		$this->assertEquals($c, $c1);
		$this->assertInstanceOf(GlobalScope::class, $c1);
	}

	public function testPrototypeScope() {
		$c = $this->get(CP::class);
		$this->assertInstanceOf(CP::class, $c);

		$c1 = $this->get(CP::class);
		$this->assertInstanceOf(CP::class, $c1);
		$this->assertFalse($c === $c1);
	}

	public function testSessionScopeBean() {
		$c = $this->get('sessionBean');
		$this->assertInstanceOf(CSB::class, $c);

		$c1 = $this->get(CSB::class);
		$this->assertEquals($c, $c1);
	}

	public function testGlobalScopeBean() {
		$c = $this->get('globalBean');
		$this->assertInstanceOf(CGB::class, $c);

		$c1 = $this->get(CGB::class);
		$this->assertEquals($c, $c1);
	}

	public function testSessionScopedWithAlias() {
		$c = $this->get(SCwAI::class);
		$this->assertInstanceOf(SCwAI::class, $c);

		$c1 = $this->get(SCwAI::class);
		$c2 = $this->get(SCwA::class);
		$this->assertEquals($c1, $c2);
	}

	public function testGlobalScopedWithAlias() {
		$c = $this->get(GCwAI::class);
		$this->assertInstanceOf(GCwAI::class, $c);

		$c1 = $this->get(GCwAI::class);
		$c2 = $this->get(GCwA::class);
		$this->assertEquals($c1, $c2);
	}

	public function testCheckConstAutowiring() {
		$arr = $this->get('checkConstAutowiring');
		$this->assertCount(2, $arr);
		$this->assertSame('/index.php', $arr['GET /']);
	}
}