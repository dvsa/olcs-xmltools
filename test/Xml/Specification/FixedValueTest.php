<?php


namespace OlcsTest\XmlTools\Xml\Specification;

use Olcs\XmlTools\Xml\Specification\FixedValue;

/**
 * Class FixedValueTest
 * @package OlcsTest\XmlTools\Xml\Specification
 */
class FixedValueTest extends \PHPUnit\Framework\TestCase
{
    public function testApply()
    {
        $document = new \DOMDocument();
        $element = $document->createElement('Test');
        $element->nodeValue = 'hello';

        $sut = new FixedValue(['destination', 'as', 'array'], 'value');

        $result = $sut->apply($element);

        $this->assertSame(['destination' => ['as' => ['array' => 'value']]], $result);
    }
}
