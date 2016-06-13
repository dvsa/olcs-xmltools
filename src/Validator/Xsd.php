<?php

namespace Olcs\XmlTools\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;
use DOMDocument;

/**
 * Class Xsd
 * @package Olcs\XmlTools\Validator
 */
class Xsd extends AbstractValidator
{
    const INVALID_XML = 'invalid-xml';

    /**
     * An array containing mappings of url xsd's to local file paths
     *
     * @var array
     */
    protected $mappings = [];

    /**
     * Filepath to Xsd schema
     *
     * @var string
     */
    protected $xsd;

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_XML => 'There was a problem validating your xml file:'
    ];

    /**
     * @param mixed $xsd
     * @return $this
     */
    public function setXsd($xsd)
    {
        $this->xsd = $xsd;
    }

    /**
     * @return mixed
     */
    public function getXsd()
    {
        return $this->xsd;
    }

    /**
     * @param array $mappings
     * @return $this
     */
    public function setMappings($mappings)
    {
        $this->mappings = $mappings;
    }

    /**
     * @return array
     */
    public function getMappings()
    {
        return $this->mappings;
    }

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  string $value Filepath to xml document
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        $this->setValue($value);

        $restore = libxml_use_internal_errors(true);

        $this->setupEntityLoader();

        $valid = $value->schemaValidate($this->getXsd());

        if (!$valid) {
            $this->error(self::INVALID_XML);
            $errors = libxml_get_errors();
            foreach ($errors as $error) {
                $this->abstractOptions['messages'][] = sprintf(
                    'XML error "%s" [%d] (Code %d) in %s on line %d column %d' . "\n",
                    $error->message,
                    $error->level,
                    $error->code,
                    $error->file,
                    $error->line,
                    $error->column
                );
            }
            libxml_clear_errors();
        }

        libxml_use_internal_errors($restore);

        return $valid;
    }

    protected function setupEntityLoader()
    {
        $mapping = $this->getMappings();

        libxml_set_external_entity_loader(
            function ($public, $system, $context) use ($mapping) {

                if (is_file($system)) {
                    return $system;
                }

                if (isset($mapping[$system])) {
                    return $mapping[$system];
                }

                $message = sprintf(
                    "Failed to load external entity: Public: %s; System: %s; Context: %s",
                    var_export($public, 1), var_export($system, 1),
                    strtr(var_export($context, 1), [" (\n  " => '(', "\n " => '', "\n" => ''])
                );

                throw new \RuntimeException($message);
            }
        );
    }
}
