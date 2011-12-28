<?php

namespace PhpRestService\Resource\Manager;

interface ManagerInterface {

    public function getCollection();
    public function setCollection($collection);
    public function getDisplay();
    public function setDisplay($display);
    public function getFormat();
    public function setFormat($format);
    public function getId();
    public function setId($id);
    public function handle($id = NULL);

}
