<?php

namespace evelikto\test;

use evelikto\di\AppContextBase;
use evelikto\di\storage\{LocalStorage, GlobalStorage};
use evelikto\di\reader\ConstReader;
use evelikto\di\creator\{MethodCreator};

class NoApcuFactoryConfig {}

class NoApcuFactoryContext extends AppContextBase {
	use LocalStorage, GlobalStorage, MethodCreator, ConstReader;
}