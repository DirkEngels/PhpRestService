<?php

namespace PhpRestService\Resource\Data;
use \PhpRestService\Resource\Component;

interface DataInterface extends Component\ComponentInterface {

    public function head();
    public function options();
    public function get();
    public function post();
    public function put();
    public function delete();

}
