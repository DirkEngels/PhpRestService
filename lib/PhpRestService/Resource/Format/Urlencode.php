<?php

namespace PhpRestService\Resource\Format;

class Urlencode extends FormatAbstract implements FormatInterface {

    public function parse($string) {
        $data = array();
        parse_str($string, $data);
        return $data;
    }

    public function render($data) {
        $this->getResponse()
            ->setCode(200)
            ->addHeader('Content-type', 'application/urlencode')
            ->setBody(
                http_build_query($data)
            );

        return $this->getResponse();
    }

}