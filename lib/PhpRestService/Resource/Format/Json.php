<?php

namespace PhpRestService\Resource\Format;

class Json extends FormatAbstract implements FormatInterface {

    public function render($data) {
        $this->_response->setCode(200);
        $this->_response->addHeader('Content-type', 'application/json');
        $this->_response->setBody(
            \Zend_Json::encode($data)
        );

        return $this->_response;
    }

}