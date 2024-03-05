<?php

namespace OlcsTest\XmlTools\Xml\Specification;

use Olcs\XmlTools\Xml\Specification\NodeValue;
use Olcs\XmlTools\Xml\Specification\Recursion;

/**
 * Class RecursionTest
 *
 * Also covers iterator classes used internally by recursion algorithm
 *
 * @package OlcsTest\XmlTools\Xml\Specification
 */
class RecursionTest extends \PHPUnit\Framework\TestCase
{
    public function testApply(): void
    {
        $domDocument = new \DOMDocument();
        $xml = '<Doc><TestTag>Value</TestTag><OtherTag>this is not the value you are looking for</OtherTag></Doc>';
        $domDocument->loadXML($xml);

        $recursion = new Recursion(['TestTag' => [new NodeValue('testprop')]]);

        $result = $recursion->apply($domDocument->documentElement);

        $this->assertEquals(['testprop' => 'Value'], $result);
    }

    public function testApplyWithShorthands(): void
    {
        $domDocument = new \DOMDocument();
        $xml = '<Doc><TestTag>Value</TestTag><OtherTag>this is not the value you are looking for</OtherTag></Doc>';
        $domDocument->loadXML($xml);

        $recursion = new Recursion('TestTag', new NodeValue('testprop'));

        $result = $recursion->apply($domDocument->documentElement);

        $this->assertEquals(['testprop' => 'Value'], $result);
    }
}
