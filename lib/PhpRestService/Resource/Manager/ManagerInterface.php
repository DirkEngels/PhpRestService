<?php

namespace PhpRestService\Resource\Manager;

interface ManagerInterface {

    public function getData();
    public function setData($data);
    public function getDisplay();
    public function setDisplay($display);
    public function getFormat();
    public function setFormat($format);
    public function getId();
    public function setId($id);

}
