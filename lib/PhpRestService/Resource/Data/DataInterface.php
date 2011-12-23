<?php

namespace PhpRestService\Resource\Data;

interface DataInterface {

    public function head();
    public function options();
    public function get();
    public function post();
    public function put();
    public function delete();

}
