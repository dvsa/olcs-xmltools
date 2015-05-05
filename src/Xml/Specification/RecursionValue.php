<?php

namespace Olcs\XmlTools\Xml\Specification;

/**
 * Class RecursionValue
 * @package Olcs\XmlTools\Xml\Specification
 */
class RecursionValue extends AbstractCapturingNode
{
    protected $recursion;
    /**
     * @param $destination
     * @param SpecificationInterface $recursion
     */
    public function __construct($destination, SpecificationInterface $recursion)
    {
        $this->destination = $destination;
        $this->recursion = $recursion;
    }

    /**
     * @return Recursion
     */
    public function getRecursion()
    {
        return $this->recursion;
    }

    /**
     * @param \DOMElement $element
     * @return array
     */
    public function apply(\DOMElement $element)
    {
        return $this->createReturnValue($this->getRecursion()->apply($element));
    }
}
