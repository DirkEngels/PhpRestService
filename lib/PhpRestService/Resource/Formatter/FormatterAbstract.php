<?php

namespace PhpRestService\Resource\Formatter;

abstract class FormatterAbstract {

    public static function dataUrl($object) {
        $data = array();
        $id = $object->getId();
        if (empty($id)) {
            $data = array (
                'id' => $object->getId(),
                'url' => 'http://' . $_SERVER['SERVER_NAME'] . '/blog/post/' . $object->getId(),
            );
        }
        return $data;
    }

    public static function formatItem($object, $extended = false) {
        // Basic data
        $data = array_merge(
            static::dataUrl($object), 
            static::dataBasic($object)
        );

        if ($extended) {
            $data = array_merge($data, static::dataExtended($object));
        }

        return $data;
    }

    public static function formatCollection($objects, $extended = false) {
        $data = array();
        foreach($objects as $object) {
            $data[] = static::formatItem($object, $extended);
        }
        return $data;
    }

}
