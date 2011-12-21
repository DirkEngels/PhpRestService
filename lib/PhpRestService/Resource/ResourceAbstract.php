<?php

namespace PhpRestService\Resource;

abstract class ResourceAbstract {

    protected $_collection;
    protected $_item;
    protected $_id;

    protected $_request;
    protected $_response;

    public function __construct() {
        
    }

    public function getCollection() {
        return $this->_collection;
    }

    public function setCollection($collection) {
        $this->_collection = $collection;
        return $this;
    }

    public function getItem() {
        return $this->_item;
    }

    public function setItem($item) {
        $this->_item = $item;
        return $this;
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

    public function handle() {
        if ($this->getId()) {
            return $this->getItem()->setId($this->getId())->handle();
        }
        return $this->getCollection()->handle();
    }
}
