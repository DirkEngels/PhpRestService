<?php

namespace PhpRestService\Resource\Representation;

class Xml extends RepresentationAbstract implements RepresentationInterface {

    public function render($data) {
        $this->_response->addHeader('Content-type', 'application/xml');

        $xml = new \SimpleXMLElement('<root/>');
        $xml = $this->appendArray($data, $xml);
        $this->_response->setBody($xml->asXML());
        
        return $this->_response;
    }

    function appendArray(array $data, \SimpleXMLElement $xml) {
        foreach ($data as $key => $value) {
            // Prefix key, when starting with a number
            if (preg_match('/^[0-9]/', $key)) {
                $key = 'obj' . $key;
            }

            // Recursively add child elements
            is_array($value)
                ? $this->appendArray($value, $xml->addChild($key))
                : $xml->addChild($key, $value);
        }
        return $xml;
    }

}