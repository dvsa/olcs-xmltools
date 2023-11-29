<?php

namespace Olcs\XmlTools\Xml\Specification;

/**
 * Class AbstractCapturingNode
 * @package Olcs\XmlTools\Xml\Specification
 */
abstract class AbstractCapturingNode implements SpecificationInterface
{
    /**
     * @var string
     */
    protected $destination;

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param $capturedValue
     * @return array
     */
    protected function createReturnValue($capturedValue)
    {
        $destination = $this->getDestination();

        if (is_array($destination)) {
            $value = $capturedValue;
            foreach (array_reverse($destination) as $fieldName) {
                $tmp = $value;
                $value = [];
                $value[$fieldName] = $tmp;
            }

            return $value;
        }

        return [$destination => $capturedValue];
    }
}
