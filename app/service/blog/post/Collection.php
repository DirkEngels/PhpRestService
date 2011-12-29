<?php

namespace App\Service\Blog\Post;

use \PhpRestService\Resource\Data;

class Collection extends Data\Collection implements Data\DataInterface {

    protected $_logic;

    public function __construct() {
        $this->_logic = new \App\Domain\Logic\Post();
    }

    public function get() {
        $this->getResponse()->getCode(200);
        $objects = $this->_logic->load();
        return $objects;
    }

    public function post() {
        $this->getResponse()->getCode(201);
        return $this->_logic->write($_POST);
    }

}
