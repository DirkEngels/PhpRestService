<?php

namespace PhpRestService\Resource\Formatter;

class Exception extends FormatterAbstract implements FormatterInterface {

    public static function dataBasic($object) {
        $data = array(
            'code' => $object->getCode(),
            'message' => $object->getMessage(),
        );
        return $data;
    }

    public static function dataExtended($object) {
        $extended = array(
            'line' => $object->getLine(),
            'file' => $object->getFile(),
            'trace' => $object->getTrace(),
        );
        return $extended;
    }

}