<?php

namespace PhpRestService\Resource\Collection;

abstract class CollectionAbstract {

    public function head() {
        throw Exception('HTTP Method not implemented');
    }

    public function options() {
        throw Exception('HTTP Method not implemented');
    }

    public function get() {
        throw Exception('HTTP Method not implemented');
    }

    public function post() {
        throw Exception('HTTP Method not implemented');
    }

    public function put() {
        throw Exception('HTTP Method not implemented');
    }

    public function delete() {
        throw Exception('HTTP Method not implemented');
    }

    public function handle() {
        $method = $_SERVER['REQUEST_METHOD'];
        if (!method_exists($this, $method)) {
            throw new \Exception('HTTP Method has not been implemented!');
        }
        return $this->$method();
    }

}
