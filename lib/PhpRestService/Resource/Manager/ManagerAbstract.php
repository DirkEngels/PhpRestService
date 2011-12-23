<?php

namespace PhpRestService\Resource\Manager;

abstract class ManagerAbstract {

    protected $_formatter;
    protected $_collection;
    protected $_item;
    protected $_id;

    protected $_request;
    protected $_response;

    public function __construct() {
        
    }

    public function getFormatter() {
        return $this->_formatter;
    }

    public function setFormatter($formatter) {
        $this->_formatter = $formatter;
        return $this;
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
        $data = array();
        try {
            // Return item, if an ID has been provided
            if ($this->getId()) {
                $item = $this->getItem();
                if (!is_null($item)) {
                    $item->setId($this->getId());
                    $object = $item->handle();
                    $data = $this->getFormatter()->formatItem($object);
                }
            }

            // Return collection
            $collection = $this->getCollection();
            if (!is_null($collection)) {
                $objects = $collection->handle();
                $data = $this->getFormatter()->formatCollection($objects);
            }

            // No collection found & no item id provided, throw exception
            if ($data === array()) {
                throw new \Exception('Resource not found!', 404);
            }
        } catch (\Exception $e) {
            $formatter = new Formatter\Exception();
            $data = $formatter->formatItem($e);
        }

        return $data;
    }
}
