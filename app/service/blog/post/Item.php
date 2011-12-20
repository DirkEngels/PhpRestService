<?php

namespace App\Service\Blog\Post;

class Item extends \PhpRestService\Resource\Item\ItemAbstract implements \PhpRestService\Resource\Item\ItemInterface {

    protected $_logic;

    public function __construct() {
        $this->_logic = new \App\Domain\Logic\Post();
    }

    public function get() {
        $urlPieces = explode('/', $_SERVER['REQUEST_URI']);
        $id = $urlPieces[3];

        $object = $this->_logic->find($id);

        $data = array (
            'id' => $object->getId(),
            'url' => '/task/' . $object->getId(),
            'date' => $object->getDateCreated(),
            'title' => $object->getTitle(),
            'content' => $object->getContent(),
            'comments' => $object->getComments(),
        );

        // Fill response
        return $data;
    }

    public function post() {
        
    }

}
