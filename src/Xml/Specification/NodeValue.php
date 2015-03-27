<?php

namespace Olcs\XmlTools\Xml\Specification;

/**
 * Class NodeValue
 * @package Olcs\XmlTools\Xml\Specification
 */
class NodeValue extends AbstractCapturingNode
{
    /**
     * @param $destination
     */
    public function __construct($destination)
    {
        $this->destination = $destination;
    }

    /**
     * @param \DOMElement $element
     * @return array
     */
    public function apply(\DOMElement $element)
    {
        return $this->createReturnValue($element->nodeValue);
    }
}
