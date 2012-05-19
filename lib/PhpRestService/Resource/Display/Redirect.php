<?php

namespace PhpRestService\Resource\Display;

class Redirect extends DisplayAbstract implements DisplayInterface {

    public function dataBasic($object) {
        $url = '';
        if ( substr( $object['redirect'], 0, 1 ) == '/' ) {
            $url = 'http://' . $_SERVER['HTTP_HOST'];
        }
        $url .= $object['redirect'];

        $message = 'No message set';
        if ( isset( $object[ 'message' ] ) ) {
            $message = $object['message'];
        }

        $data = array(
            'message' => $message,
            'redirect' => $url,
        );
        return $data;
    }

}