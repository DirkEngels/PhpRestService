<?php

namespace PhpRestService\Resource\Format;

interface FormatInterface {

    public function parse($string);
    public function render($data);

}