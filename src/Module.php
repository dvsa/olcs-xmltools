<?php

namespace Olcs\XmlTools;
use Olcs\XmlTools\Validator\Xsd;
use Olcs\XmlTools\Validator\XsdFactory;
use Olcs\XmlTools\Filter\MapXmlFile;
use Olcs\XmlTools\Filter\ParseXml;

/**
 * Class Module
 * @package Dvsa\Jackrabbit\Doctrine\Client
 */
class Module
{
    /**
     * @return array
     * @codeCoverageIgnore No value in testing a method which returns config.
     */
    public function getConfig()
    {
        return [
            'filters' => [
                'factories' => [
                    Xsd::class => XsdFactory::class
                ]
            ],
            'validators' => [
                'invokables' => [
                    MapXmlFile::class => MapXmlFile::class,
                    ParseXml::class => ParseXml::class
                ]
            ]
        ];
    }

    /**
     * Empty on purpose to defer loading to composer
     * @codeCoverageIgnore No value in testing an empty method
     */
    public function getAutoloaderConfig()
    {

    }
}
