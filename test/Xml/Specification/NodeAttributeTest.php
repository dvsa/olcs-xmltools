<?php

namespace OlcsTest\XmlTools\Xml\Specification;

use Olcs\XmlTools\Xml\Specification\NodeAttribute;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Class NodeAttributeTest
 * @package OlcsTest\XmlTools\Xml\Specification
 */
class NodeAttributeTest extends TestCase
{
    public function testApply()
    {
        $document = new \DOMDocument();
        $element = $document->createElement('Test');
        $element->setAttribute('id', 74);

        $sut = new NodeAttribute('testprop', 'id');

        $result = $sut->apply($element);

        $this->assertEquals(['testprop' => 74], $result);
    }
}
