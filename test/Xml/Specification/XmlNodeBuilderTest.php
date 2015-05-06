<?php

namespace OlcsTest\XmlTools\Xml;

use Olcs\XmlTools\Xml\XmlNodeBuilder;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Class XmlNodeBuilderTest
 * @package XmlTools\src\Xml
 */
class XmlNodeBuilderTest extends TestCase
{
    public function testBuildTemplate()
    {
        $parentElement = 'ParentElement';
        $ns = 'https://webgate.ec.testa.eu/erru/1.0';

        $input = [
            'Body' => [
                'name' => 'Body',
                'attributes' => [
                    'attributeOne' => 'FirstAttribute',
                    'attributeTwo' => 'SecondAttribute',
                ],
                'nodes' => [
                    0 => [
                        'name' => 'FirstNode',
                        'value' => 'valueOne'
                    ],
                    1 => [
                        'name' => 'SecondNode',
                        'value' => 'valueTwo'
                    ]
                ]
            ]
        ];

        $expectedReturn = '<?xml version="1.0" encoding="UTF-8"?>
                            <' . $parentElement . ' xmlns="' . $ns . '">
                              <Body attributeOne="FirstAttribute" attributeTwo="SecondAttribute">
                                <FirstNode>valueOne</FirstNode>
                                  <SecondNode>valueTwo</SecondNode>
                              </Body>
                            </' . $parentElement . '>';

        $sut = new XmlNodeBuilder($parentElement, $ns, $input);
        $this->assertXmlStringEqualsXmlString($expectedReturn, $sut->buildTemplate());
    }
}
