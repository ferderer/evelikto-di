<?php

namespace evelikto\test;

require_once 'config/no-session-factory.php';

use evelikto\di\storage\StorageFactoryNotDefined;

class NoSessionFactoryTest extends DiTestCase {

	public function testNoSessionFactory() {
		$this->expectException(StorageFactoryNotDefined::class);
		$appContext = new NoSessionFactoryContext(new NoSessionFactoryConfig);
	}
}