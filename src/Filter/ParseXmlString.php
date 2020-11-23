<?php

namespace Olcs\XmlTools\Filter;

use Laminas\Filter\AbstractFilter;
use Laminas\Filter\Exception;
use DOMDocument;
use Laminas\Xml\Security;

/**
 * Class ParseXmlString
 * @package Olcs\XmlTools\Filter
 */
class ParseXmlString extends AbstractFilter
{
    /**
     * Returns the result of filtering $value
     *
     * @param  mixed $value
     * @throws Exception\RuntimeException If filtering $value is impossible
     * @return mixed
     */
    public function filter($value)
    {
        $dom = new DOMDocument();
        Security::scan($value, $dom);

        return $dom;
    }
}
