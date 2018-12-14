<?php

namespace evelikto\di\creator;

/** Creates dependency if:
 * 1. $name is an interface
 * 2. Interface alias constant is defined in the config class
 * 3. Alias is a constructable class
 */
trait InterfaceAliasCreator
{
    /**
     * Resolves dependency from an interface alias. Alias is a class constant in the config class.
     * Alias is formed by replacing backslashes in the interface name with underlines and converting
     * it to uppercase. Value of the alias is a class name. For example to create \Monolog\Logger
     * for a \Psr\Log\LoggerInterface dependency use this:
     *
     * const PSR_LOG_LOGGERINTERFACE = '\Monolog\Logger';
     *
     * @param   string      $name         Name of the interface to be created
     * @return  Bean|null                 Wrapped new $name instance or null if no such class
     * @throws  NotTheRequestedInterface  If the created instance is not a $name
     */
    protected function fromInterfaceAlias(string $name) {
        if (interface_exists($name, true) === false)
            return null;

        $bean = $this->fromClass($this->fromConst($this->interfaceToAlias($name)));
        if ($bean === null)
            return null;

        if (is_subclass_of($bean->value, $name) === false)
            throw new NotTheRequestedInterface(get_class($bean->value), $name);

        $bean->addAlias($name);
        return $bean;
    }

    /**
     * Converts FQIN to a valid const name:
     * Psr\Log\LoggerInterface => PSR_LOG_LOGGERINTERFACE
     */
    private function interfaceToAlias(string $name) : string {
        return strtoupper(str_replace("\\", '_', $name));
    }
}