<?php
/**
 * @package PhpRestService
 * @subpackage Resource\Format
 * @copyright Copyright (C) 2011 Dirk Engels Websolutions. All rights reserved.
 * @author Dirk Engels <d.engels@dirkengels.com>
 * @license https://github.com/DirkEngels/PhpRestService/blob/master/doc/LICENSE
 *
 * @group PhpRestService
 * @group PhpRestService-Resource
 * @group PhpRestService-Resource-Format
 */

namespace PhpRestService\Resource\Format;

class XmlTest extends \PHPUnit_Framework_TestCase {

    protected $_component;

    protected function setUp() {
        $this->_component = new Xml();
    }

    protected function tearDown() {
    }

    /**
     * @expectedException \PhpRestService\Exception\NotYetImplemented
     */
    public function testParseEmpty() {
        $input = '';
        $this->_component->parse($input);
    }

}