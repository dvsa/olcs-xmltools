<?php

namespace OlcsTest\XmlTools\Xml\Specification;

use Olcs\XmlTools\Xml\Specification\SpecificationInterface;
use Olcs\XmlTools\Xml\Specification\MultiRecursionValue;
use Mockery\Adapter\Phpunit\MockeryTestCase as TestCase;
use Mockery as m;

/**
 * Class MultiRecursionValueTest
 * @package OlcsTest\XmlTools\Xml\Specification
 */
class MultiRecursionValueTest extends TestCase
{
    public function testApply()
    {
        $nodeValue = 'hello';
        $expectedResult = [
            'testprop' => [
                0 => [$nodeValue]
            ]
        ];

        $document = new \DOMDocument();
        $element = $document->createElement('Test');
        $element->nodeValue = $nodeValue;

        $recursion = m::mock(SpecificationInterface::class);
        $recursion->shouldReceive('apply')->with($element)->andReturn([$nodeValue]);

        $sut = new MultiRecursionValue('testprop', $recursion);
        $sut->apply($element);

        $result = $sut->apply($element);

        $this->assertEquals($expectedResult, $result);
    }
}
