<?php

namespace PhpRestService\Application\Router;

class Resource extends RouterAbstract {

    public $_resourceName = NULL;
    public $_resourceKey = NULL;

    const RESOURCE_DEFAULT = '';

    protected $_arguments = array();

    public function __construct($url) {
        parent::__construct($url);

        $resourceName = Resource::RESOURCE_DEFAULT;
        $validPieces = array();

        $path = parse_url($this->_url, \PHP_URL_PATH);
        $pathPieces = explode('/', $path);
        $basePath = \APPLICATION_PATH . '/service/';

        \PhpRestService\Logger::get()->log('Counted ' . count($pathPieces) . ' url path pieces', \Zend_Log::DEBUG);
        for ($i = 0; $i<count($pathPieces); $i++) {
            if (preg_match('/([0-9]+)/', $pathPieces[$i])) {
                if ($i>0) {
                    $this->_arguments[$pathPieces[$i-1]] = $pathPieces[$i];
                }
                $this->_resourceKey = $pathPieces[$i];
                continue;
            } else {
                $this->_resourceKey = NULL;
            }
            if ($pathPieces[$i] == '') {
                continue;
            }

            $filename = $basePath . strtolower(implode('/', $validPieces)) . '/' . strtolower($pathPieces[$i]);
            \PhpRestService\Logger::get()->log('Testing resource dirname: ' . $filename, \Zend_Log::INFO);
            if (file_exists($filename)) {
                \PhpRestService\Logger::get()->log('Found! Add valid piece: ' . ucfirst($pathPieces[$i]), \Zend_Log::INFO);
                array_push($validPieces, ucfirst($pathPieces[$i]));
            }
        }

        if (count($validPieces)) {
            $resourceName = implode('\\', $validPieces);
        }
        $this->_resourceName = $resourceName;
        return $resourceName;
    }

    public function getResourceName() {
        return $this->_resourceName;
    }
    public function getResourceKey() {
        return $this->_resourceKey;
    }
    public function getArguments() {
        return $this->_arguments;
    }

}