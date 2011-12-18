<?php

namespace PhpRestService\Resource\Collection;

interface CollectionInterface {

    public function head();
    public function options();
    public function get();
    public function post();
    public function put();
    public function delete();

}
