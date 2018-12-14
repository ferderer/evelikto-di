<?php

namespace evelikto\di\creator;

/** Creates dependency if:
 * 1. $name is an interface
 * 2. Interface method factory is defined in the config class
 */
trait InterfaceMethodCreator
{
    /**
     * Resolves dependency from an interface factory method. Factory method name is formed from the
     * interface name through converting it to a valid camel-case identifier. For example,
     * to create \Monolog\Logger for \Psr\Log\LoggerInterface dependency use this:
     *
     * public function psrLogLoggerInterface() {
     *     return new \Monolog\Logger('channelname');
     * }
     *
     * @param   string      $name   Name of the interface to be created
     * @return  Bean|null           New $name instance or null if no such class
     * @throws  NotTheRequestedInterface if the created instance is not a $name
     */
    protected function fromInterfaceMethod(string $name) {
        if (interface_exists($name, true) === false)
            return null;

        $bean = $this->fromMethod($this->interfaceToFactory($name));
        if ($bean === null)
            return null;

        if (is_subclass_of($bean->value, $name) === false)
            throw new NotTheRequestedInterface(get_class($bean->value), $name);

        $bean->addAlias($name);
        return $bean;
    }

    /**
     * Converts FQIN to a valid camel-case method name:
     *   \Psr\Log\LoggerInterface => psrLogLoggerInterface
     */
    private function interfaceToFactory(string $name) : string {
        return lcfirst(str_replace("\\", '', ucwords($name, "\\")));
    }
}