<?php

namespace PhpRestService\Resource\Format;

abstract class FormatAbstract {

    protected $_response;

    public function __construct() {
        $this->_response = new \PhpRestService\Http\Response();
    }

}
