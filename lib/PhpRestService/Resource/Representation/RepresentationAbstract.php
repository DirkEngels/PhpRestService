<?php

namespace PhpRestService\Resource\Representation;

abstract class RepresentationAbstract {

    protected $_response;

    public function __construct($response) {
        $this->_response = $response;
    }

}
