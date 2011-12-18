<?php

namespace PhpRestService\Application;

use PhpRestService\Http;
use PhpRestService\Resource;
use PhpRestService\Resource\Representation;

class Service {

    protected $_request;
    protected $_response;


    /**
     * Initializes the Config component by loading configuration files passed 
     * using command line arguments and the default configuration files.
     */
    protected function _initConfig() {
        // Prepare configuration files
        $configFiles = array();

        // Initiate config
        $config = \PhpRestService\Config::get($configFiles);
        return $config;
    }


    /**
     * Initializes the logging verbose mode
     */
    protected function _initLogVerbose() {
        // Log Verbose Output
//        if ($this->_consoleOpts->getOption('verbose')) {
//            $writerVerbose = new \Zend_Log_Writer_Stream('php://output');
//
//            // Determine Log Level
//            $logLevel = \Zend_Log::ERR;
//            if ($this->_consoleOpts->getOption('verbose')>1) {
//                $logLevel = (int) $this->_consoleOpts->getOption('verbose');
//            }
//            $writerVerbose->addFilter($logLevel);
//
//            \PhpRestService\Logger::get()->addWriter($writerVerbose);
//            $msg = 'Adding log writer: verbose (level: ' . $logLevel . ')';
//            \PhpRestService\Logger::log($msg, \Zend_Log::DEBUG);
//        }
    }


    /**
     * Initalizes the Logger component to save log messages to a file based on
     * the command line arguments and/or configuration files. 
     * @throws \Exception
     */
    protected function _initLogFile() {
        $logFile = \PhpRestService\Config::get()->getOptionValue('log.file');
        if (substr($logFile, 0, 1)!='/') {
            $logFile = realpath(\APPLICATION_PATH) . '/' . $logFile;
        }

        // Create logfile if not exists
        if (!file_exists($logFile)) {
            try {
                // Create file
                touch($logFile);

                // Adding logfile
                $writerFile = new \Zend_Log_Writer_Stream($logFile);
                \PhpRestService\Logger::get()->addWriter($writerFile);
                \PhpRestService\Logger::log('Adding log writer: ' . $logFile, \Zend_Log::DEBUG);
            } catch (\Exception $e) {
                \PhpRestService\Logger::log('Cannot create log file: ' . $logFile, \Zend_Log::ALERT);
            }
        }
    }


    protected function _initResource() {
        // Resource
        if (preg_match('/task/', ($_SERVER['REQUEST_URI']))) {
            // Initialize hard coded resource
            $resource = new \App\Service\Daemon\Single\Task\Item($this->_request, $this->_response);

        } else {
            $resource = new \App\Service\Daemon\Single\Daemon\Collection($this->_request, $this->_response);
        }
        return $resource;
    }

    protected function _detectRoute() {
        
    }

    protected function _renderOutput($resource) {
        // Representation
        $format = (isset($_REQUEST['format'])) ? $_REQUEST['format'] : 'json';
        switch ($format) {
            case 'xml':
                $representation = new Representation\Xml($this->_response);
                break;
            case 'json':
            default:
                $representation = new Representation\Json($this->_response);
                break;
        }
        $this->_response = $representation->render($resource->get());

    }

    public function run() {
        // Set verbose mode (--verbose)
        $this->_initLogVerbose();

        // Initialize Configuration
        $this->_initConfig();

        // Add Log Files
        $this->_initLogFile();

        // Get Request
        $this->_request = new Http\Request();

        // Init response
        $this->_response = new Http\Response();

        // Init resource
        $resource = $this->_initResource($this->_response);

        // Init representation
        $this->_renderOutput($resource);

        return $this->_response->send();
    }

}
