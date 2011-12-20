<?php

namespace PhpRestService\Application;

use PhpRestService\Http;
use PhpRestService\Resource;
use PhpRestService\Resource\Representation;

class Service extends ApplicationAbstract implements ApplicationInterface {

    protected $_request;
    protected $_response;


    protected function _loadResource() {
        // Demo Resource: Task
        $item = new \App\Service\Daemon\Single\Task\Item();
        $collection = new \App\Service\Daemon\Single\Daemon\Collection();

        // Demo Resource: Blog Post
        $item = new \App\Service\Blog\Post\Item();
        $collection = new \App\Service\Blog\Post\Collection();

        $resource = new \PhpRestService\Resource\ResourceDefault();
        $resource->setItem($item);
        $resource->setCollection($collection);

        if (preg_match('#blog/post#', ($_SERVER['REQUEST_URI']))) {
            $resource->setId('34');
        }

        \PhpRestService\Logger::get()->log('Loaded resource: GET: ' . get_class($resource), \Zend_Log::INFO);

        return $resource;
    }

    protected function _detectRoute() {
        \PhpRestService\Logger::get()->log('Detecting route: ' . $_SERVER['REQUEST_METHOD'] . ': ' . $_SERVER['REQUEST_URI'], \Zend_Log::INFO);
    }

    protected function _renderOutput($resource) {
        \PhpRestService\Logger::get()->log('Rendering resource: GET: ' . get_class($resource), \Zend_Log::INFO);

        // Representation
        $format = (isset($_REQUEST['format'])) ? $_REQUEST['format'] : 'json';
        $response = new \PhpRestService\Http\Response();
        switch ($format) {
            case 'xml':
                $representation = new Representation\Xml($response);
                break;
            case 'json':
            default:
                $representation = new Representation\Json($response);
                break;
        }
        try {
            $data = $resource->handle();
        } catch (\Exception $e) {
            $data = array(
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            );
        }
        $this->_response = $representation->render($data);

    }

    public function run() {
        // Initialize Configuration
        $this->_initConfig();

        // Add Log Files
        $this->_initLogFile();

        // Detect Route
        $this->_detectRoute();

        // Load resource
        $resource = $this->_loadResource();

        // Init representation
        $this->_renderOutput($resource);

        return $this->_response->send();
    }

}
