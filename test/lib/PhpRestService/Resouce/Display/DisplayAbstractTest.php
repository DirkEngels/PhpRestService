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
 * @group PhpRestService-Resource-Display
 */

namespace PhpRestService\Resource\Component;

class DisplayAbstractTest extends \PHPUnit_Framework_TestCase {

    protected $_component;

    protected function setUp() {
        $this->_component = $this->getMockForAbstractClass(
            '\PhpRestService\Resource\Display\DisplayAbstract'
        );
    }

    protected function tearDown() {
    }

//    public function testGetUrl() {
//        $_SERVER['REQUEST_URI'] = 'http://www.google.nl';
//        $this->assertEquals('http://www.google.nl', $this->_component->getUrl());
//    }

    public function testSetUrl() {
        $this->_component->setUrl('http://www.google.nl');
        $this->assertEquals('http://www.google.nl', $this->_component->getUrl());
    }

    public function testSetUrlLastSlash() {
        $this->_component->setUrl('http://www.google.nl/');
        $this->assertEquals('http://www.google.nl', $this->_component->getUrl());
    }

    public function testSetUrlStartHttp() {
        $this->_component->setUrl('www.google.nl/');
        $this->assertEquals('http://www.google.nl', $this->_component->getUrl());
    }
}