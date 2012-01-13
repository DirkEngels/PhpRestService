<?php

namespace PhpRestService\Resource\Auth;

class None extends AuthAbstract implements AuthInterface {

    public function authenticate() {
        return TRUE;
    }

}