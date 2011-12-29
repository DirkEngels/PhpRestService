<?php

namespace PhpRestService\Resource\Manager;
use \PhpRestService\Resource\Component;

interface ManagerInterface extends Component\ComponentInterface {

    public function getCollection();
    public function setCollection($collection);
    public function getDisplay();
    public function setDisplay($display);
    public function getFormat();
    public function setFormat($format);
    public function handle($id = NULL);

}
