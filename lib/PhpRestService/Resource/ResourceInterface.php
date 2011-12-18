<?php

namespace PhpRestService\Resource;

interface ResourceInterface {

    public function getCollection();
    public function setCollection($collection);
    public function getItem();
    public function setItem($item);
    public function getId();
    public function setId($id);

}
