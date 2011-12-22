<?php

namespace PhpRestService\Resource\Formatter;

class All extends FormatterAbstract implements FormatterInterface {

    public static function dataBasic($object) {
        return static::dataExtended($object);
    }

    public static function dataExtended($object) {
        $data = array();
        if (method_exists($object, 'toArray')) {
            $data = $object->toArray();
        }
        return $data;
    }

}