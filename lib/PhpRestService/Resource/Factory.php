<?php
namespace PhpRestService\Resource;

class Factory {
    const TYPE_MANAGER          = 'manager';
    const TYPE_AUTH             = 'auth';
    const TYPE_COLLECTION       = 'collection';
    const TYPE_ITEM             = 'item';
    const TYPE_DISPLAY          = 'display';
    const TYPE_FORMAT           = 'format';

    /**
     * Instantiates a new Manager object and injects all needed components 
     * based on the class definitions, configurations settings and defaults.
     * @param $resourceName
     * @return \PhpRestService\Resource\Manager\ManagerAbstract
     */
    public static function get($resourceName, $resourceKey = NULL) {
        $msg = 'FACTORY: Getting resource: ' . $resourceName;
        \PhpRestService\Logger::log($msg, \Zend_Log::DEBUG);
        \PhpRestService\Logger::log('----------', \Zend_Log::DEBUG);

        // Base Manager
        $manager = self::getManager($resourceName);

        // Auth component
        $manager->setAuth(
            self::getAuth($resourceName, $resourceKey)
        );

        // Data components
        $manager->setCollection(
            self::getDataCollection($resourceName)
        );
        $manager->setItem(
            self::getDataItem($resourceName, $resourceKey)
        );

        // Display component
        $manager->setDisplay(
            self::getDisplay($resourceName, $resourceKey)
        );

        // Format component
        $manager->setFormat(
            self::getFormat($resourceName)
        );

        \PhpRestService\Logger::log('----------', \Zend_Log::DEBUG);
        return $manager;
    }


    /**
     * Returns an object of the specified objectType based on the resourceName.  
     * @param string $resourceName
     * @param string $objectType
     * @return stdClass
     */
    public static function getComponentType($resourceName, $objectType) {
        $object = self::_getRequestArgs($resourceName, $objectType);

        if (!is_object($object)) {
            $object = self::_getRequestHeader($resourceName, $objectType);
        }

        if (!is_object($object)) {
            // First: Check if the class has been overloaded
            $object = self::_getObjectClass($resourceName, $objectType);
        }

        if (!is_object($object)) {
            // Second: Check configuration
            $object = self::_getObjectConfig($resourceName, $objectType);
        }

        if (!is_object($object)) {
            // Finally: Try the hard code default
            $object = self::_getObjectDefault($resourceName, $objectType);
        }

        return $object;
    }


    /**
     * Returns the manager timer for the specified resource
     * @param string $resourceName
     * @return \PhpRestService\Resource\Manager\ManagerAbstract
     */
    public static function getManager($resourceName) {
        $manager = self::getComponentType($resourceName, self::TYPE_MANAGER);
        $manager->setName($resourceName);
        return $manager;
    }


    /**
     * Returns the auth component for the specified resource
     * @param string $resourceName
     * @return \PhpRestService\Resource\Auth\AuthAbstract
     */
    public static function getAuth($resourceName, $id = NULL) {
        $display = self::getComponentType($resourceName, self::TYPE_AUTH);
        if (!is_null($id)) {
            $display->setId($id);
        }
        return $display;
    }


    /**
     * Returns the manager data collection for the specified resource
     * @param string $resourceName
     * @return \PhpRestService\Resource\Data\DataAbstract
     */
    public static function getDataCollection($resourceName) {
        return self::getComponentType($resourceName, self::TYPE_COLLECTION);
    }

    /**
     * Returns the manager data item for the specified resource
     * @param string $resourceName
     * @return \PhpRestService\Resource\Data\DataAbstract
     */
    public static function getDataItem($resourceName, $id = NULL) {
        $item = self::getComponentType($resourceName, self::TYPE_ITEM);
        if (!is_null($id)) {
            $item->setId($id);
        }
        return $item;
    }

    /**
     * Returns the manager timer for the specified resource
     * @param string $resourceName
     * @return \PhpRestService\Resource\Display\DisplayAbstract
     */
    public static function getDisplay($resourceName, $id = NULL) {
        $display = self::getComponentType($resourceName, self::TYPE_DISPLAY);
        if (!is_null($id)) {
            $display->setId($id);
        }
        return $display;
    }


    /**
     * Returns the manager timer for the specified resource
     * @param string $resourceName
     * @return \PhpRestService\Resource\Format\FormatAbstract
     */
    public static function getFormat($resourceName) {
        return self::getComponentType($resourceName, self::TYPE_FORMAT);
    }


    /**
     * Returns the classname based on the resourceName and objectType
     * @param string $resourceName
     * @param string $objectType
     * @return string
     */
    public static function _getClassName($resourceName, $objectType) {
        return \PhpRestService\Config::get()->getOptionValue('global.namespace') . '\\'. str_replace('/', '\\', $resourceName) . '\\' . ucfirst($objectType);
    }


