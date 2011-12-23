<?php

namespace PhpRestService\Resource\Representation;

class Json extends RepresentationAbstract implements RepresentationInterface {

    public function render($data) {
        $this->_response->setCode(200);
        $this->_response->addHeader('Content-type', 'application/json');
        $this->_response->setBody(
            \Zend_Json::encode($data)
        );

        return $this->_response;
    }

}