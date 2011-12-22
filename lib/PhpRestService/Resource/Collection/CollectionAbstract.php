<?php

namespace PhpRestService\Resource\Collection;

abstract class CollectionAbstract {

    protected $_request;
    protected $_response;

    public function __construct($request = NULL) {
        if (!is_null($request)) {
            $this->setRequest($request);
        }
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
