<?php

namespace evelikto\di;

/** Is thrown when no dependency exists or can be created for the supplied name. */
class UnresolvableDependency extends DiException
{
	/** @param	string	$name	Name of the dependency. */
	public function __construct(string $name) {
		parent::__construct(['name' => $name]);
	}
}