<?php

namespace Olcs\XmlTools\Filter;

use Olcs\XmlTools\Xml\Specification\SpecificationInterface;
use Laminas\Filter\AbstractFilter;
use Laminas\Filter\Exception;

/**
 * Class MapXmlFile
 * @package Olcs\XmlTools\Filter
 */
class MapXmlFile extends AbstractFilter
{
    /**
     * @var SpecificationInterface
     */
    protected $mapping;

    /**
     * @return SpecificationInterface
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    public function setMapping(SpecificationInterface $specification): void
    {
        $this->mapping = $specification;
    }

    /**
     * Returns the result of filtering $value
     *
     * @param  mixed $value
     * @throws Exception\RuntimeException If filtering $value is impossible
     * @return mixed
     */
    public function filter($value, $context = [])
    {
        return $this->getMapping()->apply($value->documentElement);
    }
}
