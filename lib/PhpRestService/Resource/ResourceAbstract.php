<?php

namespace PhpRestService\Resource;

abstract class ResourceAbstract {

    protected $_collection;
    protected $_item;
    protected $_id;

    protected $_input;
    protected $_output;

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

    public function getInput() {
        return $this->_input;
    }

    public function setInput($input) {
        $this->_input = $input;
        return $this;
    }

    public function getOutput() {
        return $this->_output;
    }

    public function setOutput($output) {
        $this->_output = $output;
        return $this;
    }

    public function handle() {
        if ($this->getId()) {
            return $this->getItem()->handle();
        }
        return $this->getCollection()->handle();
    }
}
