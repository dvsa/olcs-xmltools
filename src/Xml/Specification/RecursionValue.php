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
     */
    public function __construct($destination, SpecificationInterface $specification)
    {
        $this->destination = $destination;
        $this->recursion = $specification;
    }

    /**
     * @return Recursion
     */
    public function getRecursion()
    {
        return $this->recursion;
    }

    /**
     * @return array
     */
    public function apply(\DOMElement $domElement)
    {
        return $this->createReturnValue($this->getRecursion()->apply($domElement));
    }
}
