<?php

namespace Olcs\XmlTools\Xml\Specification;

/**
 * Interface SpecificationInterface
 * @package Olcs\XmlTools\Xml\Specification
 */
interface SpecificationInterface
{
    /**
     * @param \DOMElement $element
     * @return mixed
     */
    public function apply(\DOMElement $element);
}
