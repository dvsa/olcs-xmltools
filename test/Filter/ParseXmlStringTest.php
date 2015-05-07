<?php

namespace OlcsTest\XmlTools\Filter;

use Olcs\XmlTools\Filter\ParseXmlString;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Class ParseXmlStringTest
 * @package OlcsTest\XmlTools\src\Filter
 */
class ParseXmlStringTest extends TestCase
{
    public function testFilter()
    {
        $xml = '<test></test>';

        $sut = new ParseXmlString();

        $dom = $sut->filter($xml);

        $this->assertInstanceOf('DomDocument', $dom);
    }
}
