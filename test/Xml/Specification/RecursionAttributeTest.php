<?php

namespace OlcsTest\XmlTools\Xml\Specification;

use Olcs\XmlTools\Xml\Specification\NodeAttribute;
use Olcs\XmlTools\Xml\Specification\RecursionAttribute;

/**
 * Class RecursionAttributeTest
 *
 * Also covers iterator classes used internally by recursion algorithm
 *
 * @package OlcsTest\XmlTools\Xml\Specification
 */
class RecursionAttributeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests the apply function
     */
    public function testApply()
    {
        $value = 'Value';
        $value2 = 'Value2';

        $expectedResult = [
            0 => [
                'value' => $value,
                'value2' => $value2
            ]
        ];

        $spec = [
            new NodeAttribute('value', 'value'),
            new NodeAttribute('value2', 'value2'),
        ];

        $dom = new \DOMDocument();
        $xml = '<Doc><TestTag value="' . $value . '" value2="' . $value2 . '"></TestTag>
        <OtherTag value="this is not the value you are looking for"></OtherTag></Doc>';
        $dom->loadXML($xml);

        $sut = new RecursionAttribute(['TestTag' => $spec]);

        $result = $sut->apply($dom->documentElement);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Tests the apply function
     */
    public function testApplyWithShorthands()
    {
        $value = 'Value';
        $value2 = 'Value2';

        $expectedResult = [
            0 => [
                'value' => $value
            ]
        ];

        $spec = new NodeAttribute('value', 'value');

        $dom = new \DOMDocument();
        $xml = '<Doc><TestTag value="' . $value . '" value2="' . $value2 . '"></TestTag>
        <OtherTag value="this is not the value you are looking for"></OtherTag></Doc>';
        $dom->loadXML($xml);

        $sut = new RecursionAttribute('TestTag', $spec);

        $result = $sut->apply($dom->documentElement);

        $this->assertEquals($expectedResult, $result);
    }
}
