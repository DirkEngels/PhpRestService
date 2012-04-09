<?php
/**
 * @package PhpRestService
 * @subpackage Resource
 * @copyright Copyright (C) 2011 Dirk Engels Websolutions. All rights reserved.
 * @author Dirk Engels <d.engels@dirkengels.com>
 * @license https://github.com/DirkEngels/PhpRestService/blob/master/doc/LICENSE
 *
 * @group PhpRestService
 * @group PhpRestService-Http
 * @group PhpRestService-Http-Code
 */

namespace PhpRestService\Http;

class CodeTest extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
    }

    protected function tearDown() {
    }

    /**
     * Invalid code returns 500: Internal Server Error
     */
    public function testGetInvalidCode() {
        $this->assertEquals(
            \PhpRestService\Http\Code::get( '666' ),
            'Internal Server Error'
        );
    }

    /**
     * @dataProvider providerGetValidCode
     */
    public function testGetValidCode($code, $message) {
        $this->assertEquals(
            $message,
            \PhpRestService\Http\Code::get( $code )
        );
    }

    public static function providerGetValidCode() {
        return array(
            // Informational 1xx
            array( 100, 'Continue' ),
            array( 101, 'Switching Protocols' ),

            // Success 2xx
            array( 200, 'OK' ),
            array( 201, 'Created' ),
            array( 202, 'Accepted' ),
            array( 203, 'Non-Authoritative Information' ),
            array( 204, 'No Content' ),
            array( 205, 'Reset Content' ),
            array( 206, 'Partial Content' ),

            // Redirection 3xx
            array( 300, 'Multiple Choices' ),
            array( 301, 'Moved Permanently' ),
            array( 302, 'Found' ),  // 1.1
            array( 303, 'See Other' ),
            array( 304, 'Not Modified' ),
            array( 305, 'Use Proxy' ),
//             array( 306, 'is deprecated but reserved'),
            array( 307, 'Temporary Redirect' ),

            // Client Error 4xx
            array( 400, 'Bad Request' ),
            array( 401, 'Unauthorized' ),
            array( 402, 'Payment Required' ),
            array( 403, 'Forbidden' ),
            array( 404, 'Not Found' ),
            array( 405, 'Method Not Allowed' ),
            array( 406, 'Not Acceptable' ),
            array( 407, 'Proxy Authentication Required' ),
            array( 408, 'Request Timeout' ),
            array( 409, 'Conflict' ),
            array( 410, 'Gone' ),
            array( 411, 'Length Required' ),
            array( 412, 'Precondition Failed' ),
            array( 413, 'Request Entity Too Large' ),
            array( 414, 'Request-URI Too Long' ),
            array( 500, 'Internal Server Error' ),
            array( 501, 'Not Implemented' ),
            array( 502, 'Bad Gateway' ),

                // Server Error 5xx
            array( 503, 'Service Unavailable' ),
            array( 504, 'Gateway Timeout' ),
            array( 505, 'HTTP Version Not Supported' ),
            array( 509, 'Bandwidth Limit Exceeded'),
        );
    }

}