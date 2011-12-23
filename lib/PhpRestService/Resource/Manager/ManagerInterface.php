<?php

namespace PhpRestService\Resource\Manager;

interface ManagerInterface {

    public function getCollection();
    public function setCollection($collection);
    public function getItem();
    public function setItem($item);
    public function getId();
    public function setId($id);

}
