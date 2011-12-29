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

    public function testNothing() {
        $this->assertTrue(TRUE);
    }

}