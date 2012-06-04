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
//         $path = (substr($path, 0, 1) == '/' ) ? substr($path, 1) : $path;
        $path = (substr($path, -1) == '/' ) ? substr($path, 0, -1) : $path;
        $pathPieces = explode('/', $path);
//         array_push($pathPieces, '');
        $basePath = \APPLICATION_PATH . '/service/';

        \PhpRestService\Logger::get()->log('Counted ' . count($pathPieces) . ' url path pieces', \Zend_Log::DEBUG);
        for ($i = 0; $i<count($pathPieces); $i++) {
            \PhpRestService\Logger::get()->log('- Found: ' . $pathPieces[$i] , \Zend_Log::DEBUG);

            if (is_null($pathPieces[$i]) || $pathPieces[$i] == '') {
                $this->_resourceKey = NULL;
                continue;
            }

            if (preg_match('/[a-zA-Z0-9]+/', $pathPieces[$i])) {
                if ($i>=0 && $pathPieces[$i-1] != '') {
                    \PhpRestService\Logger::get()->log('- Set ' . $pathPieces[$i-1] . ' => ' . $pathPieces[$i] , \Zend_Log::DEBUG);
                    $this->_arguments[$pathPieces[$i-1]] = $pathPieces[$i];

                    // Set Key
                    $this->_resourceKey = $pathPieces[$i];
                }
            } else {
                // Reset key
                $this->_resourceKey = NULL;
            }

            $filename = strtolower(implode('/', $validPieces)) . '/' . strtolower($pathPieces[$i]);
            \PhpRestService\Logger::get()->log('Testing resource dirname: ' . $filename, \Zend_Log::INFO);
            if (file_exists($basePath . $filename)) {
                \PhpRestService\Logger::get()->log('Found! Add valid piece: ' . ucfirst($pathPieces[$i]), \Zend_Log::INFO);
                array_push($validPieces, ucfirst($pathPieces[$i]));
                $this->_resourceKey = NULL;
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