<?php

namespace PhpRestService\Application\Bootstrap;

class Service extends ApplicationAbstract implements ApplicationInterface {

    public function _initRegistry() {
        require_once("Zend/Registry.php");
        $registry = Zend_Registry::getInstance();
    }

    public function _initErrorReporting() {
        // Set error_reporting
        error_reporting(E_ALL);
    }

    public function _initConstants() {
        // Set include paths
        define( 'PROJECT_ROOT', realpath(__DIR__ .'/../') );
        define( 'APPLICATION_PATH', realpath(\PROJECT_ROOT .'/app') );
        define( 'LIBRARY_PATH', realpath(\PROJECT_ROOT .'/lib') );

        // Define application environment: defaults to development!!!
        if ( ! defined('APPLICATION_ENV') ) {
            define( 'APPLICATION_ENV', 'development' );
        }
    }

    public function _initIncludePaths() {
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
    }

    public function _initAutoLoader() {
        // Custom Autoloader
        function __autoloadPhpRestService($className) {
            //    echo $GLOBALS['includePaths'];
            foreach($GLOBALS['includePaths'] as $path) {
                $classNamespaced = $path .'/' . str_replace('\\', '/', $className) . '.php';
                $classConvention = $path . '/' . str_replace('_','/',$className) . '.php';
                $classParent = $path . '/' . substr($className, 0, strrpos($className, '/')) . '.php';
                if (file_exists($classNamespaced)) {
                    //            echo $classNamespaced . "\n";
                    include_once ($classNamespaced);
                } elseif (file_exists($classConvention)) {
                    //            echo $classConvention . "\n";
                    include_once($classConvention);
                } elseif (file_exists($classParent)) {
                    //            echo $classParent . "\n";
                    include_once($classParent);
                } else {
                    //            echo "Dynno\n";
                }
            }
        }
        spl_autoload_register( '__autoloadPhpRestService' );
    }

    public function _initCustomHacks() {
        include(LIBRARY_PATH . '/PhpRestService/Resource/Data/DataAbstract.php');
        include(LIBRARY_PATH . '/PhpRestService/Resource/Data/DataInterface.php');
        include(LIBRARY_PATH . '/PhpRestService/Resource/Data/Collection.php');
        include(LIBRARY_PATH . '/PhpRestService/Resource/Data/Item.php');

        //include(LIBRARY_PATH . '/PhpRestService/Resource/Collection/CollectionAbstract.php');
        //include(LIBRARY_PATH . '/PhpRestService/Resource/Collection/CollectionInterface.php');

        //include(LIBRARY_PATH . '/PhpRestService/Resource/Format/FormatAbstract.php');
        //include(LIBRARY_PATH . '/PhpRestService/Resource/Format/FormatInterface.php');
        include(LIBRARY_PATH . '/PhpRestService/Resource/Format/Json.php');
        //include(LIBRARY_PATH . '/PhpRestService/Resource/Format/Xml.php');

        include(APPLICATION_PATH . '/domain/logic/blog/Post.php');
        include(APPLICATION_PATH . '/domain/logic/blog/Member.php');
        include(APPLICATION_PATH . '/domain/logic/blog/Comment.php');

        include(APPLICATION_PATH . '/domain/model/blog/Post.php');
        include(APPLICATION_PATH . '/domain/model/blog/Member.php');
        include(APPLICATION_PATH . '/domain/model/blog/Comment.php');

        //include(APPLICATION_PATH . '/service/daemon/single/daemon/Collection.php');
        //include(APPLICATION_PATH . '/service/daemon/single/task/Item.php');

        include(APPLICATION_PATH . '/service/blog/post/Display.php');
        include(APPLICATION_PATH . '/service/blog/post/Collection.php');
        include(APPLICATION_PATH . '/service/blog/post/Item.php');
    }

    public function _initDoctrine() {
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
    }

}
