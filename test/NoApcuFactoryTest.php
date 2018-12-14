<?php

namespace evelikto\test;

require_once 'config/no-apcu-factory.php';

use evelikto\di\storage\StorageFactoryNotDefined;

class NoApcuFactoryTest extends DiTestCase {

	public function testNoApcuFactory() {
		$this->expectException(StorageFactoryNotDefined::class);
		$appContext = new NoApcuFactoryContext(new NoApcuFactoryConfig);
	}
}