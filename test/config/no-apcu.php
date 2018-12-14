<?php

namespace evelikto\test;

use evelikto\di\AppContextBase;
use evelikto\di\storage\{LocalStorage, GlobalStorage};
use evelikto\di\reader\ConstReader;
use evelikto\di\creator\{MethodCreator, ClassCreator, InterfaceAliasCreator, InterfaceMethodCreator};
use evelikto\di\storage\impl\{ApcuCache};

class NoApcuConfig {
	public function diGlobalStorage() {
		return new ApcuCache;
	}
}

class NoApcuContext extends AppContextBase {
	use
		  LocalStorage
		, GlobalStorage
		, MethodCreator
		, ClassCreator
		, InterfaceAliasCreator
		, InterfaceMethodCreator
		, ConstReader
	;
}