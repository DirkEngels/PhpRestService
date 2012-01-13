<?php

namespace PhpRestService\Resource\Format;
use \PhpRestService\Resource\Component;

interface FormatInterface extends Component\ComponentInterface {

    public function parse($string);
    public function render($data);

}