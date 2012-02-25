<?php
/**
 * @package PhpRestService
 * @subpackage Resource\Component
 * @copyright Copyright (C) 2011 Dirk Engels Websolutions. All rights reserved.
 * @author Dirk Engels <d.engels@dirkengels.com>
 * @license https://github.com/DirkEngels/PhpRestService/blob/master/doc/LICENSE
 *
 * @group PhpRestService
 * @group PhpRestService-Resource
 * @group PhpRestService-Resource-Data
 */

namespace PhpRestService\Resource\Data;

class DataAbstractTest extends \PHPUnit_Framework_TestCase {

    protected $_component;

    protected function setUp() {
        $this->_component = $this->getMockForAbstractClass(
            '\PhpRestService\Resource\Data\DataAbstract'
        );
    }

    protected function tearDown() {
    }

    /**
     * @expectedInvalidArgumentException \InvalidArgumentException
     */
    public function testHandleHeadMethod() {
        $this->_handleWithCustomMethod('HEAD');
    }

    /**
     * @expectedInvalidArgumentException \InvalidArgumentException
     */
    public function testHandleOptionsMethod() {
        $this->_handleWithCustomMethod('OPTIONS');
    }

    /**
     * @expectedInvalidArgumentException \InvalidArgumentException
     */
    public function testHandleGetMethod() {
        $this->_handleWithCustomMethod('GET');
    }

    /**
     * @expectedInvalidArgumentException \InvalidArgumentException
     */
    public function testHandlePostMethod() {
        $this->_handleWithCustomMethod('POST');
    }

    /**
     * @expectedInvalidArgumentException \InvalidArgumentException
     */
    public function testHandlePutMethod() {
        $this->_handleWithCustomMethod('PUT');
    }

    /**
     * @expectedInvalidArgumentException \InvalidArgumentException
     */
    public function testHandleDeleteMethod() {
        $this->_handleWithCustomMethod('DELETE');
    }

    /**
     * @expectedInvalidArgumentException \InvalidArgumentException
     */
    public function testHandleUnsupportedMethod() {
        $this->_handleWithCustomMethod('UNKNOWN');
    }

    protected function _handleWithCustomMethod($method = 'GET') {
        // Override server method
        $_SERVER['REQUEST_METHOD'] = $method;
        $this->_component->handle();
    }
}
