<?php

namespace PhpRestService\Resource\Auth;

class Basic extends AuthAbstract implements AuthInterface {

    public function authenticate() {
        if ((isset($_SERVER['PHP_AUTH_USER'])) && (isset($_SERVER['PHP_AUTH_PW']))) {
            if (($_SERVER['PHP_AUTH_USER'] == 'dirk') && ($_SERVER['PHP_AUTH_PW'] == 'engels')) {
                // Authenticated: proceed!
                return TRUE;
            }
        }

        // Unauthorized: send header
        header('WWW-Authenticate: Basic realm="PhpRestService Realm"');
        throw new \Exception('Unauthorized', 401);
        return FALSE;
    }

}