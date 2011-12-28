<?php
namespace PhpRestService\Resource;

class Factory {
    const TYPE_MANAGER = 'manager';

    const TYPE_COLLECTION = 'collection';
    const TYPE_ITEM = 'item';
    const TYPE_DISPLAY = 'display';
    const TYPE_FORMAT = 'format';

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

        // Data
        $manager->setCollection(
            self::getComponentType($resourceName, self::TYPE_COLLECTION)
        );
        $manager->setItem(
            self::getManagerDataItem($resourceName, $resourceKey)
        );

        // Display
        $manager->setDisplay(
            self::getManagerDisplay($resourceName, $resourceKey)
        );

        // Format
        $manager->setFormat(
            self::getComponentType($resourceName, self::TYPE_FORMAT)
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
        // First: Check if the class has been overloaded
        $object = self::_getObjectClass($resourceName, $objectType);

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
     * Returns the manager data collection for the specified resource
     * @param string $resourceName
     * @return \PhpRestService\Resource\Manager\Data\DataAbstract
     */
    public static function getManagerDataCollection($resourceName) {
        return self::getComponentType($resourceName, self::TYPE_COLLECTION);
    }

    /**
     * Returns the manager data item for the specified resource
     * @param string $resourceName
     * @return \PhpRestService\Resource\Manager\Data\DataAbstract
     */
    public static function getManagerDataItem($resourceName, $id = NULL) {
        $item = self::getComponentType($resourceName, self::TYPE_ITEM);
        if (!is_null($id)) {
            $item->setId($id);
        }
        return $item;
    }

    /**
     * Returns the manager timer for the specified resource
     * @param string $resourceName
     * @return \PhpRestService\Resource\Manager\Display\DisplayAbstract
     */
    public static function getManagerDisplay($resourceName, $id = NULL) {
        $display = self::getComponentType($resourceName, self::TYPE_DISPLAY);
        if (!is_null($id)) {
            $display->setId($id);
        }
        return $display;
    }


    /**
     * Returns the manager timer for the specified resource
     * @param string $resourceName
     * @return \PhpRestService\Resource\Manager\Format\FormatAbstract
     */
    public static function getManagerFormat($resourceName) {
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
            case 'data':
                return new \PhpRestService\Resource\Data\Collection();
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
