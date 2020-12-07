<?php

namespace Olcs\XmlTools\Filter;

use Laminas\Filter\AbstractFilter;
use Laminas\Filter\Exception;
use DOMDocument;
use Laminas\Xml\Security;

/**
 * Class ParseXml
 * @package Olcs\XmlTools\Filter
 */
class ParseXml extends AbstractFilter
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
        Security::scan(file_get_contents($value), $dom);

        return $dom;
    }
}
