<?php

namespace PhpRestService\Resource\Data;
use \PhpRestService\Resource\Component;

abstract class DataAbstract extends Component\ComponentAbstract {

    public function head() {
        throw new \Exception('HTTP Method not implemented', 404);
    }

    public function options() {
        throw new \Exception('HTTP Method not implemented', 404);
    }

    public function get() {
        throw new \Exception('HTTP Method not implemented', 404);
    }

    public function post() {
        throw new \Exception('HTTP Method not implemented', 404);
    }

    public function put() {
        throw new \Exception('HTTP Method not implemented', 404);
    }

    public function delete() {
        throw new \Exception('HTTP Method not implemented', 404);
    }

    public function handle() {
        $method = $_SERVER['REQUEST_METHOD'];
        if (!method_exists($this, $method)) {
            throw new \Exception('HTTP Method has not been implemented!');
        }
        return $this->$method();
    }

}
