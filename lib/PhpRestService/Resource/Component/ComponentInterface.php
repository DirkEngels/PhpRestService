<?php

namespace PhpRestService\Resource\Component;

interface ComponentInterface {

    public function getRequest();
    public function setRequest($request);
    public function getResponse();
    public function setResponse($response);
    public function getId();
    public function setId($id);

}
