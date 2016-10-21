<?php

namespace Olcs\XmlTools\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

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
     * The maximum number of schema errors to return, defaults to 3 (prevents massive error messages)
     *
     * @var int
     */
    protected $maxErrors = 3;

    /**
     * Array of message templates
     *
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_XML => 'Your xml file didn\'t validate against the schema (first %value% errors shown)'
    ];

    /**
     * Sets the xsd
     *
     * @param mixed $xsd the xsd
     *
     * @return void
     */
    public function setXsd($xsd)
    {
        $this->xsd = $xsd;
    }

    /**
     * Gets the xsd
     *
     * @return mixed
     */
    public function getXsd()
    {
        return $this->xsd;
    }

    /**
     * Sets xsd mappings
     *
     * @param array $mappings xsd mappings
     *
     * @return $this
     */
    public function setMappings($mappings)
    {
        $this->mappings = $mappings;
    }

    /**
     * Gets xsd mappings
     *
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
     * @param string $value Filepath to xml document
     *
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
            $errors = $this->getXmlErrors();

            $totalErrors = count($errors);
            $numShownErrors = ($totalErrors > $this->maxErrors ? $this->maxErrors : $totalErrors);

            $this->error(self::INVALID_XML, $numShownErrors);

            $errorCounter = 0;

            //we're counting from zero, so we stop at one below the total number we need
            while ($errorCounter < $numShownErrors) {
                $error = $errors[$errorCounter];

                $this->abstractOptions['messages'][] = sprintf(
                    'XML error "%s" on line %d column %d',
                    $error->message,
                    $error->line,
                    $error->column
                );

                $errorCounter++;
            }

            libxml_clear_errors();
        }

        libxml_use_internal_errors($restore);

        return $valid;
    }

    /**
     * setup entity loader
     *
     * @return void
     * @throws \RuntimeException
     */
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

    /**
     * Returns an array of xml schema errors (this function is to aid unit testing)
     *
     * @return array
     */
    public function getXmlErrors()
    {
        return libxml_get_errors();
    }

    /**
     * Sets the maximum number of errors to return
     *
     * @param int $maxErrors number of errors to return
     *
     * @return void
     */
    public function setMaxErrors($maxErrors)
    {
        $this->maxErrors = $maxErrors;
    }

    /**
     * Gets the maximum number of errors to return
     *
     * @return int
     */
    public function getMaxErrors()
    {
        return $this->maxErrors;
    }
}
