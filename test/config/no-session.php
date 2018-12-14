<?php

namespace evelikto\test;

use evelikto\di\AppContextBase;
use evelikto\di\storage\{LocalStorage, SessionStorage};
use evelikto\di\reader\ConstReader;
use evelikto\di\creator\{MethodCreator, ClassCreator, InterfaceAliasCreator, InterfaceMethodCreator};
use evelikto\di\storage\impl\{Session};

class NoSessionConfig {
	public function diSessionStorage() {
		return new Session;
	}
}

class NoSessionContext extends AppContextBase {
	use
		  LocalStorage
		, SessionStorage
		, MethodCreator
		, ClassCreator
		, InterfaceAliasCreator
		, InterfaceMethodCreator
		, ConstReader
	;
}