<?php

namespace Olcs\XmlTools\Xml\Specification;

/**
 * Class NodeAttribute
 * @package Olcs\XmlTools\Xml\Specification
 */
class NodeAttribute extends AbstractCapturingNode
{
    /**
     * @var string
     */
    protected $property;

    /**
     * @param $destination
     * @param $property
     */
    public function __construct($destination, $property)
    {
        $this->destination = $destination;
        $this->property = $property;
    }

    /**
     * @return mixed
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param \DOMElement $element
     * @return array
     */
    public function apply(\DOMElement $element)
    {
        return $this->createReturnValue($element->getAttribute($this->getProperty()));
    }
}
