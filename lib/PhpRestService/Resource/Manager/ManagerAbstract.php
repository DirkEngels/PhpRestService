<?php

namespace PhpRestService\Resource\Manager;
use \PhpRestService\Logger;
use \PhpRestService\Resource\Component;
use \PhpRestService\Resource\Display;

abstract class ManagerAbstract extends Component\ComponentAbstract {

    protected $_name;

    protected $_auth;
    protected $_collection;
    protected $_item;
    protected $_display;
    protected $_format;

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
        return $this;
    }

    public function getAuth() {
        return $this->_auth;
    }

    public function setAuth($auth) {
        $this->_auth = $auth;
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

    public function handle($id = NULL) {
        // Check authentification
        $this->getAuth()->authenticate();

        if (!is_null($id)) {
            $this->setId($id);
        }

        $displayData = array();
        try {
            // Data
            $output = '';
            $data = $this->_handleData();

            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT':
                case 'DELETE':
                    break;
                case 'GET':
                default:
                    // Display
                    $displayData = $this->_handleDisplay($data);
            }

            // Set response code if it hasn't been set
            if ($this->getResponse()->getCode() == NULL) {
                $this->getResponse()->setCode(200);
            }

        } catch (\Exception $exception) {
            $this->setDisplay(
                new \PhpRestService\Resource\Display\Exception()
            );
            $displayData = $this->_handleDisplay($exception);
            $this->getResponse()->setCode($exception->getCode());
        }

        // Format
        if (count($displayData) > 0) {
            $this->_handleFormat($displayData);
        }

        return $this->getResponse();
    }

    protected function _handleData() {
        if ($this->getId()) {
            $this->getItem()
                ->setId($this->getId());

            $this->_setRequestResponse($this->getItem());
            Logger::log("Manager: Running item: " . get_class($this->getItem()), \Zend_Log::DEBUG);
            $result = $this->getItem()->handle();
            $this->_updateRequestResponse($this->getItem());
            return $result;
        }

        $this->_setRequestResponse($this->getCollection());
        Logger::log("Manager: Running collection: " . get_class($this->getCollection()), \Zend_Log::DEBUG);
        $result = $this->getCollection()->handle();
        $this->_updateRequestResponse($this->getCollection());

        return $result;
    }

    protected function _handleDisplay($sourceData = NULL) {
        if ($this->getId()) {
            $this->getDisplay()->setId($this->getId());
        }
        $this->_setRequestResponse($this->getDisplay());

        $display = $this->getDisplay()->handle($sourceData);
        $this->_updateRequestResponse($this->getDisplay());

        return $display;
    }

    protected function _handleFormat($displayData) {
        $this->_setRequestResponse($this->getFormat());
        $format = $this->getFormat()->render($displayData);
        $this->_updateRequestResponse($this->getFormat());
        return $format;
    }


    protected function _setRequestResponse($object) {
        $object
            ->setRequest($this->getRequest())
            ->setResponse($this->getResponse());
    }

    protected function _updateRequestResponse($object) {
        $this->setRequest($object->getRequest());
        $this->setResponse($object->getResponse());
    }

}
