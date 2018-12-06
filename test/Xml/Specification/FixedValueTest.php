<?php


namespace OlcsTest\XmlTools\Xml\Specification;

use Olcs\XmlTools\Xml\Specification\FixedValue;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Class FixedValueTest
 * @package OlcsTest\XmlTools\Xml\Specification
 */
class FixedValueTest extends TestCase
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
