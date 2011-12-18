<?php

namespace PhpRestService\Application;

use PhpRestService\Http;
use PhpRestService\Resource;
use PhpRestService\Resource\Representation;

class Service {

    protected $_request;
    protected $_response;

    protected function _initResource() {
        // Resource
        if (preg_match('/task/', ($_SERVER['REQUEST_URI']))) {
            // Initialize hard coded resource
            $resource = new \App\Service\Daemon\Single\Task\Item($this->_request, $this->_response);

        } else {
            $resource = new \App\Service\Daemon\Single\Daemon\Collection($this->_request, $this->_response);
        }
        return $resource;
    }

    protected function _detectRoute() {
        
    }

    protected function _renderOutput($resource) {
        // Representation
        $format = (isset($_REQUEST['format'])) ? $_REQUEST['format'] : 'json';
        switch ($format) {
            case 'xml':
                $representation = new Representation\Xml($this->_response);
                break;
            case 'json':
            default:
                $representation = new Representation\Json($this->_response);
                break;
        }
        $this->_response = $representation->render($resource->get());

    }

    public function run() {
        // Get Request
        $this->_request = new Http\Request();

        // Init response
        $this->_response = new Http\Response();

        // Init resource
        $resource = $this->_initResource($this->_response);

        // Init representation
        $this->_renderOutput($resource);

        return $this->_response->send();
    }

}
