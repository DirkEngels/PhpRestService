<?php
/**
 * @package PhpRestService
 * @subpackage Resource\Manager
 * @copyright Copyright (C) 2011 Dirk Engels Websolutions. All rights reserved.
 * @author Dirk Engels <d.engels@dirkengels.com>
 * @license https://github.com/DirkEngels/PhpRestService/blob/master/doc/LICENSE
 *
 * @group PhpRestService
 * @group PhpRestService-Resource
 * @group PhpRestService-Resource-Manager
 */

namespace PhpRestService\Resource\Manager;

class ManagerAbstractTest extends \PHPUnit_Framework_TestCase {

    protected $_component;

    protected function setUp() {
        $this->_component = $this->getMockForAbstractClass(
            '\PhpRestService\Resource\Manager\ManagerAbstract'
        );
    }

    protected function tearDown() {
    }

    public function testSetName() {
        $this->assertNull($this->_component->getName());

        $this->_component->setName('TestName');

        $this->assertEquals('TestName', $this->_component->getName());
    }

    public function testSetItem() {
        $none = new \PhpRestService\Resource\Data\None();

        $this->assertNull($this->_component->getItem());

        $this->_component->setItem($none);

        $this->assertEquals($none, $this->_component->getItem());
    }

    public function testSetCollection() {
        $none = new \PhpRestService\Resource\Data\None();

        $this->assertNull($this->_component->getCollection());

        $this->_component->setCollection($none);

        $this->assertEquals($none, $this->_component->getCollection());
    }

}