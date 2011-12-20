<?php

// Set error_reporting
error_reporting(E_ALL);

// Set include paths
define('PROJECT_ROOT', realpath(__DIR__ .'/../'));
define('APPLICATION_PATH', realpath(\PROJECT_ROOT .'/app'));
define('LIBRARY_PATH', realpath(\PROJECT_ROOT .'/lib'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Include Paths
$includePaths = array(
    get_include_path(),
    \APPLICATION_PATH,
    \LIBRARY_PATH, 
    '/usr/share/php/libzend-framework-php/'
);
set_include_path(
    implode(
        PATH_SEPARATOR,
        $includePaths
    )
);


// Custom Autoloader
function __autoloadPhpRestService($className) {
//	echo $GLOBALS['includePaths'];
	foreach($GLOBALS['includePaths'] as $path) {
		$classNamespaced = $path .'/' . str_replace('\\', '/', $className) . '.php';
		$classConvention = $path . '/' . str_replace('_','/',$className) . '.php';
		$classParent = $path . '/' . substr($className, 0, strrpos($className, '/')) . '.php';
		if (file_exists($classNamespaced)) {
//			echo $classNamespaced . "\n";
			include_once ($classNamespaced);
		} elseif (file_exists($classConvention)) {
//			echo $classConvention . "\n";
			include_once($classConvention);
		} elseif (file_exists($classParent)) {
//			echo $classParent . "\n";
			include_once($classParent);
		} else {
//			echo "Dynno\n";
		}
	}
}
spl_autoload_register('__autoloadPhpRestService');


// Doctrine 2 instantiation
$config = new \Doctrine\ORM\Configuration();
$proxydir = APPLICATION_PATH . "/domain/proxies";
if (!is_dir($proxydir)) {
    mkdir($proxydir, 0777, true);
}
$config->setProxyDir($proxydir);
$config->setProxyNamespace('App\\Domain\\Proxies');
$config->setAutoGenerateProxyClasses(true);

$driverImpl = $config->newDefaultAnnotationDriver(APPLICATION_PATH . "/domain/model/");
$config->setMetadataDriverImpl($driverImpl);

$cache = new \Doctrine\Common\Cache\ArrayCache();
$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);

$connection = array(
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'user' => 'phprestservice',
    'password' => 'phprestservice',
    'dbname' => 'phprestservice'
);

$registry->entityManager = \Doctrine\ORM\EntityManager::create(
    $connection, $config
);


include(LIBRARY_PATH . '/PhpRestService/Resource/Item/ItemAbstract.php');
include(LIBRARY_PATH . '/PhpRestService/Resource/Item/ItemInterface.php');

include(LIBRARY_PATH . '/PhpRestService/Resource/Collection/CollectionAbstract.php');
include(LIBRARY_PATH . '/PhpRestService/Resource/Collection/CollectionInterface.php');

//include(LIBRARY_PATH . '/PhpRestService/Resource/Representation/RepresentationAbstract.php');
//include(LIBRARY_PATH . '/PhpRestService/Resource/Representation/RepresentationInterface.php');
include(LIBRARY_PATH . '/PhpRestService/Resource/Representation/Json.php');
//include(LIBRARY_PATH . '/PhpRestService/Resource/Representation/Xml.php');

include(APPLICATION_PATH . '/service/daemon/single/daemon/Collection.php');
include(APPLICATION_PATH . '/service/daemon/single/task/Item.php');

