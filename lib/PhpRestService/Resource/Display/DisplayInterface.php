<?php

namespace PhpRestService\Resource\Display;
use \PhpRestService\Resource\Component;

interface DisplayInterface extends Component\ComponentInterface {

    public function dataUrl($object);
    public function dataBasic($object);
    public function dataExtended($object);

    public function displayItem($object, $extended, $url);
    public function displayCollection($objects, $extended, $url);

}