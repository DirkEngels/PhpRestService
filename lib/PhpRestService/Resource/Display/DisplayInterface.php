<?php

namespace PhpRestService\Resource\Display;

interface DisplayInterface {

    public function dataUrl($object);
    public function dataBasic($object);
    public function dataExtended($object);

    public function displayItem($object);
    public function displayCollection($objects);

}