<?php

namespace PhpRestService\Resource\Display;

class Fields extends DisplayAbstract implements DisplayInterface {

    public $_fieldsSimple = array(
        'date', 'name', 'title', 
    );
    public $_fieldsExtended = array(
        'content',
    );

    public function dataBasic($object) {
        $data = array(
            'code' => $object->getCode(),
            'message' => $object->getMessage(),
        );
        return $data;
    }

    public function dataExtended($object) {
        $extended = array(
            'line' => $object->getLine(),
            'file' => $object->getFile(),
            'trace' => $object->getTrace(),
        );
        return $extended;
    }

}