<?php

namespace evelikto\di\storage;

/** Is thrown when a required factory method is missing, thus providing no storage for an active scope */
class StorageFactoryNotDefined extends \evelikto\di\DiException
{
	/** @param	string	$name	Name of the required factory */
	public function __construct(string $name) {
		parent::__construct(['name' => $name]);
	}
}