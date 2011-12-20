<?php

namespace PhpRestService\Domain\Logic;

class Comment {

    protected $_model;

    public function write($data) {
        return $this->_model->insert($data);
    }

    public function load() {
    }

    public function find($id) {
        
    }

}