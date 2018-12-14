<?php

namespace evelikto\di\storage\impl;

function session_start() {
	if (\GlobalFlags::$MUST_START_SESSION === false)
		throw new \Exception('session_start() shouldn\'t be called here');

	\GlobalFlags::$START_SESSION_CALLED = true;
}

namespace evelikto\test;

use evelikto\di\AppContextBase;
use evelikto\di\storage\{LocalStorage, SessionStorage};
use evelikto\di\creator\MethodCreator;
use evelikto\di\storage\impl\Session;

class SessionNotStartedConfig {

	public function diSessionStorage() {
		return new Session;
	}
}

class SessionNotStartedContext extends AppContextBase {
	use LocalStorage, SessionStorage, MethodCreator;
}