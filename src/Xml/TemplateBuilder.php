<?php

namespace Olcs\XmlTools\Xml;

/**
 * Utility class for creating a templated xml string
 *
 * Class TemplateBuilder
 * @package Olcs\XmlTools\Xml
 */
class TemplateBuilder
{
    /**
     * @param $templatePath
     * @param array $substitutions
     * @return string
     */
    public function buildTemplate($templatePath, array $substitutions)
    {
        $dom = new \DOMDocument();
        $dom->load($templatePath);

        foreach ($substitutions as $key => $value) {
            $dom->getElementsByTagName($key)->item(0)->nodeValue = $value;
        }

        return $dom->saveXML();
    }
}
