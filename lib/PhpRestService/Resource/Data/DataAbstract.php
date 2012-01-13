<?php

namespace PhpRestService\Resource\Data;
use \PhpRestService\Resource\Component;

abstract class DataAbstract extends Component\ComponentAbstract {

    protected function _getId() {
        $urlPieces = explode('/', $_SERVER['REQUEST_URI']);
        $id = NULL;
        if (count($urlPieces)>2) {
            $id = $urlPieces[2];
        }
        return $id;
    }

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
            throw new \Exception('Unsupported http method!', 501);
        }
        return $this->$method();
    }

}
