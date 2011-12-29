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

class JsonTest extends \PHPUnit_Framework_TestCase {

    protected $_component;

    protected function setUp() {
        $this->_component = new Json();
    }

    protected function tearDown() {
    }

    public function testRender() {
        $input = array(
            'key' => 'value', 
            'array' => array('sub1' => 'val1', 'sub2' => 'val2'),
        );
        $output = '{"key":"value","array":{"sub1":"val1","sub2":"val2"}}';
        $this->_component->render($input);
        $this->assertEquals($output, $this->_component->getResponse()->getBody());
    }

    public function testRenderEmtpy() {
        $input = array();
        $output = '[]';
        $this->_component->render($input);
        $this->assertEquals($output, $this->_component->getResponse()->getBody());
    }

}