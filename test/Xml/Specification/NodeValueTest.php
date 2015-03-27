<?php


namespace OlcsTest\XmlTools\Xml\Specification;

use Olcs\XmlTools\Xml\Specification\NodeValue;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Class NodeValueTest
 * @package OlcsTest\XmlTools\Xml\Specification
 */
class NodeValueTest extends TestCase
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
