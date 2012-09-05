<?php

namespace PhpRestService\Resource\Auth;

class MetalWars extends AuthAbstract implements AuthInterface {

    public function authenticate() {
        $user = isset( $_SERVER['PHP_AUTH_USER'] ) ? $_SERVER['PHP_AUTH_USER'] : '----';
        if ((isset($user)) && (isset($_SERVER['PHP_AUTH_PW']))) {
            // Lookup user
            $player = new \MetalWars\Domain\Player();
            try {
            	if ( $player->authenticate( $user, $_SERVER['PHP_AUTH_PW'] ) ) {
	                // Authenticated: proceed!
    	            \PhpEventLog\Log\Collector::add( new \PhpEventLog\Event\User( $user, 1 ) );
        	        return TRUE;
            	}
            } catch ( \Exception $e ) {
            	\PhpEventLog\Log\Collector::add( new \PhpEventLog\Event\Exception( $e ) );
            }
        }

        \PhpEventLog\Log\Collector::add( new \PhpEventLog\Event\User( $user, 0 ) );

        // Unauthorized: send header
        header('WWW-Authenticate: Basic realm="PhpRestService Basic Realm"');
        throw new \Exception('Unauthorized', 401);
        return FALSE;
    }

}