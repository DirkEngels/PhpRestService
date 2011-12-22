<?php

namespace PhpRestService\Resource\Item;

abstract class ItemAbstract {

    protected $_id;

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    public function head() {
        throw new \Exception('HTTP Method not implemented');
    }

    public function options() {
        throw new \Exception('HTTP Method not implemented');
    }

    public function get() {
        throw new \Exception('HTTP Method not implemented');
    }

    public function post() {
        throw new \Exception('HTTP Method not implemented');
    }

    public function put() {
        throw new \Exception('HTTP Method not implemented');
    }

    public function delete() {
        throw new \Exception('HTTP Method not implemented');
    }

    public function handle() {
        $method = $_SERVER['REQUEST_METHOD'];
        if (!method_exists($this, $method)) {
            throw new \Exception('HTTP Method has not been implemented!');
        }
        return $this->$method();
    }
}
