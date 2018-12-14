<?php

namespace evelikto\test;

use evelikto\di\AppContextBase;
use evelikto\di\storage\{LocalStorage};
use evelikto\di\reader\ConstReader;
use evelikto\di\creator\{MethodCreator, ClassCreator, InterfaceAliasCreator, InterfaceMethodCreator};

interface I101 {}
class C101 implements I101 {}
class C102 {
	public function __construct(I101 $i101) {}
}

interface I103 {}
class C103 implements I103 {}
class C104 {
	public function __construct(I103 $i103) {}
}

class AutowireDisabledConfig {
	const EVELIKTO_TEST_I101 = C101::class;

	public function eveliktoTestI103() {
		return new C103;
	}
}

class AutowireDisabledContext extends AppContextBase {
	use
		  LocalStorage
		, MethodCreator
		, ClassCreator
		, InterfaceAliasCreator
		, InterfaceMethodCreator
		, ConstReader
	;
}