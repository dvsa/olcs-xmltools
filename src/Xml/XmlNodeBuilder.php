<?php

namespace Olcs\XmlTools\Xml;

/**
 * Utility class for creating XML from an array of data
 *
 * Class XmlNodeBuilder
 * @package Olcs\XmlTools\Xml
 */
class XmlNodeBuilder extends \DOMDocument
{
    /**
     * @var String
     */
    private $rootElement;

    /**
     * @var Array
     */
    private $data;

    /**
     * @var
     */
    private $xmlNs;

    /**
     * @return String
     */
    public function getRootElement()
    {
        return $this->rootElement;
    }

    /**
     * @param String $rootElement
     */
    public function setRootElement($rootElement)
    {
        $this->rootElement = $rootElement;
    }

    /**
     * @return Array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param Array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return String
     */
    public function getXmlNs()
    {
        return $this->xmlNs;
    }

    /**
     * @param String $xmlNs
     */
    public function setXmlNs($xmlNs)
    {
        $this->xmlNs = $xmlNs;
    }

    /**
     * @param $rootElement
     * @param $xmlNs
     * @param array $data
     */
    public function __construct($rootElement, $xmlNs, array $data)
    {
        parent:: __construct('1.0', 'UTF-8');

        $this->setRootElement($rootElement);
        $this->setXmlNs($xmlNs);
        $this->setData($data);
        $this->formatOutput = true;
    }

    /**
     * @return mixed
     */
    public function buildTemplate()
    {
        $rootElement = $this->createElementNs($this->getXmlNs(), $this->getRootElement());
        $document = $this->createFromArray($this->getData(), $rootElement);
        $this->appendChild($document);

        return $this->saveXML();
    }

    /**
     * Creates the XML document, requires an array of data and a parent element
     *
     * @param array $data
     * @param \DOMElement $domElement
     * @return \DOMElement
     */
    private function createFromArray(array $data, \DOMElement $domElement = null)
    {
        foreach ($data as $element => $values) {
            //create the element, and give it a value is it has one
            if (isset($values['value'])) {
                $newElement = $this->createElement($values['name'], $values['value']);
            } else {
                $newElement = $this->createElement($values['name']);
            }

            //if the element has attributes, create them first
            if (isset($values['attributes'])) {
                foreach ($values['attributes'] as $attribute => $attributeValue) {
                    $newElement->setAttribute($attribute, $attributeValue);
                }
            }

            //if the element has child nodes
            if(isset($values['nodes'])) {
                self::createFromArray($values['nodes'], $newElement);
            }

            $domElement->appendChild($newElement);
        }

        return $domElement;
    }
}
