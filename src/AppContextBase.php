<?php

namespace evelikto\di;

/**
 * Implements a dynamic Dependency Injection container with autowiring support.
 *
 * Evelikto-DI is configurable via an arbitrary class instance in which every method is
 * considered to be a factory method and each constant is considered to be a config value.
 */
abstract class AppContextBase
{
    const DI_CONTAINER_KEY = 'appContext';
    const DI_SESSION_STORAGE_KEY = 'diSessionStorage';
    const DI_GLOBAL_STORAGE_KEY = 'diGlobalStorage';

    /** @var  object  config  Application config, which provides constants and factory methods */
    protected $config;

    /** @var \ReflectionClass Cache for efficient retrieval of factory methods */
    protected $configReflClass;

    /** @var string configCName Cache for efficient retrieval of constant values */
    protected $configClassName;

    /**
     * Creates new application context and registers itself.
     *
     * @param  object  $config  Configuration class instance.
     */
    public function __construct($config) {
        $this->config = $config;
        $this->configReflClass = new \ReflectionClass($config);
        $this->configClassName = get_class($config);

        $this->initSession();
        $this->initGlobal();

        $this->set(static::DI_CONTAINER_KEY, $this);
        $this->set(get_class($this), $this);
    }

    /**
     * Creates a new or fetches a previously resolved dependency.
     *
     * @param   string  $name  Name of the dependency to be resolved.
     * @return  mixed          The resolved dependency.
     */
    public function get(string $name) {
        $value = $this->read($name);
        if ($value !== null)
            return $value;

        $bean = $this->create($name);
        if ($bean === null)
            throw new UnresolvableDependency($name);

        return $this->store($bean);
    }

    /**
     * Stores manually created object.
     *
     * @param   string  $name  Name of the dependency.
     * @param   mixed   $name  Dependency to be stored.
     * @param   string  $name  Scope name. Defaults to the singleton (local) scope.
     * @return  mixed          Returns the stored object back.
     */
    public function set(string $name, $value, string $scope = null) {
        return $this->store(new Bean($name, $value, $scope));
    }

    /**
     * Resolves arguments for a factory method or a controller action.
     *
     * @param   \ReflectionParameter  $param  Parameter which has to be resolved.
     * @return  mixed                         Resolved dependency.
     * @throws  UnresolvableParameter         If the parameter cannot be resolved.
     */
    public function resolve(\ReflectionParameter $param) {
        $value = $this->resolveStoredByName($param);
        if ($value !== null)
            return $value;

        $bean = $this->resolveMethodByName($param) ?? $this->resolveByType($param);
        if ($bean !== null)
            return $this->store($bean);

        $value = $this->resolveByDefault($param);
        if ($value !== null)
            return $value;

        throw new UnresolvableParameter($param->getName());
    }

    /**
     * Reads previously saved dependency or just a constant from config class.
     *
     * @param   string  $name  Dependency which has to be read.
     * @return  mixed          Read dependency, constant or null.
     */
    protected function read(string $name) {
        return $this->fromLocal($name)
            ?? $this->fromConst($name)
            ?? $this->fromSession($name)
            ?? $this->fromGlobal($name)
            ?? null;
    }

    /**
     * Creates a new dependency in a number of ways.
     *
     * @param  string  $name  Name of the dependency to be created. Can be class or interface name.
     * @return Bean           Resolved dependency wrapped as a Bean class instance or null.
     */
    protected function create(string $name) {
        return $this->fromMethod($name)
            ?? $this->fromClass($name)
            ?? $this->fromInterfaceMethod($name)
            ?? $this->fromInterfaceAlias($name)
            ?? null;
    }

    /**
     * Saves a dependency, returns unwrapped value.
     *
     * @param  Bean  $bean  Wrapped dependency to be saved.
     * @return mixed        Unwrapped dependency value.
     */
    protected function store(Bean $bean) {
        return $this->toLocal($bean)
            ?? $this->toSession($bean)
            ?? $this->toGlobal($bean)
            ?? $bean->value;
    }

    /**
     * Recursively resolves all method parameters
     *
     * @param  \ReflectionMethod  $method  Method to be autowired.
     * @returns                            Array of resolved parameters.
     */
    protected function autowire(\ReflectionMethod $method) {
        return array_map([$this, 'resolve'], $method->getParameters());
    }

    // Placeholders to disable functions not redefined by traits

    // ClassCreator
    protected function fromClass(string $name) {
        return null;
    }

    // InterfaceAliasCreator
    protected function fromInterfaceAlias(string $name) {
        return null;
    }

    // InterfaceMethodCreator
    protected function fromInterfaceMethod(string $name) {
        return null;
    }

    // MethodCreator
    protected function fromMethod(string $name) {
        return null;
    }

    // ConstReader
    protected function fromConst(string $name) {
        return null;
    }

    // DefaultResolver
    protected function resolveByDefault(\ReflectionParameter $param) {
        return null;
    }

    // NameResolver
    protected function resolveStoredByName(\ReflectionParameter $param) {
        return null;
    }
    protected function resolveMethodByName(\ReflectionParameter $param) {
        return null;
    }

    // TypeResolver
    protected function resolveByType(\ReflectionParameter $param) {
        return null;
    }

    // LocalStorage
    protected function fromLocal(string $name) {
        return null;
    }
    protected function toLocal(Bean $bean) {
        return null;
    }

    // SessionStorage
    protected function initSession() {
    }
    protected function fromSession(string $name) {
        return null;
    }
    protected function toSession(Bean $bean) {
        return null;
    }

    // GlobalStorage
    protected function initGlobal() {
    }
    protected function fromGlobal(string $name) {
        return null;
    }
    protected function toGlobal(Bean $bean) {
        return null;
    }
}