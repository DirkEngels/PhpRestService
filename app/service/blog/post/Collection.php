<?php

namespace App\Service\Blog\Post;

class Collection extends \PhpRestService\Resource\Collection\CollectionAbstract implements \PhpRestService\Resource\Collection\CollectionInterface {

    protected $_logic;

    public function __construct() {
        $this->_logic = new \App\Domain\Logic\Post();
    }

    public function get() {
        $objects = $this->_logic->load();
        return $objects;
    }

    public function post() {
        return $this->_logic->write($data);
    }
}
