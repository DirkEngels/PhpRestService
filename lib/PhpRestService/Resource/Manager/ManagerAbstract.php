<?php

namespace PhpRestService\Resource\Manager;
use \PhpRestService\Resource\Display;

abstract class ManagerAbstract {

    protected $_name;
    protected $_id;

    protected $_data;
    protected $_display;
    protected $_format;

    protected $_request;
    protected $_response;

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    public function getData() {
        return $this->_data;
    }

    public function setData($data) {
        $this->_data = $data;
        return $this;
    }

    public function getDisplay() {
        return $this->_display;
    }

    public function setDisplay($display) {
        $this->_display = $display;
        return $this;
    }

    public function getFormat() {
        return $this->_format;
    }

    public function setFormat($format) {
        $this->_format = $format;
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
        try {
            $sourceData = $this->handleData();
            $displayData = $this->handleDisplay($sourceData);
        } catch (\Exception $exception) {
            $this->setDisplay(
                new \PhpRestService\Resource\Display\Exception()
            );
            $displayData = $this->handleDisplay($exception);
        }
        return $this->handleFormat($displayData);
    }

    protected function handleData() {
        if ($this->getId()) {
            $this->getData()->setId($this->getId());
        }
        return $this->getData()->handle();
    }

    protected function handleDisplay($sourceData = NULL) {
        if ($this->getId()) {
            $this->getDisplay()->setId($this->getId());
        }
        $display = $this->getDisplay()->handle($sourceData);

        return $display;
    }

    protected function handleFormat($displayData) {
        return $this->getFormat()->render($displayData);
    }

}
