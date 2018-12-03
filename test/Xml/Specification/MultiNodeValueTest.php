<?php


namespace OlcsTest\XmlTools\Xml\Specification;

use Olcs\XmlTools\Xml\Specification\MultiNodeValue;

/**
 * Class MultiNodeValueTest
 * @package OlcsTest\XmlTools\Xml\Specification
 */
class MultiNodeValueTest extends \PHPUnit\Framework\TestCase
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
