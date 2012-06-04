<?php

namespace PhpRestService\Http;

class Response {

    protected $_code = NULL;
    protected $_headers = array();
    protected $_body = '';
	
    public function __construct() {
        $this->addHeader('Server', 'PhpRestService v0.1');
    }

    public function getCode() {
        return $this->_code;
    }

    public function setCode($code) {
        $this->_code = $code;
        return $this;
    }

    public function getHeaders() {
        return $this->_headers;
    }

    public function setHeaders($headers) {
        $this->_headers = $headers;
        return $this;
    }

    public function addHeader($name, $value) {
        $this->_headers[$name] = $value;
        return $this;
    }

    public function removeHeader($name) {
        unset($this->_headers[$name]);
        return $this;
    }

    public function getBody() {
        return $this->_body;
    }

    public function setBody($body) {
        $this->_body = $body;
    }


    public function send() {
        // Set Code
        Header('HTTP/1.0 ' . $this->getCode() . Code::get($this->getCode()));

        // Set Headers
        foreach($this->getHeaders() as $name => $value) {
            Header($name . ': ' . $value);
        }

        // Show Body
        echo $this->getBody();
    }

}

