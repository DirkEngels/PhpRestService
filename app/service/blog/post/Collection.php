<?php

namespace App\Service\Blog\Post;

class Collection extends \PhpRestService\Resource\Collection\CollectionAbstract implements \PhpRestService\Resource\Collection\CollectionInterface {

    protected $_logic;

    public function __construct() {
        $this->_logic = new \App\Domain\Logic\Post();
    }

    public function get() {
        $objects = $this->_logic->load();
        $data = array();
        foreach($objects as $object) {
            $data[] = array(
                'id' => $object->getId(),
                'url' => 'http://'. $_SERVER['HTTP_HOST'] . '/blog/post/' . $object->getId(),
                'title' => $object->getTitle(),
                'date' => $object->getDateCreated(),
            );
        }

        // Fill response
        return $data;
    }

}
