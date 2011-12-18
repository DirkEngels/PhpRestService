<?php

namespace PhpRestService\Resource\Item;

abstract class ItemAbstract {

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

}
