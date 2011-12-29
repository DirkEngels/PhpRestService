<?php

namespace PhpRestService\Resource\Format;

class Json extends FormatAbstract implements FormatInterface {

    public function parse($string) {
        return \Zend_Json::decode($string);
    }

    public function render($data) {
        $this->getResponse()
            ->setCode(200)
            ->addHeader('Content-type', 'application/json')
            ->setBody(
                \Zend_Json::encode($data)
            );
    }

}