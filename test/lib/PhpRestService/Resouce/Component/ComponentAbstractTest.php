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
 * @group PhpRestService-Resource-Component
 */

namespace PhpRestService\Resource\Component;

class ComponentAbstractTest extends \PHPUnit_Framework_TestCase {

    protected $_component;

    protected function setUp() {
        $this->_component = $this->getMockForAbstractClass(
            '\PhpRestService\Resource\Component\ComponentAbstract'
        );
    }

    protected function tearDown() {
    }

    public function testFactoryNoArguments() {
        $request = new \PhpRestService\Http\Request();
        $response = new \PhpRestService\Http\Response();
        $this->assertEquals($request, $this->_component->getRequest());
        $this->assertEquals($response, $this->_component->getResponse());
        $this->assertNull($this->_component->getId());
    }

    public function testFactoryWithRequest() {
        $response = new \PhpRestService\Http\Response();

        $this->_component = $this->getMockForAbstractClass(
            '\PhpRestService\Resource\Component\ComponentAbstract',
            array(new \stdClass())
        );
        
        $this->assertEquals(new \stdClass(), $this->_component->getRequest());
        $this->assertEquals($response, $this->_component->getResponse());
        $this->assertNull($this->_component->getId());
    }

    public function testFactoryWithResponse() {
        $request = new \PhpRestService\Http\Request();

        $this->_component = $this->getMockForAbstractClass(
            '\PhpRestService\Resource\Component\ComponentAbstract',
            array(NULL, new \stdClass())
        );

        $this->assertEquals($request, $this->_component->getRequest());
        $this->assertEquals(new \stdClass(), $this->_component->getResponse());
        $this->assertNull($this->_component->getId());
    }

    public function testFactoryWithId() {
        $request = new \PhpRestService\Http\Request();
        $response = new \PhpRestService\Http\Response();

        $this->_component = $this->getMockForAbstractClass(
            '\PhpRestService\Resource\Component\ComponentAbstract',
            array(NULL, NULL, 123)
        );

        $this->assertEquals($request, $this->_component->getRequest());
        $this->assertEquals($response, $this->_component->getResponse());
        $this->assertEquals(123, $this->_component->getId());
    }

    public function testSetId() {
        $this->assertNull($this->_component->getId());

        $this->_component->setId(321);

        $this->assertEquals(321, $this->_component->getId());
    }

    public function testSetRequest() {
        $request = new \PhpRestService\Http\Request();
        $this->assertEquals($request, $this->_component->getRequest());

        $this->_component->setRequest(new \stdClass());

        $this->assertEquals(new \stdClass(), $this->_component->getRequest());
    }

    public function testSetResponse() {
        $response = new \PhpRestService\Http\Response();
        $this->assertEquals($response, $this->_component->getResponse());

        $this->_component->setResponse(new \stdClass());

        $this->assertEquals(new \stdClass(), $this->_component->getResponse());
    }

}