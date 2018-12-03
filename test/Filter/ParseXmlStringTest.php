<?php

namespace OlcsTest\XmlTools\Filter;

use Olcs\XmlTools\Filter\ParseXmlString;

/**
 * Class ParseXmlStringTest
 * @package OlcsTest\XmlTools\src\Filter
 */
class ParseXmlStringTest extends \PHPUnit\Framework\TestCase
{
    public function testFilter()
    {
        $xml = '<test></test>';

        $sut = new ParseXmlString();

        $dom = $sut->filter($xml);

        $this->assertInstanceOf('DOMDocument', $dom);
    }
}
