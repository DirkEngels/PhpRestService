<?php

namespace PhpRestService\Resource\Data;
use \PhpRestService\Resource\Component;

abstract class DataAbstract extends Component\ComponentAbstract {

    const KEY_FIELD = 2;

    protected function getParam( $key ) {
        $value = ( isset( $_REQUEST[ $key ] ) ) ? $_REQUEST[ $key ] : '';
        return $value;
    }

    protected function _getId( $keyField = NULL ) {
        $urlPieces = explode('/', $_SERVER['REQUEST_URI']);
        $id = NULL;

        if ( ! isset($keyField) ) {
            $class = get_called_class();
            $keyField = $class::KEY_FIELD;
        }

        if (count($urlPieces) > $keyField ) {
            $id = $urlPieces[ $keyField ];
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
