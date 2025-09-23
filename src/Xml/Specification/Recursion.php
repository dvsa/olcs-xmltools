<?php

namespace Olcs\XmlTools\Xml\Specification;

use Olcs\XmlTools\Xml\ElementIterator;
use Olcs\XmlTools\Xml\NodeListIterator;
use Olcs\XmlTools\Xml\TagNameFilterIterator;
use Laminas\Stdlib\ArrayUtils;

/**
 * Class Recursion
 * @package Olcs\XmlTools\Xml\Specification
 */
class Recursion implements SpecificationInterface
{
    /**
     * @var array
     */
    protected $specification = [];

    /**
     * @param $specification
     */
    public function __construct($specification, $instructions = null)
    {
        if (is_array($specification)) {
            $this->specification = $specification;
        } elseif (is_string($specification) && $instructions !== null) {
            $this->specification = [$specification => $instructions];
        }
    }

    /**
     * @return array
     */
    public function getSpecification()
    {
        return $this->specification;
    }

    /**
     * @return array
     */
    #[\Override]
    public function apply(\DOMElement $domElement)
    {
        $result = [];
        $specification = $this->getSpecification();

        // Apply inline specs (numeric keys) to the *current* element
        foreach ($specification as $key => $instruction) {
            if (!is_int($key)) {
                continue;
            }
            // $instruction can be a single spec or an array of specs
            $instructions = is_array($instruction) ? $instruction : [$instruction];
            foreach ($instructions as $inst) {
                /** @var SpecificationInterface $inst */
                $result = ArrayUtils::merge($result, $inst->apply($domElement));
            }
        }

        // Recurse into children for string-keyed specs (existing behaviour)
        // Build the list of tag names to look for (string keys only)
        $tagNames = array_filter(array_keys($specification), 'is_string');

        $nodeList = $domElement->childNodes;
        $iterator = new NodeListIterator($nodeList);
        $iterator = new ElementIterator($iterator);
        $iterator = new TagNameFilterIterator($iterator, array_keys($specification));

        /** @var \DOMElement $element */
        foreach ($iterator as $element) {
            $childSpec = $specification[$element->tagName];
            $childSpecs = is_array($childSpec) ? $childSpec : [$childSpec];

            foreach ($childSpecs as $instruction) {
                /** @var SpecificationInterface $instruction */
                $result = \Laminas\Stdlib\ArrayUtils::merge($result, $instruction->apply($element));
            }
        }

        return $result;
    }
}
