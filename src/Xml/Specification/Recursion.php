<?php

namespace Olcs\XmlTools\Xml\Specification;

use Olcs\XmlTools\Xml\ElementIterator;
use Olcs\XmlTools\Xml\NodeListIterator;
use Olcs\XmlTools\Xml\TagNameFilterIterator;
use Zend\Stdlib\ArrayUtils;

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
     * @param \DomElement $parentElement
     * @return array
     */
    public function apply(\DomElement $parentElement)
    {
        $result = [];
        $specification = $this->getSpecification();
        $nodeList = $parentElement->childNodes;

        $iterator = new NodeListIterator($nodeList);
        $iterator = new ElementIterator($iterator);
        $iterator = new TagNameFilterIterator($iterator, array_keys($specification));

        foreach ($iterator as $element) {
            $spec = $specification[$element->tagName];
            if (!is_array($spec)) {
                $spec = [$spec];
            }

            foreach ($spec as $instruction) {
                /** @var SpecificationInterface $instruction */
                $result = ArrayUtils::merge($result, $instruction->apply($element));
            }
        }

        return $result;
    }
}
