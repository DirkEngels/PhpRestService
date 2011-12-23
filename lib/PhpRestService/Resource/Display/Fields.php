<?php

namespace PhpRestService\Resource\Formatter;

class Fields extends FormatterAbstract implements FormatterInterface {

    public $_fieldsSimple = array(
        'date', 'name', 'title', 
    );
    public $_fieldsExtended = array(
        'content',
    );

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