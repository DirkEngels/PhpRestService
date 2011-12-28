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
            $router->getResource()
        );
        return $resourceManager;
    }


    protected function _detectRoute() {
        \PhpRestService\Logger::get()->log('Detecting route: ' . $_SERVER['REQUEST_METHOD'] . ': ' . $_SERVER['REQUEST_URI'], \Zend_Log::INFO);
        $router = new \PhpRestService\Application\Router\Resource($_SERVER['REQUEST_URI']);

        return $router;
    }


    public function run() {
        $this->_init();

        // Detect Route
        $route = $this->_detectRoute();

        // Load resource
        $resource = $this->_loadResource($route);
        $response = $resource->handle();
        $response->send();
    }

}
