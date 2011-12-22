<?php

namespace App\Service\Blog\Post;

class Item extends \PhpRestService\Resource\Item\ItemAbstract implements \PhpRestService\Resource\Item\ItemInterface {

    protected $_logic;

    public function __construct() {
        $this->_logic = new \App\Domain\Logic\Post();
    }

    public function get() {
        $urlPieces = explode('/', $_SERVER['REQUEST_URI']);
        $id = NULL;
        if (count($urlPieces)>3) {
            $id = $urlPieces[3];
        }

        $object = $this->_logic->find($id);
        return $object;
    }

}
