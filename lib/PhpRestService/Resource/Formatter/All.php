<?php

namespace PhpRestService\Resource\Formatter;

class All extends FormatterAbstract implements FormatterInterface {

    protected static function dataBasic($object) {
        return static::dataExtended($object);
    }

    protected static function dataExtended($object) {
        $data = array();
        if (method_exists($object, 'toArray')) {
            $data = $object->toArray();
        }
        return $data;
    }

}