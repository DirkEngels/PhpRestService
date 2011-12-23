<?php

namespace PhpRestService\Resource\Display;

class All extends DisplayAbstract implements DisplayInterface {

    public function dataBasic($object) {
        return static::dataExtended($object);
    }

    public function dataExtended($object) {
        $data = array();
        if (method_exists($object, 'toArray')) {
            $data = $object->toArray();
        }
        return $data;
    }

}