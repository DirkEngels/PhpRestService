<?php

namespace App\Service\Blog\Post;

use \PhpRestService\Resource\Data;

class Item extends Data\Item implements Data\DataInterface {

    protected $_logic;

    public function __construct() {
        $this->_logic = new \App\Domain\Logic\Post();
    }

    protected function _getId() {
        $urlPieces = explode('/', $_SERVER['REQUEST_URI']);
        $id = NULL;
        if (count($urlPieces)>3) {
            $id = $urlPieces[3];
        }
        return $id;
    }

    public function get() {
        $object = $this->_logic->find($this->_getId());
        if (!is_object($object)) {
            throw new \Exception('Object not found!', 404);
        }
        return $object;
    }

    public function put() {
        $this->getResponse()->setCode(204);

        $data = array('title' => 'Default title: ' . mktime());
        return $this->_logic->update($this->_getId(), $data);
    }

    public function delete() {
        $this->getResponse()->getCode(404);

        return $this->_logic->delete($this->_getId());
    }

}
