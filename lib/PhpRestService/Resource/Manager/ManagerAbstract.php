<?php

namespace PhpRestService\Resource\Manager;
use \PhpRestService\Resource\Component;
use \PhpRestService\Resource\Display;

abstract class ManagerAbstract extends Component\ComponentAbstract {

    protected $_name;

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

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
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

    public function handle($id = NULL) {
        if (!is_null($id)) {
            $this->setId($id);
        }

        $output = '';
        $data = $this->_handleData();
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'DELETE':
                break;
            case 'GET':
            default:
                try {
                    $displayData = $this->_handleDisplay($data);
                } catch (\Exception $exception) {
                    $this->setDisplay(
                        new \PhpRestService\Resource\Display\Exception()
                    );
                    $displayData = $this->_handleDisplay($exception);
                }
                $this->_handleFormat($displayData);
        }
        return $this->getResponse();
    }

    protected function _handleData() {
        if ($this->getId()) {
            $this->getItem()
                ->setRequest($this->getRequest())
                ->setResponse($this->getResponse())
                ->setId($this->getId());
            return $this->getItem()->handle();
        }
        $this->getCollection()
            ->setRequest($this->getRequest())
            ->setResponse($this->getResponse());
        return $this->getCollection()->handle();
    }

    protected function _handleDisplay($sourceData = NULL) {
        if ($this->getId()) {
            $this->getDisplay()->setId($this->getId());
        }
        $this->getDisplay()
            ->setRequest($this->getRequest())
            ->setResponse($this->getResponse());

        $display = $this->getDisplay()->handle($sourceData);

        return $display;
    }

    protected function _handleFormat($displayData) {
        $this->getFormat()
            ->setRequest($this->getRequest())
            ->setResponse($this->getResponse());

        return $this->getFormat()->render($displayData);
    }

}