    protected static function _getRequestHeader($resourceName, $objectType) {
        $object = NULL;
        if ($objectType == self::TYPE_FORMAT) {
            $request = new \PhpRestService\Http\Request();
            $formats = $request->getAcceptFormats();
            $accepts = array('json', 'xml');
            foreach($formats as $format) {
                if (in_array($format['sub_type'], $accepts)) {
                    $formatClass = '\\PhpRestService\\Resource\\Format\\' . ucfirst($format['sub_type']);
                    $object = new $formatClass();
                }
            }
        // Overrride!!!
        $formatClass = '\\PhpRestService\\Resource\\Format\\Json';
        $object = new $formatClass();

        }
        return $object;
    }


    protected static function _getRequestArgs($resourceName, $objectType) {
        $object = NULL;
        if ($objectType == self::TYPE_FORMAT) {
            if (!empty($_REQUEST['format'])) {
            	
                $accepts = array('json', 'xml');
                if (in_array($_REQUEST['format'], $accepts)) {
                    $formatClass = '\\PhpRestService\\Resource\\Format\\' . ucfirst($_REQUEST['format']);
                    $object = new $formatClass();
                }
            }
        }
        return $object;
    }

    /**
     * Returns the config name based on the resource name.
     * @param unknown_type $objectType
     */
    protected static function _getConfigName($resourceName) {
        return strtolower(str_replace('\\', '.', $resourceName));
    }


    /**
     * Checks if a objectType class of a specific manager exists
     * @param string $resourceName
     * @param string $objectType
     * @return null|stdClass
     */
    protected static function _getObjectClass($resourceName, $objectType) {
        $className = self::_getClassName($resourceName, $objectType);
        $className = str_replace('\\\\', '\\', $className);

        $msg = 'FACTORY: Trying ' . $objectType . ' class component: ' . $className;
        \PhpRestService\Logger::log($msg, \Zend_Log::DEBUG);

        if (class_exists($className)) {
            $msg = 'FACTORY: Found ' . $objectType . ' class component: ' . $className;
            \PhpRestService\Logger::log($msg, \Zend_Log::NOTICE);
            return new $className();
        }
        return NULL;
    }


    /**
     * Checks if resource specific configuration options for the objectType are
     * set.
     * @param string $resourceName
     * @param string $objectType
     * @return null|stdClass
     */
    protected static function _getObjectConfig($resourceName, $objectType) {
        $msg = 'FACTORY: Trying ' . $objectType . ' config component: ' . $resourceName;
        \PhpRestService\Logger::log($msg, \Zend_Log::DEBUG);

        $configType = ucfirst(
            \PhpRestService\Config::get()->getOptionValue(
                strtolower($objectType) . '.default', 
                $resourceName
            )
        );

        $nameSpace = \PhpRestService\Config::get()->getOptionValue(
            'global.namespace'
        );

        $objectClassName = self::_getObjectConfigNamespace($objectType) . '\\' . $configType;

//        $msg = 'FACTORY: Testing class (' . $resourceName . '): ' . $objectClassName;
        \PhpRestService\Logger::log($msg, \Zend_Log::DEBUG);

        if (class_exists($objectClassName, true)) {
            $msg = 'FACTORY: Found ' . $objectType . ' config component: ' . $resourceName;
            \PhpRestService\Logger::log($msg, \Zend_Log::NOTICE);
            $object = new $objectClassName();
            return $object;
        }

        return NULL;
    }


    protected static function _getObjectConfigNamespace($objectType) {
        $nameSpace = '\\PhpRestService\\Resource\\';
        switch($objectType) {
            case 'collection':
                $nameSpace .= 'Data';
                break;
            case 'item':
                $nameSpace .= 'Data';
                break;
            case 'display':
                $nameSpace .= 'Display';
                break;
            case 'format':
                $nameSpace .= 'Format';
                break;
            case 'manager':
            default:
                $nameSpace .= 'Manager';
                break;
        }
        return $nameSpace;
    }


    /**
     * Returns the hardcoded default object for a specific type.
     * @param string $objectType
     * @return null|StdClass
     */
    public static function _getObjectDefault($resourceName, $objectType) {
        $msg = 'FACTORY: Defaulting ' . $objectType . ' component: ' . $resourceName . ' => Default';
        \PhpRestService\Logger::log($msg, \Zend_Log::DEBUG);

        switch($objectType) {
            case 'auth':
                return new \PhpRestService\Resource\Auth\None();
            case 'collection':
                return new \PhpRestService\Resource\Data\Collection();
            case 'item':
                return new \PhpRestService\Resource\Data\Item();
            case 'display':
                return new \PhpRestService\Resource\Display\All();
            case 'format':
                return new \PhpRestService\Resource\Format\Json();
            case 'manager':
            default:
                return new \PhpRestService\Resource\Manager\ManagerDefault();
        }
        throw new Exception\UndefinedObjectType('Unknown object type: ' . $objectType);

        return NULL;
    }

}
