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
        throw new \BadMethodCallException('HTTP Method not implemented', 404);
    }

    public function options() {
        /**
         * header('Allow: GET,POST,PUT,DELETE,OPTIONS,HEAD');
         * header('Public: GET,POST,PUT,DELETE,OPTIONS,HEAD');
         **/
        throw new \BadMethodCallException('HTTP Method implemented?', 200);
    }

    public function get() {
        throw new \BadMethodCallException('HTTP Method not implemented', 404);
    }

    public function post() {
        throw new \BadMethodCallException('HTTP Method not implemented', 404);
    }

    public function put() {
        throw new \BadMethodCallException('HTTP Method not implemented', 404);
    }

    public function delete() {
        throw new \BadMethodCallException('HTTP Method not implemented', 404);
    }

    public function handle() {
        $method = $_SERVER['REQUEST_METHOD'];
        if (!method_exists($this, $method)) {
            throw new \BadMethodCallException('Unsupported http method!', 501);
        }
        return $this->$method();
    }

}
