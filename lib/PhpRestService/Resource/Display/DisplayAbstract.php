<?php

namespace PhpRestService\Resource\Display;

abstract class DisplayAbstract {

    public function dataUrl($object) {
        $data = array();
        if (method_exists($object, 'getId')) {
            $id = $object->getId();
            if (empty($id)) {
                $data = array (
                    'id' => $object->getId(),
                    'url' => 'http://' . $_SERVER['SERVER_NAME'] . '/blog/post/' . $object->getId(),
                );
            }
        }
        return $data;
    }

    public function displayItem($object, $extended = false) {
        // Basic data
        $data = array_merge(
            $this->dataUrl($object), 
            $this->dataBasic($object)
        );

        if ($extended) {
            $data = array_merge($data, $this->dataExtended($object));
        }

        return $data;
    }

    public function displayCollection($objects, $extended = false) {
        $data = array();
        foreach($objects as $object) {
            $data[] = $this->displayItem($object, $extended);
        }
        return $data;
    }

}
