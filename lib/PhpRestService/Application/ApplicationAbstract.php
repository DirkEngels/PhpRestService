<?php

namespace PhpRestService\Application;

class ApplicationAbstract {

    /**
     * Run all the initialize methods
     * - initConfig
     * - initLogFile
     */
    protected function _init() {
        // Initialize Configuration
        $this->_initConfig();

        // Add Log Files
        $this->_initLogFile();
    }


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
     * Initalizes the Logger component to save log messages to a file based on
     * the command line arguments and/or configuration files. 
     * @throws \Exception
     */
    protected function _initLogFile() {
        $logFile = \PhpRestService\Config::get()->getOptionValue('log.file');
        if (substr($logFile, 0, 1)!='/') {
            $logFile = \PROJECT_ROOT . '/' . $logFile;
        }

        // Create logfile if not exists
        try {
            // Create file
            touch($logFile);

            // Adding logfile
            $writerFile = new \Zend_Log_Writer_Stream($logFile);
            \PhpRestService\Logger::get()->addWriter($writerFile);
            \PhpRestService\Logger::log('Adding log writer: ' . $logFile, \Zend_Log::DEBUG);

            $writerFile->addFilter(\Zend_Log::DEBUG);
            \PhpRestService\Logger::log("Setting log level to DEBUG", \Zend_Log::DEBUG);
        } catch (\Exception $e) {
            \PhpRestService\Logger::log('Cannot create log file: ' . $logFile, \Zend_Log::ALERT);
        }

    }

}
