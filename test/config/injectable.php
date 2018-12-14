<?php

namespace evelikto\test;

use evelikto\di\{AppContextBase, Injectable};
use evelikto\di\storage\LocalStorage;
use evelikto\di\creator\InjectableCreator;
use evelikto\di\resolver\TypeResolver;

class InjectableConfig {}

class InjectableContext extends AppContextBase {
	use
		  LocalStorage
		, InjectableCreator
		, TypeResolver
	;
}

class C11 {}
class C12 implements Injectable {}
class C13 implements Injectable {
	public $c12;
	public function __construct(C12 $c12) {
		$this->c12 = $c12;
	}
}