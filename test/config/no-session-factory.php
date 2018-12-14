<?php

namespace evelikto\test;

use evelikto\di\AppContextBase;
use evelikto\di\storage\{LocalStorage, SessionStorage};
use evelikto\di\reader\ConstReader;
use evelikto\di\creator\{MethodCreator};

class NoSessionFactoryConfig {}
class NoSessionFactoryContext extends AppContextBase {
	use LocalStorage, SessionStorage, MethodCreator, ConstReader;
}