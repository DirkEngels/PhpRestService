<?php

namespace PhpRestService\Resource\Auth;

class Basic extends AuthAbstract implements AuthInterface {

    public function authenticate() {
        \PhpEventLog\Log\Collector::add( new \PhpEventLog\Event\User() );
        if ((isset($_SERVER['PHP_AUTH_USER'])) && (isset($_SERVER['PHP_AUTH_PW']))) {
            if (($_SERVER['PHP_AUTH_USER'] == 'dirk') && ($_SERVER['PHP_AUTH_PW'] == 'engels')) {
                // Authenticated: proceed!
                \PhpEventLog\Log\Collector::add( new \PhpEventLog\Event\User( $user, 1 ) );
                return TRUE;
            }
        }

        // Unauthorized: send header
        header('WWW-Authenticate: Basic realm="PhpRestService Basic Realm"');
        throw new \Exception('Unauthorized', 401);
        return FALSE;
    }

}