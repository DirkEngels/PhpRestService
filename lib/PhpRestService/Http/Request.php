<?php

namespace PhpRestService\Http;

class Request {

    public function getAcceptFormats($header = false) {
        $formats = array();
        $header = $header ? $header : (array_key_exists('HTTP_ACCEPT', $_SERVER) ? $_SERVER['HTTP_ACCEPT']: false);
        if ($header) {
            $types = explode(',', $header);
            $types = array_map('trim', $types);
            foreach ($types as $one_type) {
                $one_type = explode(';', $one_type);
                $type = array_shift($one_type);
                if ($type) {
                    list($precedence, $tokens) = $this->_getAcceptFormatsOptions($one_type);
                    list($main_type, $sub_type) = array_map('trim', explode('/', $type));
                    $formats[] = array('main_type' => $main_type, 'sub_type' => $sub_type, 'precedence' => (float)$precedence, 'tokens' => $tokens);
                }
            }
        }
        return $formats;
    }

    protected function _getAcceptFormatsOptions($type_options) {
        $precedence = 1;
        $tokens = array();
        if (is_string($type_options)) {
            $type_options = explode(';', $type_options);
        }
        $type_options = array_map('trim', $type_options);
        foreach ($type_options as $option) {
            $option = explode('=', $option);
            $option = array_map('trim', $option);
            if ($option[0] == 'q') {
                $precedence = $option[1];
            } else {
                $tokens[$option[0]] = $option[1];
            }
        }
        $tokens = count ($tokens) ? $tokens : false;
        return array($precedence, $tokens);
    }

}