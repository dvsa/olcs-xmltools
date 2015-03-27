<?php


namespace OlcsTest\XmlTools\Filter;

use Mockery\Adapter\Phpunit\MockeryTestCase as TestCase;
use Mockery as m;
use Olcs\XmlTools\Filter\MapXmlFile;

/**
 * Class MapXmlFileTest
 * @package OlcsTest\XmlTools\Filter
 */
class MapXmlFileTest extends TestCase
{
    public function testFilter()
    {
        $value = new \DOMDocument();
        $value->loadXML('<Doc></Doc>');

        $mapped = ['other' => 'data'];

        $mockMapper = m::mock('Olcs\XmlTools\Xml\Specification\SpecificationInterface');
        $mockMapper->shouldReceive('apply')->andReturn($mapped);

        $sut = new MapXmlFile();
        $sut->setMapping($mockMapper);

        $this->assertEquals($mapped, $sut->filter($value));
    }
}
