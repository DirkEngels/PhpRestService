<?php

namespace PhpRestService\Resource\Format;

class Xml extends FormatAbstract implements FormatInterface {

    public function parse($string) {
        throw new \Exception('No XML input parsing implemented yet!');
    }

    public function render($data) {
        $xml = new \SimpleXMLElement('<root/>');
        $xml = $this->_appendArray($data, $xml);

        $this->getResponse()
            ->addHeader('Content-type', 'application/xml')
            ->setBody($xml->asXML());

        return $this->getResponse();
    }

    protected function _appendArray(array $data, \SimpleXMLElement $xml) {
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