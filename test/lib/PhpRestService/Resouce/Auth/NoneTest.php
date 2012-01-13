<?php
/**
 * @package PhpRestService
 * @subpackage Resource\Auth
 * @copyright Copyright (C) 2011 Dirk Engels Websolutions. All rights reserved.
 * @author Dirk Engels <d.engels@dirkengels.com>
 * @license https://github.com/DirkEngels/PhpRestService/blob/master/doc/LICENSE
 *
 * @group PhpRestService
 * @group PhpRestService-Resource
 * @group PhpRestService-Resource-Auth
 */

namespace PhpRestService\Resource\Auth;

class NoneTest extends \PHPUnit_Framework_TestCase {

    protected $_component;

    protected function setUp() {
        $this->_component = new \PhpRestService\Resource\Auth\None();
    }

    protected function tearDown() {
    }

    public function testFactoryNoArguments() {
        $this->assertTrue($this->_component->authenticate());
    }

}