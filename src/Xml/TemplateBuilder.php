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
     * Build XML from a template by substituting in values for an individual node
     *
     * @param string $templatePath  path to template
     * @param array  $substitutions values to be substituted
     *
     * @return string
     */
    public function buildTemplate($templatePath, array $substitutions)
    {
        $dom = new \DOMDocument();
        $dom->load($templatePath);

        foreach ($substitutions as $key => $value) {
            $dom->getElementsByTagName($key)->item(0)->nodeValue = htmlspecialchars($value);
        }

        return $dom->saveXML();
    }
}
