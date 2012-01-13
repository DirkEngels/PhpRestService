<?php

namespace PhpRestService\Resource\Auth;

class Digest extends AuthAbstract implements AuthInterface {

    protected $users = array('dirk' => 'engels');

    public function authenticate() {
        $data = array();
        $realm = 'PhpRestService Digest Realm';

        if (isset($_SERVER['PHP_AUTH_DIGEST'])) {
            $data = $this->parseDigest($_SERVER['PHP_AUTH_DIGEST']);
        }
        if ((is_array($data)) && isset($this->users[$data['username']])) {

            $a1 = md5($data['username'] . ':' . $realm . ':' . $this->users[$data['username']]);
            $a2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
            $validResponse = md5($a1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$a2);

            if ($data['response'] == $validResponse) {
                // Authenticated: proceed!
                return TRUE;
            }
        }

        // Unauthorized: send header
        $headerData = array(
            'realm' => $realm,
            'qop' => 'auth',
            'nonce' => uniqid(),
            'opaque' => md5($realm),
        );
        $authHeader = 'WWW-Authenticate: Digest ';
        foreach($headerData as $dataKey => $dataValue) {
            $authHeader .= ($dataKey != 'realm') ? ',' : '';
            $authHeader .= $dataKey . '="' . $dataValue . '"';
        }
        header($authHeader);
        throw new \Exception('Unauthorized', 401);
        return FALSE;
    }

    function parseDigest($txt) {
        // protect against missing data
        $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
        $data = array();
        $keys = implode('|', array_keys($needed_parts));

        preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            $data[$m[1]] = $m[3] ? $m[3] : $m[4];
            unset($needed_parts[$m[1]]);
        }

        return $needed_parts ? false : $data;
    }

}