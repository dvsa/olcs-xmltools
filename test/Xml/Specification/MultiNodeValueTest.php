<?php


namespace OlcsTest\XmlTools\Xml\Specification;

use Olcs\XmlTools\Xml\Specification\MultiNodeValue;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Class MultiNodeValueTest
 * @package OlcsTest\XmlTools\Xml\Specification
 */
class MultiNodeValueTest extends TestCase
{
    public function testApply()
    {
        $document = new \DOMDocument();
        $element = $document->createElement('Test');
        $element->nodeValue = 'hello';

        $sut = new MultiNodeValue('testprop');

        $result = $sut->apply($element);

        $this->assertEquals(['testprop' => ['hello']], $result);
    }
}
