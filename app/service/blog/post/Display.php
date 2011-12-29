<?php

namespace App\Service\Blog\Post;
use \PhpRestService\Resource\Display as ResourceDisplay;

class Display extends ResourceDisplay\DisplayAbstract implements ResourceDisplay\DisplayInterface {

    public function dataBasic($object) {
        if (!is_object($object)) {
            throw new \Exception('Display input is not an object!', 404);
        }
        $data = array(
            'id' => $object->getId(),
            'title' => $object->getTitle(),
            'date' => $object->getDateCreated(),
        );
        return $data;
    }

    public function dataExtended($object) {
        $extended = array(
            'content' => $object->getContent(),
            'comments' => $object->getComments(),
        );
        return $extended;
    }

}
