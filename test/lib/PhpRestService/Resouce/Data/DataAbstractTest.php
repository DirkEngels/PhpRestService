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
     * @expectedException \Exception
     */
    public function testHandleHeadMethod() {
        $this->_handleWithCustomMethod('HEAD');
    }

    /**
     * @expectedException \Exception
     */
    public function testHandleOptionsMethod() {
        $this->_handleWithCustomMethod('OPTIONS');
    }

    /**
     * @expectedException \Exception
     */
    public function testHandleGetMethod() {
        $this->_handleWithCustomMethod('GET');
    }

    /**
     * @expectedException \Exception
     */
    public function testHandlePostMethod() {
        $this->_handleWithCustomMethod('POST');
    }

    /**
     * @expectedException \Exception
     */
    public function testHandlePutMethod() {
        $this->_handleWithCustomMethod('PUT');
    }

    /**
     * @expectedException \Exception
     */
    public function testHandleDeleteMethod() {
        $this->_handleWithCustomMethod('DELETE');
    }

    /**
     * @expectedException \Exception
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