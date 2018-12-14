<?php

namespace evelikto\test;

use evelikto\di\{Bean};
use evelikto\di\storage\impl\{Session, ApcuCache};
use evelikto\di\scope\{SessionScope, GlobalScope, PrototypeScope};

class AllEnabledConfig {
	const STRING_CONST = 'something stupid';
	const FLOAT_CONST = 1.42;
	const INT_CONST = 42;
	const ARRAY_CONST = [
		'GET /' => '/index.php',
		'GET /about' => '/about/index.php',
	];

	const EVELIKTO_TEST_I1 = C3::class;
	const EVELIKTO_TEST_I2 = 'evelikto\test\config\NonExistent';
	const EVELIKTO_TEST_I3 = C4::class;
	const EVELIKTO_TEST_I6 = CI6::class;
	const EVELIKTO_TEST_SCWAI = SCwA::class;
	const EVELIKTO_TEST_GCWAI = GCwA::class;

	public function checkConstAutowiring(array $ARRAY_CONST) {
		return $ARRAY_CONST;
	}

	public function diSessionStorage() {
		return new Session;
	}

	public function diGlobalStorage() {
		return new ApcuCache;
	}

	public function eveliktoTestI4() {
		return new C5;
	}

	public function eveliktoTestI5() {
		return new C6;
	}

	public function eveliktoTestI7() {
		return new CI7;
	}

	public function sessionBean() {
		return new Bean('sessionBean', new CSB, Bean::SCOPE_SESSION);
	}

	public function globalBean() {
		return new Bean('globalBean', new CGB, Bean::SCOPE_GLOBAL);
	}
}

class C1 {}

class C2 {
	public $c1;
	public function __construct(C1 $c1) {
		$this->c1 = $c1;
	}
}

interface I1 {
	public function m1();
}

class C3 implements I1 {
	public function m1() {}
}

interface I2 {
	public function m2();
}

interface I3 {
	public function m3();
}

class C4 implements I1 {
	public function m1() {}
}


interface I4 {
	public function m4();
}

class C5 implements I4 {
	public function m4() {}
}

interface I5 {
	public function m5();
}

class C6 implements I1 {
	public function m1() {}
}

class C7 {
	public $param;
	public function __construct(int $param = 42) {
		$this->param = $param;
	}
}

interface I6 {
	public function m6();
}

class CI6 implements I6 {
	public function m6() {
		return 42;
	}
}

class C8 {
	public $param;
	public function __construct(I6 $param) {
		$this->param = $param;
	}
	public function m6(I6 $param) {
		return $this->param;
	}
}

interface I7 {
	public function m7();
}

class CI7 implements I7 {
	public function m7() {
		return 42;
	}
}

class C9 {
	public $param;
	public function __construct(I7 $param) {
		$this->param = $param;
	}
}

class CS implements SessionScope {}
class CG implements GlobalScope {}
class CP implements PrototypeScope {}
class CSB {}
class CGB {}

interface SCwAI {}
class SCwA implements SCwAI, SessionScope {}
interface GCwAI {}
class GCwA implements GCwAI, GlobalScope {}