<?php

namespace evelikto\di;

/** Is thrown when autowiring of a method parameter fails */
class UnresolvableParameter extends DiException
{
	/** @param	string	$name	Name of the parameter. */
	public function __construct(string $name) {
		parent::__construct(['name' => $name]);
	}
}