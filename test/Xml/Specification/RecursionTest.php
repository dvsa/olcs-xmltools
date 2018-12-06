<?php


namespace OlcsTest\XmlTools\Xml\Specification;

use Olcs\XmlTools\Xml\Specification\NodeValue;
use Olcs\XmlTools\Xml\Specification\Recursion;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Class RecursionTest
 *
 * Also covers iterator classes used internally by recursion algorithm
 *
 * @package OlcsTest\XmlTools\Xml\Specification
 */
class RecursionTest extends TestCase
{
    public function testApply()
    {
        $dom = new \DOMDocument();
        $xml = '<Doc><TestTag>Value</TestTag><OtherTag>this is not the value you are looking for</OtherTag></Doc>';
        $dom->loadXML($xml);

        $sut = new Recursion(['TestTag' => [new NodeValue('testprop')]]);

        $result = $sut->apply($dom->documentElement);

        $this->assertEquals(['testprop' => 'Value'], $result);
    }

    public function testApplyWithShorthands()
    {
        $dom = new \DOMDocument();
        $xml = '<Doc><TestTag>Value</TestTag><OtherTag>this is not the value you are looking for</OtherTag></Doc>';
        $dom->loadXML($xml);

        $sut = new Recursion('TestTag', new NodeValue('testprop'));

        $result = $sut->apply($dom->documentElement);

        $this->assertEquals(['testprop' => 'Value'], $result);
    }
}
