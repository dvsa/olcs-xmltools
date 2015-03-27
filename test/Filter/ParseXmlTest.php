<?php


namespace OlcsTest\XmlTools\Filter;

use Olcs\XmlTools\Filter\ParseXml;
use PHPUnit_Framework_TestCase as TestCase;
use org\bovigo\vfs\vfsStream;

/**
 * Class ParseXmlTest
 * @package OlcsTest\XmlTools\src\Filter
 */
class ParseXmlTest extends TestCase
{
    public function testFilter()
    {
        $xml = '<test></test>';

        vfsStream::setup('root');
        $xmlFile = vfsStream::url('root/xmlfile.xml');

        file_put_contents($xmlFile, $xml);

        $sut = new ParseXml();

        $dom = $sut->filter($xmlFile);

        $this->assertInstanceOf('DomDocument', $dom);
    }
}
