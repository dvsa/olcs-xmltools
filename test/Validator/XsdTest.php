<?php

namespace OlcsTest\XmlTools\Validator;

use Olcs\XmlTools\Validator\Xsd;
use org\bovigo\vfs\vfsStream;
use PHPUnit_Framework_TestCase as TestCase;
use DomDocument;

/**
 * Class XsdTest
 * @package OlcsTest\XmlTools\src\Validator
 */
class XsdTest extends TestCase
{
    protected $xsd = <<<XSD
<?xml version="1.0" encoding="UTF-8" ?>
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema">
 <xs:element name="test" type="xs:string" />
</xs:schema>
XSD;

    /**
     * @dataProvider provideIsValid
     * @param $xml
     * @param $valid
     */
    public function testIsValid($xml, $valid)
    {
        vfsStream::setup('root');
        $xsdFile = vfsStream::url('root/xsdfile.xsd');

        file_put_contents($xsdFile, $this->xsd);

        $dom = new DomDocument();
        $dom->loadXml($xml);

        $sut = new Xsd();
        $sut->setMappings(
            [
                'http://schemafile.com/xsdfile.xsd' => $xsdFile,
                'http://www.w3.org/2001/XMLSchema' => __DIR__ . '/../../../../data/xsd/xml.xsd'
                ]
        );
        $sut->setXsd('http://schemafile.com/xsdfile.xsd');
        $this->assertEquals($valid, $sut->isValid($dom));
    }

    public function provideIsValid()
    {
        return [
            ['<doc><test></test><test></test></doc>', false],
            ['<test></test>', true],
            ['<test>Hello</test>', true]
        ];
    }

    public function testIsValidWithoutMapping()
    {
        $xml = new DomDocument();
        $xml->loadXML('<test></test>');
        $valid = true;

        vfsStream::setup('root');
        $xsdFile = vfsStream::url('root/xsdfile.xsd');

        file_put_contents($xsdFile, $this->xsd);

        $sut = new Xsd();
        $sut->setMappings(
            ['http://www.w3.org/2001/XMLSchema' => __DIR__ . '/../../../../data/xsd/xml.xsd']
        );
        $sut->setXsd($xsdFile);
        $this->assertEquals($valid, $sut->isValid($xml));
    }

    public function testIsValidWithInvalidXsd()
    {
        $xml = new DomDocument();
        $xml->loadXML('<test></test>');
        $valid = true;

        vfsStream::setup('root');
        $xsdFile = vfsStream::url('root/xsdfile.xsd');

        $sut = new Xsd();
        $sut->setMappings(
            ['http://www.w3.org/2001/XMLSchema' => __DIR__ . '/../../../../data/xsd/xml.xsd']
        );
        $sut->setXsd($xsdFile);

        $passed = false;
        try {
            $this->assertEquals($valid, $sut->isValid($xml));
        } catch (\RuntimeException $e) {
            $expectedMessage = 'Failed to load external entity:';
            if (substr($e->getMessage(), 0, strlen($expectedMessage)) == $expectedMessage) {
                $passed = true;
            }
        }

        $this->assertTrue($passed, 'Expected exception not thrown');
    }
}
