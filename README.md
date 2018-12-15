[![Build Status](https://travis-ci.com/ferderer/evelikto-di.svg?branch=master)](https://travis-ci.com/ferderer/evelikto-di)
[![Coverage](https://codecov.io/gh/ferderer/di/branch/master/graph/badge.svg)](https://codecov.io/gh/ferderer/di)

# evelikto-di
The most flexible (ευέλικτος!) dependency injection container of the world for PHP. Use just the features you want without runtime configuration costs.

## Motivation
Although there are dozens of PHP DI libraries on GitHub, there is none which provides zero runtime-cost container configuration. Or configuration, which may easily be decomposed into smaller chunks, or which can be extended for use in different environments.
Evelikto-DI goals are to combine performance, small size, maximal flexibility with an easy to use container config.

## Installation
Evelikto is available via Composer/Packagist:
```json
"require": {
  "evelikto/di": "^1.0"
}
```
Or via Composer CLI:
```bash
composer require evelikto/di ^1.0 --prefer-distr
```

## Usage
Class \evelikto\di\AppContext is the default implementation of the DI container. The basic usage is to instantiate the container with the new-operator, passing the application config to the constructor, and then either passing the container to the framework, or to use the container to initialize the framework.
```PHP
$appContext = new \evelikto\di\AppContext(new AppConfig());
```

The configuration class must follow a few conventions:
	1. Every method in the class is considered to be a factory method.
	2. Every constant in the class is considered to be a configuration value.
	3. A constant can also represent an interface name alias (equal to the implementing concrete class).
	4. A method can also map an interface to a factory method.

```PHP
// Every class can be a configuration class, there are no base classes
class AppConfig {
	// every constant in this class is considered to be a config value
	// these values are injectable by name: use $MY_APP_CONFIG_VALUE as argument
	const MY_APP_CONFIG_VALUE = 'config value';
	const ANOTHER_CONFIG_VALUE = 1.42;

	// this an alias for the interface \evelikto\mvc\Router
	// pointing to the concrete class \evelikto\mvc\router\ViewRouter
	// AppContext can now autowire ViewRouter if asked for a Router interface
	// function xxx(Router $router) will be injected with a ViewRouter instance.
	const EVELIKTO_MVC_ROUTER = '\\evelikto\\mvc\\router\\ViewRouter';

	// every method is considered to be a factory method
	// $pdo argument will be autowired by the container
	// container will register the new dependency
	// as 'databaseService' & '\app\core\DatabaseService'
	public function databaseService(\PDO $pdo) {
		$db = new \app\core\DatabaseService($pdo);
		// do some additional initialization
		return $db;
	}

	// Arrays can also be config values
	const MVC_VIEW_ROUTER_MAPPINGS = [
		'GET /' => '/index.php',
		'GET /about' => '/about/index.php',
	];

	public function eveliktoMvcRouter($MVC_VIEW_ROUTER_MAPPINGS) {
		return new ViewRouter($MVC_VIEW_ROUTER_MAPPINGS);
	}

	// this is another possibility to initialize interfaces
	// full interface name will be converted to camel-case method name
	// \evelikto\mvc\Router translates to
	public function eveliktoMvcRouter() {
		// inside the config file ask for config values via static::
		return new ViewRouter(static::MVC_VIEW_ROUTER_MAPPINGS);
	}
}

// in your index.php:
$appContext = new \evelikto\di\AppContext(new AppConfig());
```
The big advantage of this approach is the full freedom how to decompose your configuration. It also allows you to define multiple configurations in natural ways through native PHP means. And the best news is - you pay absolutely nothing for it in terms of CPU cycles!
```PHP
// Extending base config class allows you to redefine values and factories
// for different environments.
class AppConfig {

	const PDO_HOSTNAME;
	const PDO_DATABASE;
	const PDO_USERNAME;
	const PDO_PASSWORD;

	/** @return \PDO */
	public function pdo() {
		$hostname = static::PDO_HOSTNAME;
		$database = static::PDO_DATABASE;
		$username = static::PDO_USERNAME;
		$password = static::PDO_PASSWORD;

		return new \PDO("mysql:host=$hostname;dbname=$database", $username, $password);
	}
}

class LocalConfig extends AppConfig {
	const PDO_HOSTNAME = 'local_host';
	const PDO_DATABASE = 'local_db';
	const PDO_USERNAME = 'local_dbo';
	const PDO_PASSWORD = 'local_pwd';
}

class CloudConfig extends AppConfig {
	const PDO_HOSTNAME = 'cloud_host';
	const PDO_DATABASE = 'cloud_db';
	const PDO_USERNAME = 'cloud_dbo';
	const PDO_PASSWORD = 'cloud_pwd';
}

// in your index.php:
$config = IS_CLOUD ? new CloudConfig : new LocalConfig;
$appContext = new \evelikto\di\AppContext($config);

// you may also put a number of config values into an interface
interface CloudDatabaseConsts {
	const PDO_HOSTNAME = 'cloud_host';
	const PDO_DATABASE = 'cloud_db';
	const PDO_USERNAME = 'cloud_dbo';
	const PDO_PASSWORD = 'cloud_pwd';
}

class CloudConfig extends AppConfig implements CloudDatabaseConsts {
	// other cloud values and factories
}

// or just put parts of your configuration into a trait
trait MvcConfig {
	public function eveliktoMvcRouter() {
		return new ViewRouter([
			'GET /' => '/index.php',
			'GET /about' => '/about/index.php',
		]);
	}
}

trait DatabaseConfig {
	// yes, you can autowire config values!
	public function pdo($PDO_CONNECTION, $PDO_USERNAME, $PDO_PASSWORD) {
		return new \PDO($PDO_CONNECTION, $PDO_USERNAME, $PDO_PASSWORD);
	}
}

// combine the traits in your config class to keep it clean and maintainable.
class AppConfig {
	uses MvcConfig, DatabaseConfig;
}
```
Conclusion: 'class as config'-convention is extremely powerful, fast and easy to use.
