<?php

namespace PhpRestService\Resource\Item;

interface ItemInterface {

    public function head();
    public function options();
    public function get();
    public function post();
    public function put();
    public function delete();

}
