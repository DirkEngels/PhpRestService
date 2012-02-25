<?php

namespace PhpRestService\Application\Router;

abstract class RouterAbstract {

    protected $_url;

    public function __construct($url) {
        $this->setUrl($url);
    }

    public function getUrl() {
        return $this->_url;
    }

    public function setUrl($url) {
        $this->_url = $url;
        return $this;
    }

}