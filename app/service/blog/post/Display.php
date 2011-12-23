<?php

namespace App\Service\Blog\Post;

class Display extends \PhpRestService\Resource\Display\DisplayAbstract implements \PhpRestService\Resource\Display\DisplayInterface {

    public function dataBasic($object) {
        $data = array(
            'date' => $object->getDateCreated(),
            'title' => $object->getTitle(),
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
