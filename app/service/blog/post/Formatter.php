<?php

namespace App\Service\Blog\Post;

class Formatter extends \PhpRestService\Resource\Formatter\FormatterAbstract implements \PhpRestService\Resource\Formatter\FormatterInterface {

    public static function dataBasic($object) {
        $data = array(
            'date' => $object->getDateCreated(),
            'title' => $object->getTitle(),
        );
        return $data;
    }

    public static function dataExtended($object) {
        $extended = array(
            'content' => $object->getContent(),
            'comments' => $object->getComments(),
        );
        return $extended;
    }

}
