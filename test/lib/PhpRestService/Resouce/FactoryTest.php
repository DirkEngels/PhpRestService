<?php
/**
 * @package PhpRestService
 * @subpackage Resource
 * @copyright Copyright (C) 2011 Dirk Engels Websolutions. All rights reserved.
 * @author Dirk Engels <d.engels@dirkengels.com>
 * @license https://github.com/DirkEngels/PhpRestService/blob/master/doc/LICENSE
 *
 * @group PhpRestService
 * @group PhpRestService-Resource
 * @group PhpRestService-Resource-Factory
 */

namespace PhpRestService\Resource;

class FactoryTest extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
    }

    protected function tearDown() {
    }

    public function testFactoryGetWithTaskName() {
        $this->assertTrue(TRUE);
    }

    public function testFactoryGet() {
        $manager = \PhpRestService\Resource\Factory::get('Blog\\Post');
        $this->assertInstanceOf('\\PhpRestService\\Resource\\Manager\\ManagerAbstract', $manager);
    }

    public function testFactoryGetManager() {
        $manager = \PhpRestService\Resource\Factory::getManager('Blog\\Post');
        $this->assertInstanceOf('\\PhpRestService\\Resource\\Manager\\ManagerAbstract', $manager);
    }

    public function testFactoryGetDataCollection() {
        $collection = \PhpRestService\Resource\Factory::getDataCollection('Blog\\Post');
        $this->assertInstanceOf('\\PhpRestService\\Resource\\Data\\Collection', $collection);
    }

    public function testFactoryGetDataItem() {
        $item = \PhpRestService\Resource\Factory::getDataItem('Blog\\Post');
        $this->assertInstanceOf('\\PhpRestService\\Resource\\Data\\Item', $item);
    }

    public function testFactoryGetDisplay() {
        $display = \PhpRestService\Resource\Factory::getDisplay('Blog\\Post');
        $this->assertInstanceOf('\\PhpRestService\\Resource\\Display\\DisplayAbstract', $display);
    }

    public function testFactoryGetFormat() {
        $format = \PhpRestService\Resource\Factory::getFormat('Blog\\Post');
        $this->assertInstanceOf('\\PhpRestService\\Resource\\Format\\FormatAbstract', $format);
    }
}