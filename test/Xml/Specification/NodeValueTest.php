<?php

namespace OlcsTest\XmlTools\Xml\Specification;

use Olcs\XmlTools\Xml\Specification\NodeValue;

/**
 * Class NodeValueTest
 * @package OlcsTest\XmlTools\Xml\Specification
 */
class NodeValueTest extends \PHPUnit\Framework\TestCase
{
    public function testApply()
    {
        $document = new \DOMDocument();
        $element = $document->createElement('Test');
        $element->nodeValue = 'hello';

        $sut = new NodeValue('testprop');

        $result = $sut->apply($element);

        $this->assertEquals(['testprop' => 'hello'], $result);
    }
}
