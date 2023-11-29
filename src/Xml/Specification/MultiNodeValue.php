<?php

namespace Olcs\XmlTools\Xml\Specification;

/**
 * Class MultiNodeValue
 * @package Olcs\XmlTools\Xml\Specification
 */
class MultiNodeValue extends AbstractCapturingNode
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
        return $this->createReturnValue([$element->nodeValue]);
    }
}
