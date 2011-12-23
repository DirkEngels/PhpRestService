<?php

namespace PhpRestService\Resource\Format;

abstract class FormatAbstract {

    protected $_response;

    public function __construct($response) {
        $this->_response = $response;
    }

}
