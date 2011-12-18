<?php
/**
 * @package PhpRestService
 * @copyright Copyright (C) 2011 Dirk Engels Websolutions. All rights reserved.
 * @author Dirk Engels <d.engels@dirkengels.com>
 * @license https://github.com/DirkEngels/PhpRestService/blob/master/doc/LICENSE
 */

namespace PhpRestService;

/**
 * The logger component uses a Zend_Log object to log messages.
 *
 */
class Logger {
    protected static $_instance = NULL;


    /** 
     * Protected constructor for singleton pattern
     */
    protected function __construct() {
    }


    /**
     * Singleton getter
     * @return \PhpRestService\Log
     */
    public static function get() {
        if (!self::$_instance) {
            self::$_instance = new \Zend_Log();
            self::$_instance->addWriter(
                new \Zend_Log_Writer_Null()
            );
            self::$_instance->log("Creating new log object", \Zend_Log::DEBUG);
        }

        return self::$_instance;
    }

    public static function log($message, $level = null) {
        if (is_null($level)) {
            $level = Config::get()->getOptionValue('service.log.level');
        }

        return self::get()->log('[' . getmypid() . '] ' . $message, $level);
    }
}