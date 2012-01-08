<?php

namespace PhpRestService\Application;

use PhpRestService\Http;
use PhpRestService\Resource;
use PhpRestService\Resource\Format;

class Service extends ApplicationAbstract implements ApplicationInterface {

    protected $_request;
    protected $_response;

    protected function _loadResource($router) {
        $resourceManager = \PhpRestService\Resource\Factory::get(
            $router->getResourceName()
        );
        if (!is_null($router->getResourceKey())) {
            $resourceManager->setId($router->getResourceKey());
        }
        // Set arguments
        $arguments = $router->getArguments();
        foreach($arguments as $argument => $value) {
            $method = 'set' . ucfirst($argument);
            \PhpRestService\Logger::get()->log('Testing resource collection argument method: ' . $argument . ': ' . $value, \Zend_Log::DEBUG);
            if (method_exists($resourceManager->getCollection(), $method)) {
                \PhpRestService\Logger::get()->log('Setting resource collection argument value: ' . $argument . ': ' . $value, \Zend_Log::DEBUG);
                $resourceManager->getCollection()->$method($value);
            }
            if (method_exists($resourceManager->getItem(), $method)) {
                \PhpRestService\Logger::get()->log('Setting resource item argument value: ' . $argument . ': ' . $value, \Zend_Log::DEBUG);
                $resourceManager->getItem()->$method($value);
            }
        }

        return $resourceManager;
    }


    protected function _detectRoute() {
        \PhpRestService\Logger::get()->log('Detecting route: ' . $_SERVER['REQUEST_METHOD'] . ': ' . $_SERVER['REQUEST_URI'], \Zend_Log::INFO);
        $router = new \PhpRestService\Application\Router\Resource($_SERVER['REQUEST_URI']);

        return $router;
    }


    public function run() {
        $this->_init();

        // Detect Route$device
        $route = $this->_detectRoute();

        // Load resource
        $resource = $this->_loadResource($route);
        $response = $resource->handle();
        $response->send();
    }

}
