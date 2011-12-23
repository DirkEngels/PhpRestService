<?php

namespace PhpRestService\Resource\Data;

class Item extends DataAbstract implements DataInterface {

    protected $_id;

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

}