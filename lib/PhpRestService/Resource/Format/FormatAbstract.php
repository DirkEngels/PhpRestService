<?php

namespace PhpRestService\Resource\Format;

abstract class FormatAbstract {

    protected $_response;

    public function __construct() {
        $this->_response = new \PhpRestService\Http\Response();
    }

    public function getResponse() {
        return $this->_response;
    }

    public function setResponse($response) {
        $this->_respnse = $response;
        return $this;
    }
}
