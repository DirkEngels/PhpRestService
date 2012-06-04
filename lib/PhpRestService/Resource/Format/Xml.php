<?php

namespace PhpRestService\Resource\Format;

class Xml extends FormatAbstract implements FormatInterface {

    public function parse($string) {
        throw new \PhpRestService\Exception\NotYetImplemented('No XML input parsing implemented yet!');
    }

    public function render($data) {
        $xml = new \SimpleXMLElement('<root/>');
        $xml = $this->_appendArray($data, $xml);

        $this->getResponse()
            ->addHeader('Content-type', 'application/xml')
            ->setBody($xml->asXML());
    }

    protected function _appendArray(array $data, \SimpleXMLElement $xml) {
        foreach ($data as $key => $value) {
            // Prefix key, when starting with a number
            if (preg_match('/^[0-9]/', $key)) {
                $key = 'obj' . $key;
            }

            // Recursively add child elements
            if ($value instanceof \DateTime) {
                $value = $value->format('Y-m-d H:i:s');
            }

            is_array($value)
                ? $this->_appendArray($value, $xml->addChild($key))
                : $xml->addChild($key, $value);
        }
        return $xml;
    }

}