<?php

namespace OlcsTest\XmlTools\Validator;

use Olcs\XmlTools\Validator\XsdFactory;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase as TestCase;

/**
 * Class XsdFactoryTest
 * @package OlcsTest\XmlTools\src\Validator
 */
class XsdFactoryTest extends TestCase
{
    public function testCreateService()
    {
        $config = ['xsd_mappings' => ['test'=> 'test.path']];

        $mockSl = m::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $mockSl->shouldReceive('getServiceLocator->get')->with('Config')->andReturn($config);

        $sut = new XsdFactory();

        $service = $sut->createService($mockSl);

        $this->assertInstanceOf('Olcs\XmlTools\Validator\Xsd', $service);
        $this->assertEquals($config['xsd_mappings'], $service->getMappings());
    }
}
