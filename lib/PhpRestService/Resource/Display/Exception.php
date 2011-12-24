<?php

namespace PhpRestService\Resource\Display;

class Exception extends DisplayAbstract implements DisplayInterface {

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

    public function handle($inputData = array(), $extended = NULL) {
        return parent::displayItem($inputData);
    }

}