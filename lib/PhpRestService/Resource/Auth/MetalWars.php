<?php

namespace PhpRestService\Resource\Auth;

class MetalWars extends AuthAbstract implements AuthInterface {

    public function authenticate() {
        if ((isset($_SERVER['PHP_AUTH_USER'])) && (isset($_SERVER['PHP_AUTH_PW']))) {
            // Lookup user
            $player = new \MetalWars\Domain\Player();
            if ( $player->authenticate( $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'] ) ) {
                // Authenticated: proceed!
                return TRUE;
            }
        }

        // Unauthorized: send header
        header('WWW-Authenticate: Basic realm="PhpRestService Basic Realm"');
        throw new \Exception('Unauthorized', 401);
        return FALSE;
    }

}