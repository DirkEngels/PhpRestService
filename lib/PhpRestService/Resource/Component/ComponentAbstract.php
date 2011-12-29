<?php

namespace PhpRestService\Resource\Component;

abstract class ComponentAbstract {

    protected $_id;
    protected $_request;
    protected $_response;

    public function __construct($request = NULL, $response = NULL, $id = NULL) {
        // Init Request
        if (is_null($request)) {
            $request = new \PhpRestService\Http\Request();
        }
        $this->setRequest($request);

        // Init Response
        if (is_null($response)) {
            $response = new \PhpRestService\Http\Response();
        }
        $this->setResponse($response);

        // Set Id
        if (!is_null($id)) {
            $this->setId($id);
        }
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    public function getRequest() {
        return $this->_request;
    }

    public function setRequest($request) {
        $this->_request = $request;
        return $this;
    }

    public function getResponse() {
        return $this->_response;
    }

    public function setResponse($response) {
        $this->_response = $response;
        return $this;
    }
}
